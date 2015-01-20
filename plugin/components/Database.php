<?php
/**
 * Database
 *
 * @uses https://github.com/illuminate/database
 */

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;
use \Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Database class
 */
class Database {

  use Singleton;

  /**
   * Store Database Object
   * @var MySqlConnection
   */
  private $db,
          $connection;

  static $prefix;

  /**
   * Initialize the Db Object and open the connection
   */
  function init () {

    $database = new Capsule;

    $database->addConnection([
      'driver'    => 'mysql',
      'host'      => DB_HOST,
      'database'  => DB_NAME,
      'username'  => DB_USER,
      'password'  => DB_PASSWORD,
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => self::$prefix
    ], 'default');

    $database->bootEloquent();

    $this->db = $database;
    $this->connection = $database->getConnection();

  }

  /**
   * Get the opened DB Object
   * @return MySqlConnection
   */
  static function getDb() {
    return self::instance()->connection;
  }

  /**
   * Get the opened DB Object
   * @return MySqlConnection
   */
  static function schema() {
    return self::getDb()->getSchemaBuilder();
  }

  /**
   * Get the database manager
   * @return  Illuminate\Database\ConnectionResolverInterface Database Manager
   */
  static function getDatabaseManager() {
    return self::instance()->db->getDatabaseManager();
  }

  /**
   * Set the db prefix
   * MUST be called in start.php to initialize the DB also
   * @param String  $prefix Database Prefix 
   */
  static function setPrefix ($prefix) {
    self::$prefix = $prefix;
    self::instance();
  }

  /**
   * Get the db default prefix
   * @return String Default prefix
   */
  static function getPrefix () {
    return self::$prefix;
  }


}
