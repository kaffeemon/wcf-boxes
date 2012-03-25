<?php
namespace wcf\data\box;
use \wcf\util\BoxUtil;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	data.box
 */
class Box extends \wcf\data\ProcessibleDatabaseObject {
	/**
	 * @see \wcf\data\ProcessibleDatabaseObject::$processorInterface
	 */
	protected static $processorInterface = 'wcf\system\box\IBoxType';
	
	/**
	 * @see \wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'box';
	
	/**
	 * @see \wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'boxID';
	
	/**
	 * @see \wcf\data\DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		if (!empty($this->data['options']))
			$this->data['options'] = json_decode($this->data['options'], true);
	}
	
	/**
	 * @see \wcf\data\IStorableObject::__get()
	 */
	public function __get($name) {
		$value = parent::__get($name);
		
		if ($value === null) {
			if (is_array($this->data['options']) && isset($this->data['options'][$name]))
				$value = $this->data['options'][$name];
		}
		
		return $value;
	}
	
	public function getBoxTypeTitle() {
		return BoxUtil::getBoxTypeTitle($this->className);
	}
}

