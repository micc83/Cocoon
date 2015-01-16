<?php
/**
 * @wordpress-plugin
 * Plugin Name: Cocoon
 * Description: WordPress plugin that provides a Laravel like framework.
 * Version: 1.0.0
 * Author: Alessandro Benoit
 * Author URI: http://codeb.it
 * Text Domain: cocoon
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/** 
 * Composer autoload
 */
require 'vendor/autoload.php';

/**
 * Start the plugin
 */
require 'start.php';