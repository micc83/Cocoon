<?php

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;
use \Cocoon\Components\Router;
use \Cocoon\Components\App;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;

class Template {

  use Singleton;

  private $twig;

  /**
   * Initialize Template engine
   */
  function init () {
    $loader = new Twig_Loader_Filesystem(App::getPluginPath('/plugin/views'));

    $twig_options = array();

    if (App::getOption('cache'))
      $twig_options['cache'] = App::getPluginPath('/cache/templates');

    $this->twig = new Twig_Environment($loader, $twig_options);

    $this->registerHelperFunctions();
  }

  /**
   * Register helper functions
   */
  private function registerHelperFunctions () {
    $this->twig->addFunction(new Twig_SimpleFunction('createLink', array($this, 'createLinkHelper'), array('is_safe' => array('html')) ));
    $this->twig->addFunction(new Twig_SimpleFunction('deleteButton', array($this, 'deleteButtonHelper'), array('is_safe' => array('html')) ));
    $this->twig->addFunction(new Twig_SimpleFunction('getURI', array($this, 'getURIHelper') ));
    $this->twig->addFunction(new Twig_SimpleFunction('script', array($this, 'getScriptHelper'), array('is_safe' => array('html')) ));
    $this->twig->addFunction(new Twig_SimpleFunction('style', array($this, 'getStyleHelper'), array('is_safe' => array('html')) ));
    $this->twig->addFunction(new Twig_SimpleFunction('image', array($this, 'getImageHelper'), array('is_safe' => array('html')) ));
  }

  /**
   * Create link helper
   * @param  String $anchor The anchor text 
   * @param  String $path The path starting from the main Cocoon uri
   * @return String The full formed Hyperlink
   */
  public function createLinkHelper ($anchor, $path = '') {
    return '<a href="' . App::getUrl($path) . '">' . $anchor . '</a>';
  }

  /**
   * Delete button helper
   * @param  String $text The button text 
   * @param  String $path The path starting from the main Cocoon uri
   * @return String The full formed Button tag
   */
  public function deleteButtonHelper ($text, $path = '') {
    require_once(ABSPATH .'wp-includes/pluggable.php');
    $nonce = \wp_create_nonce($path);
    return '<form action="'.App::getUrl($path).'" method="POST">' .
    '<input type="hidden" name="_nonce" value="'.$nonce.'">'.
    '<input type="hidden" name="_method" value="DELETE">'.
    '</input><button type="submit" class="delete-button">'.$text.'</button></form>';
  }

  /**
   * getURIHelper
   * @param  String $path The path starting from the main Cocoon uri
   * @return String The full formed URI
   */
  public function getURIHelper ($path) {
    return App::getUrl($path);
  }

  /**
   * getScriptHelper
   * @param  String $path The path starting from the Cocoon plugin uri
   * @return String The full formed SCRIPT tag
   */
  public function getScriptHelper ($path) {
    return '<script type="text/javascript" src="' . App::getPluginUrl('/assets/js/' . $path) . '"></script>';
  }

  /**
   * getStyleHelper
   * @param  String $path The path starting from the Cocoon plugin uri
   * @return String The full formed LINK tag
   */
  public function getStyleHelper ($path) {
    return '<link type="text/javascript" src="' . App::getPluginUrl('/assets/css/' . $path) . '" rel="stylesheet" type="text/css"/>';
  }

  /**
   * getImageHelper
   * @param  String $path The path starting from the Cocoon plugin uri
   * @return String The full formed IMG tag
   */
  public function getImageHelper ($path, $alt = '') {
    return '<img src="' . App::getPluginUrl('/assets/images/' . $path) . '" alt=""/>';
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
    $service = Router::getKlein()->service();
    $data = array_merge($data, array(
      'infos'     =>  $service->flashes('info'),
      'errors'    =>  $service->flashes('error')
    ));
    return self::getTwig()->render($template, $data);
  }

}