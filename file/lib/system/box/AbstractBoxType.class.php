<?php
namespace wcf\system\box;
use \wcf\system\event\EventHandler;
use \wcf\system\WCF;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box
 */
abstract class AbstractBoxType extends \wcf\data\DatabaseObjectDecorator implements IBoxType {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\box\Box';
	
	/**
	 * name of the template for the box
	 * @var string
	 */
	public $templateName = '';
	
	/**
	 * @see \wcf\system\box\IBoxType::getOptions()
	 */
	public static function getOptions() {
		EventHandler::getInstance()->fireAction('AbstractBoxType', 'getOptions');
		return array();
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		EventHandler::getInstance()->fireAction($this, 'show');
		
		if ($this->disabled || empty($this->templateName)) return '';
		
		return WCF::getTPL()->fetch($this->templateName, array(
			'box' => $this
		));
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::onUpdate()
	 */
	public function onUpdate() {
	
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::onDelete()
	 */
	public function onDelete() {
	
	}
}

