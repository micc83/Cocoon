<?php

use Cocoon\Components\Router;
use Cocoon\Components\Database;
use Symfony\Component\Debug\Debug;

/**
 * Configuration file
 */
$config = require 'config.php';

/**
 * Debug
 */
if ( $config['debug'] )
  Debug::enable();

/**
 * Define COCOON_PATH
 */
define('COCOON_PATH', dirname(__FILE__));

/**
 * Define COCOON_CACHE
 */
define('COCOON_CACHE', $config['cache']);

/**
 * Set DB prefix and start DB connection (mandatory)
 */
Database::setPrefix($config['db_prefix']);

/**
 * Create schema if needed
 */
require 'schema.php';
CooconSchema::verifyVersion();

/**
 * Initialize router
 * and exit if current URI doesn't match the one provided
 * Code after this line won't be evaluated if not in the path of cocoon
 */
Router::setPath($config['uri']);
if (!Router::inPath())
  return;

/**
 * Load routes
 */
require 'routes.php';
