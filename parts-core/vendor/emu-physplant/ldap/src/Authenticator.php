<?php

namespace EMUPhysPlant\LDAP;

use EMUPhysPlant\LDAP\Exceptions\AuthenticationException;

class Authenticator
{
	use CleanResults;

	protected $connection;
	protected $username;

	protected $bound;

	public function __construct()
	{
		$this->connection = ldap_connect("ldap.emich.edu");
	}

	/**
	 * @param string $username
	 * @param string $password
	 *
	 * @return bool true if the user's credentials are valid; false otherwise
	 */
	public function authenticate($username, $password)
	{
		$this->username = $username;

		return $this->bound = (@ldap_bind($this->connection, "cn=$this->username,ou=people,o=campus", $password));
	}

	/**
	 * Retrieves LDAP attributes from the currently authenticated user.
	 *
	 * @param array $attributes LDAP attributes to retrieve, or empty array for all attributes.
	 *
	 * @return array Associative array of the requested attributes and their retrieved values
	 * @throws AuthenticationException if method is called before a successful authenticate() call
	 */
	public function getAttributes(array $attributes = [])
	{
		if (! $this->bound) {
			throw new AuthenticationException();
		}

		$search = empty($attributes) ?
				ldap_search($this->connection, "ou=people,o=campus", "cn=$this->username")
				: ldap_search($this->connection, "ou=people,o=campus", "cn=$this->username", $attributes);

		$entries = ldap_get_entries($this->connection, $search);

		return array_values($this->cleanLdapGetEntriesResults($entries))[0];
	}
}
