<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartRequestSubmit extends Mailable
{
	use Queueable, SerializesModels;

	public $techname, $requesturl;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($techname, $requesturl)
	{
		$this->techname = $techname;
		$this->requesturl = $requesturl;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.partrequestsubmit');
	}
}
