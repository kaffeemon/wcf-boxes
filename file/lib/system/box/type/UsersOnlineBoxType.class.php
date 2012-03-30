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
	 * @see \wcf\system\box\CachedBoxType::$maxLifetime
	 */
	public $maxLifetime = 60;
	
	/**
	 * @see \wcf\system\box\CachedBoxType::$cacheIsBoxSpecific
	 */
	public $cacheIsBoxSpecific = false;
	
	/**
	 * @see \wcf\system\box\CachedBoxType::$cacheBuilder
	 */
	public $cacheBuilder = 'wcf\system\cache\builder\UsersOnlineBoxTypeCacheBuilder';
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		$this->readCache();
		$this->badge = count($this->boxCache->usersOnline);
		parent::render();
	}
}

