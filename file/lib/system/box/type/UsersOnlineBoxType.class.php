<?php
namespace wcf\system\box\type;
use \wcf\system\WCF;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box.type
 */
class UsersOnlineBoxType extends \wcf\system\box\CachedBoxType {
	/**
	 * @see \wcf\system\box\AbstractBoxType::$templateName
	 */
	public $templateName = 'usersOnlineBoxType';
	
	/**
	 * @see \wcf\system\box\IBoxType::getBoxTypeTitle()
	 */
	public function getBoxTypeTitle() {
		return 'wcf.box.type.usersOnline';
	}
	
	/**
	 * @see \wcf\system\box\CachedBoxType::$maxLifetime
	 */
	public $maxLifetime = 60;
	
	/**
	 * @see \wcf\system\box\CachedBoxType::$cacheType
	 */
	public $cacheType = \wcf\system\box\CachedBoxType::TYPE_GENERAL;
	
	/**
	 * @see \wcf\system\box\CachedBoxType::$cacheBuilder
	 */
	public $cacheBuilder = 'wcf\system\cache\builder\UsersOnlineBoxTypeCacheBuilder';
}

