<?php

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;

/**
 * App
 */
class App {

  use Singleton;
  
  protected $config = array(),
            $filePath,
            $pluginPath;

  static function getOption($name) {
    if (isset(self::instance()->config[$name]))
      return self::instance()->config[$name];
  }

  static function setOptions($config) {
    self::instance()->config = $config;
  }

  static function setPluginPath($path) {
    self::instance()->filePath = $path;
    self::instance()->pluginPath = dirname($path);
  }

  static function getPluginPath($addPath ='') {
    return self::instance()->pluginPath . $addPath;
  }

  static function getPluginUrl($addPath ='') {
    return plugins_url('', self::instance()->filePath) . '/plugin' . $addPath;
  }

  static function getUrl($addPath ='') {
    return site_url(self::getOption('path').$addPath);
  }

}