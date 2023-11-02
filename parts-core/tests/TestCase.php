<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mail;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function setUp()
	{
		parent::setUp();

		Mail::fake();
	}
}
