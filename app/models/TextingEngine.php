<?php
namespace App\Models;
use Twilio\Rest\Client as Twilio; 

class TextingEngine
{
	protected $sid = '';
	protected $token = '';
	protected $textFrom = '';
	private $twilioInstance = null;

	function __construct(string $sid = '', string $token = '', $textFrom = '')
	{
		$this->sid = $sid;
		$this->token = $token;
		$this->textFrom = $textFrom;
		$this->twilioInstance = new Twilio($this->sid, $this->token);
	}

	public function sendText(string $to = '', string $text = '')
	{
		if (isNullOrEmptyString($text))
		{
			// do not send
		}

		$this->twilioInstance->messages->create($to, [
			'from' => $this->textFrom,
			'body' => $text
		]);
	}
}