<?php

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;
use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Template {

  use Singleton;

  private $twig;

  /**
   * Initialize Template engine
   */
  function init () {
    $loader = new Twig_Loader_Filesystem(COCOON_PATH . '/plugin/views');

    $twig_options = array();

    if (COCOON_CACHE)
      $twig_options['cache'] = COCOON_PATH . '/cache/templates';

    $this->twig = new Twig_Environment($loader, $twig_options);
  }

  /**
   * Get twig instance
   * @return Twig_Environment
   */
  static function getTwig () {
    return self::instance()->twig;
  }

  /**
   * Render the template
   * @param  String $template
   * @param  Array $data
   * @return String Rendered Html
   */
  static function render ($template, $data) {
    return self::getTwig()->render($template, $data);
  }

}