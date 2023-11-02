<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopChange extends Mailable
{
	use Queueable, SerializesModels;

	public $toperm;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($toperm)
	{
		$this->toperm = $toperm;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.shopchange');
	}
}
