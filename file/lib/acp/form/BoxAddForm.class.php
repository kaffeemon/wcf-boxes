<?php
namespace wcf\acp\form;
use \wcf\system\language\I18nHandler;
use \wcf\system\exception\UserInputException;
use \wcf\util\BoxUtil;
use \wcf\util\StringUtil;
use \wcf\util\ClassUtil;
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
	public $options = '';
	public $className = '';
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
		
		I18nHandler::getInstance()->register('title');
	}
	
	/**
	 * @see \wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (!empty($_POST['name']))
			$this->name = StringUtil::trim($_POST['name']);
		
		if (!empty($_POST['options']))
			$this->options = StringUtil::trim($_POST['options']);
		
		if (!empty($_POST['className']))
			$this->className = StringUtil::trim($_POST['className']);
		
		if (!empty($_POST['style']))
			$this->style = StringUtil::trim($_POST['style']);
		
		I18nHandler::getInstance()->readValues();
		
		if (I18nHandler::getInstance()->isPlainValue('title'))
			$this->title = I18nHandler::getInstance()->getValue('title');
	}
	
	/**
	 * @see \wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->action == 'add') {
			if (empty($this->name))
				throw new UserInputException('name');
		
			if (!preg_match('/^[a-zA-Z]+$/', $this->name))
				throw new UserInputException('name', 'notValid');
		}
		
		if (!I18nHandler::getInstance()->validateValue('title'))
			throw new UserInputException('title');
		
		if (!array_key_exists($this->style, static::$availableStyles))
			throw new UserInputException('style', 'notValid');
		
		$this->validateClassName();
		$this->validateOptions();
	}
	
	protected function validateClassName() {
		if (empty($this->className))
			throw new UserInputException('className');
		
		if (!class_exists($this->className))
			throw new UserInputException('className', 'notValid');
		
		if (!ClassUtil::isInstanceOf($this->className, 'wcf\system\box\IBoxType'))
			throw new UserInputException('className', 'notValid');
	}
	
	protected function validateOptions() {
		$options = null;
		if (!empty($this->options))
			$options = json_decode($this->options, true);
		
		$className = $this->className;
		
		if ($errorType = $className::validateOptions($options))
			throw new UserInputException('options', $errorType);
	}
	
	/**
	 * @see \wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$this->objectAction = new \wcf\data\box\BoxAction(array(), 'create', array('data' => array(
			'name' => $this->name,
			'title' => $this->title,
			'options' => $this->options,
			'className' => $this->className,
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
		$this->name = $this->title = $this->options = $this->className = '';
		$this->style = 'title';
		I18nHandler::getInstance()->disableAssignValueVariables();
		
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see \wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables();
		
		$boxTypes = array();
		foreach (BoxUtil::getBoxTypes() as $boxType)
			$boxTypes[$boxType] = BoxUtil::getBoxTypeTitle($boxType);
		
		foreach (static::$availableStyles as &$style)
			$style = WCF::getLanguage()->get($style);
		
		WCF::getTPL()->assign(array(
			'action' => $this->action,
			'name' => $this->name,
			'title' => $this->title,
			'options' => $this->options,
			'className' => $this->className,
			'style' => $this->style,
			'availableBoxTypes' => $boxTypes,
			'availableStyles' => static::$availableStyles
		));
	}
}

