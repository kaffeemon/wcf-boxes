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
	 * @see \wcf\system\box\IBoxType::validateOptions()
	 */
	public function validateOptions($options) {
		EventHandler::getInstance()->fireAction($this, 'validateOptions');
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		EventHandler::getInstance()->fireAction($this, 'show');
		
		if (empty($this->templateName)) return '';
		
		return WCF::getTPL()->fetch($this->templateName, array(
			'box' => $this
		));
	}
}

