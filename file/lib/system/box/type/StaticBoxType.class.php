<?php
namespace wcf\system\box\type;
use \wcf\system\WCF;

/**
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box.type
 */
class StaticBoxType extends \wcf\system\box\AbstractBoxType {
	/**
	 * @see \wcf\system\box\IBoxType::validateOptions()
	 */
	public static function validateOptions($options) {
		if (empty($options['content']))
			return 'wcf.box.type.static.content.error.empty';
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		return WCF::getTPL()->fetchString($this->content);
	}
}

