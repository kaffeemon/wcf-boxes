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
	 * @see \wcf\system\box\IBoxType::getOptions()
	 */
	public static function getOptions() {
		return array(
			new \wcf\data\option\Option(null, array(
				'optionName' => 'content',
				'optionType' => 'textarea'
			)),
			
			new \wcf\data\option\Option(null, array(
				'optionName' => 'enableHTML',
				'optionType' => 'boolean'
			)),
			
			new \wcf\data\option\Option(null, array(
				'optionName' => 'enableTPLCode',
				'optionType' => 'boolean'
			)),
		);
	}
	
	/**
	 * @see \wcf\system\box\IBoxType::render()
	 */
	public function render() {
		$content = $this->content;
		
		// tpl code
		if ($this->enableTPLCode)
			$content = WCF::getTPL()->fetchString($content);
		
		// html
		if (!$this->enableHTML)
			$content = \wcf\util\StringUtil::encodeHTML($content);
		
		return $content;
	}
}

