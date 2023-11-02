<?php

namespace App\Mail;

use App\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TechAssureSubmit extends Mailable
{
	use Queueable, SerializesModels;

	public $request;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Request $req)
	{
		$this->request = $req;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.techassuresubmit');
	}
}
