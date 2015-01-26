<?php

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;

/**
 * App
 */
class App {

  use Singleton;
  
  protected $config = array(),
            $pluginPath;

  static function getOption($name) {
    if (isset(self::instance()->config[$name]))
      return self::instance()->config[$name];
  }

  static function setOptions($config) {
    self::instance()->config = $config;
  }

  static function setPluginPath($path) {
    self::instance()->pluginPath = $path;
  }

  static function getPluginPath($addPath ='') {
    return self::instance()->pluginPath . $addPath;
  }

  static function getUrl($addPath ='') {
    return site_url(self::getOption('path').$addPath);
  }

}