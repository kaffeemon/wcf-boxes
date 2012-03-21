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
	 * @see \wcf\system\box\CachedBoxType::$cacheType
	 */
	public $cacheType = \wcf\system\box\CachedBoxType::TYPE_GENERAL;
	
	/**
	 * @see \wcf\system\box\CachedBoxType::readData()
	 */
	public function readData() {
		$this->boxCache = array(
			'usersOnline' => array()
		);
		
		$sql = "SELECT session.userID, user.userID, user.username
				FROM wcf".WCF_N."_session session
				LEFT JOIN wcf".WCF_N."_user user
				ON session.userID = user.userID
				WHERE session.userID IS NOT NULL
				GROUP BY user.userID, session.userID, user.username
				ORDER BY session.userID";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($row = $statement->fetchArray())
			$this->boxCache['usersOnline'][] = $row;
	}
}

