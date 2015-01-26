<?php

namespace Cocoon\Patterns; 

trait Singleton {
  protected static $instance;

  final public static function instance() {
    return isset(static::$instance) ? static::$instance : static::$instance = new static;
  }

  final private function __construct() {
    static::init();
  }

  protected static function init() {}

  final private function __wakeup() {}

  final private function __clone() {}
  
}