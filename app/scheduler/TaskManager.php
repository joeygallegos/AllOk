<?php
namespace App\Scheduler;
use App\Scheduler\Kernel;
use App\Events\TakeTrashOutReminder;
use Carbon\Carbon;

// bootstrap
include dirname(dirname(dirname(__FILE__))) . '/app/bootstrap.php';
include dirname(dirname(dirname(__FILE__))) . '/app/middleware.php';

// unlimited time
ini_set('memory_limit', '-1');

// set correct timezone
$kernel = new Kernel;
$kernel->setDate(Carbon::now()->tz('America/Chicago'));

// reminder: take trash out
$kernel->add(new TakeTrashOutReminder($app))->tuesdays()->at(19, 0);

// you can also use cron
//->cron('0 */3 * * *');

// run kernel
$kernel->run();