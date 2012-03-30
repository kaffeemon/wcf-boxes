<?php
namespace wcf\acp\form;
use \wcf\system\language\I18nHandler;
use \wcf\page\util\InstantOptionHelper;
use \wcf\system\exception\UserInputException;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\util\BoxUtil;
use \wcf\util\StringUtil;
use \wcf\util\ClassUtil;
use \wcf\system\menu\acp\ACPMenu;
use \wcf\system\WCF;

/**
 * Shows the box add form.
 *
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	acp.form
 */
class BoxAddForm extends ACPForm {
	/**
	 * @see \wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'boxAdd';
	
	/**
	 * @see \wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.box.add';
	
	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array(
		'admin.content.box.canAdd'
	);
	
	public $action = 'add';
	
	public $name = '';
	public $title = '';
	public $boxTypeID = 0;
	public $style = 'title';
	public $optionHelper;
	
	public static $availableStyles = array(
		'title' => 'wcf.acp.box.style.title',
		'border' => 'wcf.acp.box.style.border',
		'blank' => 'wcf.acp.box.style.blank'
	);
	
	/**
	 * @see \wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if ($this->action == 'add') {
			if (!empty($_REQUEST['boxTypeID']))
				$this->boxTypeID = StringUtil::trim($_REQUEST['boxTypeID']);
			
			if (empty($this->boxTypeID) || !BoxUtil::isValidBoxType($this->boxTypeID)) {
				ACPMenu::getInstance()->setActiveMenuItem($this->activeMenuItem);
				
				WCF::getTPL()->assign(array(
					'availableBoxTypes' => BoxUtil::getBoxTypes(),
					'templateName' => 'boxTypeSelect'
				));
				WCF::getTPL()->display('boxTypeSelect');
				exit;
			}
			
			$boxType = ObjectTypeCache::getInstance()->getObjectType($this->boxTypeID)->boxTypeClassName;
			$boxTypeTitle = ObjectTypeCache::getInstance()->getObjectType($this->boxTypeID)->boxTypeTitle;
			$this->optionHelper = new InstantOptionHandler('options', $boxTypeTitle);
			$this->optionHelper->registerOptions($boxType::getOptions());
		}
			
		
		I18nHandler::getInstance()->register('title');
	}
	
	/**
	 * @see \wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (!empty($_POST['name']))
			$this->name = StringUtil::trim($_POST['name']);
		
		if (!empty($_POST['style']))
			$this->style = StringUtil::trim($_POST['style']);
		
		I18nHandler::getInstance()->readValues();
		
		if (I18nHandler::getInstance()->isPlainValue('title'))
			$this->title = I18nHandler::getInstance()->getValue('title');
		
		$this->optionHelper->readValues();
	}
	
	/**
	 * @see \wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->action == 'add') {
			if (empty($this->name))
				throw new UserInputException('name');
		
			if (!preg_match('/^[a-zA-Z0-9]+$/', $this->name))
				throw new UserInputException('name', 'notValid');
		}
		
		if (!I18nHandler::getInstance()->validateValue('title'))
			throw new UserInputException('title');
		
		if (!array_key_exists($this->style, static::$availableStyles))
			throw new UserInputException('style', 'notValid');
		
		$boxType = ObjectTypeCache::getInstance()->getObjectType($this->boxTypeID)->boxTypeClassName;
		$this->optionHelper->validate(array($boxType, 'validateOptions'));
	}
	
	/**
	 * @see \wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$this->objectAction = new \wcf\data\box\BoxAction(array(), 'create', array('data' => array(
			'name' => $this->name,
			'title' => $this->title,
			'options' => json_encode($this->optionHelper->getValues()),
			'boxTypeID' => $this->boxTypeID,
			'style' => $this->style
		)));
		$this->objectAction->executeAction();
		$returnValues = $this->objectAction->getReturnValues();
		$boxEditor = new \wcf\data\box\BoxEditor($returnValues['returnValues']);
		
		if (!I18nHandler::getInstance()->isPlainValue('title')) {
			I18nHandler::getInstance()->save(
				'title',
				'wcf.box.boxes.'.$this->name.'.title',
				'wcf.box.boxes',
				BoxUtil::getPackageID()
			);
			
			$boxEditor->update(array('title' => 'wcf.box.boxes.'.$this->name.'.title'));
		}
		
		$this->saved();
		
		// reset values
		$this->name = $this->title = '';
		$this->boxTypeID = 0;
		$this->style = 'title';
		
		I18nHandler::getInstance()->disableAssignValueVariables();
		$this->optionHelper->disableAssignVariables();
		
		WCF::getTPL()->assign(array(
			'success' => true,
			'availableBoxTypes' => BoxUtil::getBoxTypes(),
			'templateName' => 'boxTypeSelect'
		));
		WCF::getTPL()->display('boxTypeSelect');
		exit;
	}
	
	/**
	 * @see \wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables();
		
		foreach (static::$availableStyles as &$style)
			$style = WCF::getLanguage()->get($style);
		
		WCF::getTPL()->assign(array(
			'action' => $this->action,
			'name' => $this->name,
			'title' => $this->title,
			'boxTypeID' => $this->boxTypeID,
			'boxTypeTitle' => ObjectTypeCache::getInstance()->getObjectType($this->boxTypeID)->boxTypeTitle,
			'style' => $this->style,
			'options' => $this->optionHelper->render(),
			'availableBoxTypes' => BoxUtil::getBoxTypes(),
			'availableStyles' => static::$availableStyles
		));
	}
}

