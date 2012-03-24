<?php
namespace wcf\data\box;

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
}

