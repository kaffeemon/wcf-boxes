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
}

