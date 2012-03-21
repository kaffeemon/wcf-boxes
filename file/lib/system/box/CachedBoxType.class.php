<?php
namespace wcf\system\box;
use \wcf\util\BoxUtil;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box
 */
abstract class CachedBoxType extends AbstractBoxType {
	const TYPE_GENERAL = 0,
			TYPE_BOX = 1,
			TYPE_USER = 2;
	
	public $boxCache;
	
	/**
	 * lifetime of the cached data
	 */
	public $maxLifetime = 300;
	
	/**
	 * type of caching
	 */
	public $cacheType = self::TYPE_GENERAL;
	
	/**
	 * cache builder
	 */
	public $cacheBuilder = '';
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		if (empty($this->cacheBuilder))
			throw new \wcf\system\exception\SystemException('cache builder not specified');
		
		$cacheName = 'box-'.BoxUtil::getBoxTypeName(get_class($this));
		if ($this->cacheType >= self::TYPE_BOX) $cacheName .= '-'.$this->name;
		if ($this->cacheType >= self::TYPE_USER) $cacheName .= '-'.WCF::getUser()->userID;
		
		CacheHandler::getInstance()->addResource(
			$cacheName,
			WCF_DIR.'cache/cache.'.$cacheName.'.php',
			$this->cacheBuilder,
			$this->maxLifetime
		);
		
		$this->boxCache = CacheHandler::get($cacheName);
		
		parent::render();
	}
}

