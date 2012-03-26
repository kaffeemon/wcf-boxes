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
		
		if ($this->cacheType >= self::TYPE_BOX) {
			$boxType = BoxUtil::getBoxTypeName(get_class($this));
			$boxUser = ($this->cacheType >= self::TYPE_USER ? '-*' : '');
			
			$cacheName = sprintf('cache.box-%s-%s%s.php', $boxType, $this->name, $boxUser);
			CacheHandler::getInstance()->clear(WCF_DIR.'cache', $cacheName);
		}
	}
}

