<?php
/**
 * Router
 * @uses https://github.com/chriso/klein.php
 */

namespace Cocoon\Components; 
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
          $rel_path,
          $path;

  /**
   * Initialize Router
   */
  function init() {

    // Instance Klein
    $this->klein = new Klein();

    // Create request Object
    $this->request = Request::createFromGlobals();

  }

  /**
   * Set the starting path to start the router from
   * in order not to collide with WordPress routing
   * @param String $path Starting path (ex. /preventivi/cocoon)
   */
  static function setPath($rel_path) {

    // Set the relative path
    self::instance()->rel_path = $rel_path;

    // Wp installation path
    $wp_install_path = str_replace( 'http://' . $_SERVER['HTTP_HOST'], '', site_url());

    // Set the instance starting path
    self::instance()->path = $wp_install_path . self::instance()->rel_path;

    // Grab the server-passed "REQUEST_URI"
    self::instance()->current_uri = self::instance()->request->server()->get('REQUEST_URI');

    // Remove the starting URI from the equation
    // ex. /wp/cocoon/mypage -> /mypage
    self::instance()->request->server()->set(
      'REQUEST_URI', substr(self::instance()->current_uri, strlen(self::instance()->path))
    );

  }

  /**
   * Get cocoon URI followed by path
   * @param  String $add_path Path to add to the base URI
   * @return String           Full URI
   */
  static function getURI($add_path = '') {
    return site_url(self::instance()->rel_path . $add_path);
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
