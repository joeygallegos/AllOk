<?php
use Carbon\Carbon;
use Monolog\Logger;
use \Slim\App as App;
use App\Models\EmailEngine;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use \SecurityLib\Strength as Strength;
use \RandomLib\Factory as RandomFactory;
use Symfony\Component\Console\Application;
use App\Console\Commands\BuildAssetsCommand;
use App\Console\Commands\CheckStatusCommand;
use Illuminate\Database\Capsule\Manager as Capsule;

// session
session_start();

// environment settings
$slimSettings = [];
$slimSettings['addContentLengthHeader'] = false;

// create the application
$app = new App([
	'settings' => $slimSettings
]);
$container = $app->getContainer();

// setup CLI console
$container['console'] = function() {
	$application = new Application();
	$application->add(new CheckStatusCommand());
	return $application;
};

// setup random factory
$container['RandomFactory'] = function() {
	
	$randomFactory = new RandomFactory;
	return $randomFactory->getGenerator(new Strength(Strength::MEDIUM));
};

// setup app logger
$container['logger'] = function($container) {
	$logger = new Logger('Kore');
	$containerarbon = new Carbon;
	$formatter = new LineFormatter(null, null, false, true);
	$handler = new StreamHandler(getBaseDirectory() . "/logs/" . $containerarbon->today()->format('m-d-y') . "-app.log");
	$handler->setFormatter($formatter);
	$logger->pushHandler($handler);
	return $logger;
};

// setup email engine
$container['emailEngine'] = function($container) {
	return new EmailEngine(
		getenv('MAILGUN_PUBKEY'),
		getenv('MAILGUN_KEY'),
		getenv('MAILGUN_DOMAIN'),
		getenv('MAILGUN_FROM'),
		$container->emailEngineLogger
	);
};

// setup assembly environment
if (in_array(getenv('APP_ENVIRONMENT'), ['assembly', 'staging'])) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	ini_set('display_startup_errors', 'On');
	ini_set('max_execution_time', 0);
	
	$slimSettings = $container->get('settings');
	$slimSettings['displayErrorDetails'] = true;
	$slimSettings['debug'] = true;
}
else {
	error_reporting(0);
	ini_set('display_errors', 'Off');
	ini_set('display_startup_errors', 'Off');
}