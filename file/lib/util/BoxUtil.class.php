<?php
namespace wcf\util;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	util
 */
final class BoxUtil {
	private static $packageID;
	
	/**
	 * returns the packageID of the boxsystem
	 */
	public static function getPackageID() {
		if (self::$packageID === null)
			self::$packageID = \wcf\system\package\PackageDependencyHandler::getInstance()->getPackageID('com.github.kaffeemon.wcf.boxes');
		
		return self::$packageID;
	}
	
	/**
	 * gets the title of a box type
	 */
	public static function getBoxTypeTitle($className) {
		$boxType = array_pop(explode('\\', $className));
		$boxType = preg_replace('/(BoxType)$/', '', $boxType);
		return 'wcf.box.type.'.lcfirst($boxType);
	}
	
	/**
	 * returns all installed box types
	 */
	public static function getBoxTypes() {
		$boxTypes = array();
		$files = glob(DIR.'lib/system/box/type/*BoxType.class.php');
		
		foreach ($files as $file) {
			$file = str_replace(DIR.'lib', 'wcf', $file);
			$file = preg_replace('/(\.class\.php)$/', '', $file);
			$file = str_replace('/', '\\', $file);
			
			if (class_exists($file) && ClassUtil::instanceOf($file, 'wcf\system\box\IBoxType'))
				$boxTypes[] = $file;
		}
		
		return $boxTypes;
	}
}

