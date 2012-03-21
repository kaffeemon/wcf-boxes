<?php
namespace wcf\system\cache\builder;
use \wcf\util\BoxUtil;
use \wcf\system\WCF;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.cache.builder
 */
class UsersOnlineBoxTypeCacheBuilder implements ICacheBuilder {
	/**
	 * @see \wcf\system\cache\ICacheBuilder::getData()
	 */
	public function getData(array $cacheResource) {
		$cacheName = explode('-', $cacheResource['cache']);
		array_shift($cacheName);
		$boxType = array_shift($cacheName);
		$boxName = array_shift($cacheName);
		$userID = array_shift($cacheName);
		//$box = new \wcf\data\box\Box($boxID);
		
		
	}
}

