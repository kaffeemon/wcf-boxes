<?php
namespace wcf\acp\page;
use \wcf\system\WCF;

/**
 * Lists all boxes.
 *
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	acp.page
 */
class BoxListPage extends \wcf\page\SortablePage {
	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array(
		'admin.content.box.canEdit',
		'admin.content.box.canDelete'
	);
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = '\wcf\data\box\BoxList';
	
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'name';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = array(
		'boxID', 'name', 'title', 'boxTypeID'
	);
	
	public $deletedBoxID = 0;
	
	/**
	 * @see \wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (!empty($_REQUEST['deletedBoxID']))
			$this->deletedBoxID = intval($_REQUEST['deletedBoxID']);
	}
	
	/**
	 * @see \wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'deletedBoxID' => $this->deletedBoxID
		));
	}
	
	/**
	 * @see \wcf\page\IPage::show()
	 */
	public function show() {
		\wcf\system\menu\acp\ACPMenu::getInstance()->setActiveMenuItem('wcf.acp.menu.link.box.list');
		
		parent::show();
	}
}

