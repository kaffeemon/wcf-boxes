<?php
namespace wcf\system\box;
use \wcf\util\BoxUtil;
use \wcf\system\cache\CacheHandler;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box
 */
abstract class CachedBoxType extends AbstractBoxType {
	public $boxCache;
	
	/**
	 * lifetime of the cached data
	 */
	public $maxLifetime = 300;
	
	/**
	 * is caching box specific or is there one cache for all boxes of a type
	 */
	public $cacheIsBoxSpecific = true;
	
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
		
		$cacheName = 'box-'.$this->boxTypeID;
		if ($this->cacheIsBoxSpecific) $cacheName .= '-'.$this->name;
		
		CacheHandler::getInstance()->addResource(
			$cacheName,
			WCF_DIR.'cache/cache.'.$cacheName.'.php',
			$this->cacheBuilder,
			$this->maxLifetime
		);
		
		$this->boxCache = CacheHandler::getInstance()->get($cacheName);
		
		return parent::render();
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::onUpdate()
	 */
	public function onUpdate() {
		parent::onUpdate();
		$this->onDelete();
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::onDelete()
	 */
	public function onDelete() {
		parent::onDelete();
		
		if (empty($this->cacheBuilder)) return;
		
		if ($this->cacheIsBoxSpecific) {
			$cacheName = sprintf('cache.box-%s-%s.php', $this->boxTypeID, $this->name);
			CacheHandler::getInstance()->clear(WCF_DIR.'cache', $cacheName);
		}
	}
}

