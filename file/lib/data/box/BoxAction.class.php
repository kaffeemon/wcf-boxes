<?php
namespace wcf\data\box;
use \wcf\util\BoxUtil;
use \wcf\system\language\I18nHandler;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	data.box
 */
class BoxAction extends \wcf\data\AbstractDatabaseObjectAction {
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\box\BoxEditor';
	
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsCreate
	 */
	protected $permissionsCreate = array(
		'admin.content.box.canAdd'
	);
	
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array(
		'admin.content.box.canDelete'
	);
	
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array(
		'admin.content.box.canEdit'
	);
	
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::delete()
	 */
	public function delete() {
		$count = parent::delete();
		
		if (!empty($this->objects)) {
			foreach ($this->objects as $object) {
				if (preg_match('/wcf\.box\.boxes\.[a-zA-Z0-9]+\.title/', $object->title))
					I18nHandler::getInstance()->remove($object->title, BoxUtil::getPackageID());
				
				$object->getProcessor()->onDelete();
			}
		}
		
		return $count;
	}
	
	public function validateToggle() {
		parent::validateUpdate();
	}
	
	/**
	 * Toogles status
	 */
	public function toggle() {
		foreach ($this->objects as $box)
			$box->update(array('disabled' => $box->disabled ? 0 : 1));
	}
}

