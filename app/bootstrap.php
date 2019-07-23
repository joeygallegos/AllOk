<?php
use App\Models\EmailEngine;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Exception\InvalidPathException;
use Mailgun\Mailgun;

/**
 * Import the autoload files from composer and
 * setup the default timezone for the codebase
 */
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';
date_default_timezone_set('America/Chicago');

/**
 * Clone example config if does not exist
 */
$config = dirname(__FILE__) . '/env/config.env';
$copy = dirname(__FILE__) . '/env/config.env.example';
if (!file_exists(dirname(__FILE__) . '/env/config.env')) {
	if (!copy($copy, $config)) {
		die("Failed to copy $copy...\n");
	}
}

/**
 * Load the environment config file
 */
try {
	$config = (new Dotenv(dirname(__FILE__) . '/env/', 'config.env'))->load();
}
catch (InvalidPathException $e) {
	die($e->getMessage());
}

/**
 * Update $_SERVER to use what's in the config
 * during the CLI execution of PHP files
 */
if (strtoupper(php_sapi_name()) == 'CLI') {
	$_SERVER['SERVER_NAME'] = getenv('SERVER_NAME');
}

/**
 * Startup the eloquent database
 */
$capsule = new Capsule();
$capsule->addConnection([
	'driver' => getenv('DB_DRIVER'),
	'host' => getenv('DB_HOST'),
	'port' => getenv('DB_PORT'),
	'database' => getenv('DB_NAME'),
	'username' => getenv('DB_USERNAME'),
	'password' => getenv('DB_PASSWORD'),
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => ''
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();