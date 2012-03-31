<?php
namespace wcf\acp\form;
use \wcf\system\language\I18nHandler;
use \wcf\page\util\InstantOptionHelper;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\util\BoxUtil;
use \wcf\system\WCF;

/**
 * Shows the box add form.
 *
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	acp.form
 */
class BoxEditForm extends BoxAddForm {
	/**
	 * @see \wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.box.list';
	
	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array(
		'admin.content.box.canEdit'
	);
	
	public $action = 'edit';
	
	public $boxID = 0;
	public $box = null;
	
	/**
	 * @see \wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (!empty($_REQUEST['id']))
			$this->boxID = intval($_REQUEST['id']);
		
		$this->box = new \wcf\data\box\Box($this->boxID);
		
		if (!$this->box->boxID)
			throw new \wcf\system\exception\IllegalLinkException;
		
		$boxType = ObjectTypeCache::getInstance()->getObjectType($this->box->boxTypeID)->boxTypeClassName;
		$boxTypeTitle = ObjectTypeCache::getInstance()->getObjectType($this->box->boxTypeID)->boxTypeTitle;
		$this->optionHelper = new InstantOptionHelper('options', $boxTypeTitle.'.option');
		$this->optionHelper->registerOptions($boxType::getOptions());
		
		$this->boxTypeID = $this->box->boxTypeID;
	}
	
	/**
	 * @see \wcf\form\IForm::save()
	 */
	public function save() {
		ACPForm::save();
		
		$this->name = $this->box->name;
		$this->title = 'wcf.box.boxes.'.$this->box->name.'.title';
		if (I18nHandler::getInstance()->isPlainValue('title')) {
			I18nHandler::getInstance()->remove(
				$this->title,
				BoxUtil::getPackageID()
			);
			
			$this->title = I18nHandler::getInstance()->getValue('title');
		} else {
			I18nHandler::getInstance()->save(
				'title',
				$this->title,
				'wcf.box.boxes',
				BoxUtil::getPackageID()
			);
		}
		
		$this->objectAction = new \wcf\data\box\BoxAction(array($this->boxID), 'update', array('data' => array(
			'title' => $this->title,
			'options' => json_encode($this->optionHelper->getValues()),
			'style' => $this->style
		)));
		$this->objectAction->executeAction();
		
		$this->saved();
		
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see \wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			I18nHandler::getInstance()->setOptions(
				'title',
				BoxUtil::getPackageID(),
				$this->box->title,
				'wcf.box.boxes.[a-zA-Z0-9]+.title'
			);
			
			$this->optionHelper->setValues($this->box->options);
			
			$this->name = $this->box->name;
			$this->title = $this->box->title;
			$this->boxTypeID = $this->box->boxTypeID;
			$this->style = $this->box->style;
		}
	}
	
	/**
	 * @see \wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables((bool) count($_POST));
		
		WCF::getTPL()->assign(array(
			'boxID' => $this->boxID
		));
	}
}

