<?php

use EMUPhysPlant\LDAP\Authenticator;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
	/** @var  Authenticator */
	protected $authenticator;

	public function setUp()
	{
		parent::setUp();
		$this->authenticator = new Authenticator();
	}

	public function testAuthenticateWithInvalidCredentials()
	{
		self::assertFalse($this->authenticator->authenticate("pgossman", random_int(0, 999)), "Valid username and invalid pass");
		self::assertFalse($this->authenticator->authenticate(random_int(0, 999), random_int(0, 999)), "Invalid username and invalid pass");
	}

	public function testWithoutAuthenticationGetAttributesFails()
	{
		$this->expectException(\EMUPhysPlant\LDAP\Exceptions\AuthenticationException::class);

		$this->authenticator->getAttributes(['uid']);
	}
}