<?php
/**
 * Router
 * @uses https://github.com/chriso/klein.php
 */

namespace Cocoon\Components; 
use \Cocoon\Components\App; 
use \Cocoon\Patterns\Singleton;
use \Klein\Klein;
use \Klein\Request;

/**
 * Router Singleton
 */
class Router {

  use Singleton;

  private $klein,
          $current_uri,
          $request,
          $path;

  /**
   * Initialize Router
   */
  function init() {

    // Instance Klein
    $this->klein = new Klein();

    // Create request Object
    $this->request = Request::createFromGlobals();

    // Set the current path
    $this->setPath();

  }

  /**
   * Set the starting path to start the router from
   * in order not to collide with WordPress routing
   */
  function setPath() {

    // Wp installation path
    $wp_install_path = str_replace( 'http://' . $_SERVER['HTTP_HOST'], '', site_url());

    // Set the instance starting path
    $this->path = $wp_install_path . App::getOption('path');

    // Grab the server-passed "REQUEST_URI"
    $this->current_uri = $this->request->server()->get('REQUEST_URI');

    // Remove the starting URI from the equation
    // ex. /wp/cocoon/mypage -> /mypage
    $this->request->server()->set(
      'REQUEST_URI', substr($this->current_uri, strlen($this->path))
    );

  }

  /**
   * Check if current url start with the cocoon URI path
   * @return boolean
   */
  static function inPath () {
    return strrpos(
        self::instance()->current_uri, 
        self::instance()->path, 
        -strlen(self::instance()->current_uri)
      ) !== false;
  }

  /**
   * Get the Klein Object
   * @return \Klein\Klein
   */
  static function getKlein () {
    return self::instance()->klein;
  }

  /**
   * Add a new route
   * @param String $method   POST/GET/UPDATE/DELETE
   * @param String $path     ex. /[:id] (Can contain regexp)
   * @param Function|String|Array $callback Callback
   */
  static function add ($method, $path = '*', $callback = null) {
    if (isset($callback[1]))
      $callback[0] = 'Cocoon\Controllers\\' . $callback[0];
    self::instance()->klein->respond($method, $path, $callback);
  }

  /**
   * On HTTP Error
   * @param  String|Function|Array $callback Callback
   */
  static function onHttpError ($callback) {
    self::instance()->klein->onHttpError($callback);
  }

  /**
   * Start listening and die
   */
  static function start() {
    self::instance()->klein->dispatch(self::instance()->request);
    exit;
  }

}
