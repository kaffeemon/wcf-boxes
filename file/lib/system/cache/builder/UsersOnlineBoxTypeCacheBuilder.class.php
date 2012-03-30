<?php
namespace wcf\system\cache\builder;
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
		$data = array(
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
			$data['usersOnline'][] = $row;
		
		return $data;
	}
}

