<?php
namespace wcf\system\box;
use \wcf\data\IDatabaseObjectProcessor;

/**
 * Any box type should implement this interface.
 *
 * @author		kaffeemon
 * @license		MIT
 * @package		com.github.kaffeemon.wcf.boxes
 * @subpackage	system.box
 */
interface IBoxType extends IDatabaseObjectProcessor {
	public function getBoxTypeTitle();
	public function validateOptions($options);
	public function render();
}

