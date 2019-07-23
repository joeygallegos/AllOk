<?php
namespace App\Events;
use App\Scheduler\Event;
class TakeTrashOutReminder extends Event {
	private $app;
	public function __construct($app) {
		$this->app = $app;
	}

	public function handle() {
		echo "Take trash out!!!";
	}
}