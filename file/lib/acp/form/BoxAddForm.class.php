<?php
namespace wcf\acp\form;
use \wcf\system\language\I18nHandler;
use \wcf\system\option\InstantOptionHandler;
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
			
			if (empty($this->boxTypeID) || !ObjectTypeCache::getObjectType($this->boxTypeID))) {
				$boxTypes = array();
				foreach (ObjectTypeCache::getObjectTypes('com.github.kaffeemon.boxes.boxType') as $boxType)
					$boxTypes[$boxType->objectTypeID] = WCF::getLanguage()->get($boxType->boxTypeTitle);
				
				ACPMenu::getInstance()->setActiveMenuItem($this->activeMenuItem);
				
				WCF::getTPL()->assign(array(
					'availableBoxTypes' => $boxTypes,
					'templateName' => 'boxTypeSelect'
				));
				WCF::getTPL()->display('boxTypeSelect');
				exit;
			}
			
			$boxType = ObjectTypeCache::getObjectType($this->boxTypeID)->boxTypeClassName;
			InstantOptionHandler::getInstance()->registerOptions($boxType::getOptions());
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
		
		InstantOptionHandler::getInstance()->readValues();
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
		
		InstantOptionHandler::getInstance()->validate();
	}
	
	/**
	 * @see \wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$this->objectAction = new \wcf\data\box\BoxAction(array(), 'create', array('data' => array(
			'name' => $this->name,
			'title' => $this->title,
			'options' => json_encode(InstantOptionHandler::getInstance()->getValues()),
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
		
		// TODO cache leeren?
		
		$this->saved();
		
		// reset values
		$this->name = $this->title = '';
		$this->boxTypeID = 0;
		$this->style = 'title';
		
		I18nHandler::getInstance()->disableAssignValueVariables();
		InstantOptionHandler::getInstance()->disableAssignVariables();
		
		$boxTypes = array();
		foreach (ObjectTypeCache::getObjectTypes('com.github.kaffeemon.boxes.boxType') as $boxType)
			$boxTypes[$boxType->objectTypeID] = WCF::getLanguage()->get($boxType->boxTypeTitle);
		
		WCF::getTPL()->assign(array(
			'success' => true,
			'availableBoxTypes' => $boxTypes,
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
		InstantOptionHandler::getInstance()->assignVariables();
		
		$boxTypes = array();
		foreach (ObjectTypeCache::getObjectTypes('com.github.kaffeemon.boxes.boxType') as $boxType)
			$boxTypes[$boxType->objectTypeID] = WCF::getLanguage()->get($boxType->boxTypeTitle);
		
		foreach (static::$availableStyles as &$style)
			$style = WCF::getLanguage()->get($style);
		
		WCF::getTPL()->assign(array(
			'action' => $this->action,
			'name' => $this->name,
			'title' => $this->title,
			'boxTypeID' => $this->boxTypeID,
			'boxTypeTitle' => ObjectTypeCache::getObjectType($this->boxTypeID)->boxTypeTitle,
			'style' => $this->style,
			'availableBoxTypes' => $boxTypes,
			'availableStyles' => static::$availableStyles
		));
	}
}

