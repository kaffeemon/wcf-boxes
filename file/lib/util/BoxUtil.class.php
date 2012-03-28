<?php
namespace wcf\util;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\system\WCF;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	util
 */
final class BoxUtil {
	private static $packageID;
	private static $boxTypes;
	
	/**
	 * returns the packageID of the boxsystem
	 */
	public static function getPackageID() {
		if (self::$packageID === null)
			self::$packageID = \wcf\system\package\PackageDependencyHandler::getInstance()->getPackageID('com.github.kaffeemon.wcf.boxes');
		
		return self::$packageID;
	}
	
	/**
	 * returns all installed box types as boxTypeID => boxTypeTitle|language
	 */
	public static function getBoxTypes() {
		if (self::$boxTypes === null) {
			self::$boxTypes = array();
			foreach (ObjectTypeCache::getInstance()->getObjectTypes('com.github.kaffeemon.boxes.boxType') as $boxType)
				self::$boxTypes[$boxType->objectTypeID] = WCF::getLanguage()->get($boxType->boxTypeTitle);
		}
		
		return self::$boxTypes;
	}
	
	/**
	 * checks if $boxTypeID exists and its definition is correct
	 */
	public static function isValidBoxType($boxTypeID) {
		$boxType = ObjectTypeCache::getInstance()->getObjectType($boxTypeID);
		$definition = ObjectTypeCache::getInstance()->getDefinitionByName('com.github.kaffeemon.boxes.boxType');
		
		if (!$boxType) return false;
		if ($boxType->definitionID != $definition->definitionID) return false;
		
		return true;
	}
	
	private function __construct() { }
}

