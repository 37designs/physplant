<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestAcceptedTech extends Mailable
{
	use Queueable, SerializesModels;

	public $parts;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($parts)
	{
		$this->parts = $parts;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.requestacceptedtech');
	}
}
