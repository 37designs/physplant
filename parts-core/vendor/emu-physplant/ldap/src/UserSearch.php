<?php

namespace EMUPhysPlant\LDAP;

class UserSearch
{
	use CleanResults;

	protected $connection;

	protected static $SERVER = "directory.emich.edu";
	protected static $BASE_DN = "ou=people, o=emich.edu";

	public function __construct()
	{
		$this->connection = ldap_connect(self::$SERVER);
		ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
	}

	/**
	 * Checks if a username is a valid Emich username.
	 *
	 * @param string $username
	 *
	 * @return bool
	 */
	public function validUsername($username)
	{
		$search = $this->search("uid=$username", ['count']);

		return sizeof($search) > 0;
	}

	/**
	 * Get's a user's full name given a username. Wildcards are not supported; you should instead use the search method
	 * if you want to match multiple users.
	 *
	 * @param string $username
	 *
	 * @return string|bool User's full name or false if the user was not found
	 */
	public function name($username)
	{
		$results = $this->search("uid=$username", ['cn']);

		if (sizeof($results) == 0) {
			return false;
		}

		return reset($results)['cn'];
	}

	/**
	 * Run a raw LDAP query.
	 *
	 * @param string $filter LDAP query (e.g. "(uid=jsmith)", "(&(uid=j*)(sn=Smith))")
	 * @param array  $attributes attributes to fetch (e.g. ["uid", "sn"])
	 *
	 * @return array results
	 */
	public function search($filter, $attributes)
	{
		$result = ldap_search($this->connection, self::$BASE_DN, $filter, $attributes);

		$entries = ldap_get_entries($this->connection, $result);

		return $this->cleanLdapGetEntriesResults($entries);
	}
}