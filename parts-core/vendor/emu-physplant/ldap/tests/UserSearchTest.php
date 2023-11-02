<?php

use EMUPhysPlant\LDAP\UserSearch;
use PHPUnit\Framework\TestCase;

class UserSearchTest extends TestCase
{
	/** @var  UserSearch */
	protected $userSearch;

	public function setUp()
	{
		parent::setUp();

		$this->userSearch = new UserSearch();
	}

	public function testName()
	{
		self::assertEquals("Paul Gossman", $this->userSearch->name("pgossman"));

		self::assertFalse($this->userSearch->name(random_int(0, 999)));
	}

	public function testValidUsername()
	{
		self::assertTrue($this->userSearch->validUsername("pgossman"));

		self::assertFalse($this->userSearch->validUsername("jfollghvnwaedorlwngOVFDNEQevsdfnj"));
	}

	public function testSearch()
	{
		$results = $this->userSearch->search("(uid=pgossman)", ['uid', 'cn']);

		$dn = "uid=pgossman,ou=people,o=emich.edu";

		self::assertEquals(array_keys($results)[0], $dn);
		self::assertEquals($results[$dn]['cn'], "Paul Gossman");
		self::assertEquals($results[$dn]['uid'], "pgossman");
	}

}