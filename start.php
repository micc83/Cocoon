<?php

use Cocoon\Components\Router;
use Cocoon\Components\Database;
use Cocoon\Components\App;
use Symfony\Component\Debug\Debug;

/**
 * Init App
 */
App::setOptions(require 'config.php');
App::setPluginPath(dirname(__FILE__));

/**
 * Debug
 */
if (App::getOption('debug'))
  Debug::enable();

/**
 * Require DB Schema
 */
require 'plugin/schema.php';

/**
 * Start DB connection
 */
Database::instance();

/**
 * Create DB if needed
 */
CooconSchema::verifyVersion();

/**
 * Initialize router
 * and exit if current URI doesn't match the one provided
 * Code after this line won't be evaluated if not in the path of cocoon
 */
if (Router::inPath())
  require 'plugin/routes.php'
