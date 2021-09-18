<?php
declare(strict_types=1);

/** Require the dependencies composer installed */
require __DIR__."/../vendor/autoload.php";

/** Report only errors */
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

use Slate\Mvc\App;
use Slate\Mvc\Env;
use Slate\Facade\DB;
use Slate\Mvc\HttpKernel;
use Slate\Mvc\ConsoleKernel;

/** Import the configuration file */
Env::fromArray(require_once("config.php"));

$kernel = \Str::beforeFirst(php_sapi_name(), "-") === "cli" ? ConsoleKernel::class : HttpKernel::class;

App::kernel(new $kernel(__DIR__ . "/.."));
App::configure();
App::verify();
App::connections();
App::queues();
App::repositories();

require_once("routes.php");

App::go();

?>