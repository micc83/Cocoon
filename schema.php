<?php

use Cocoon\Components\Database;

class CooconSchema {

  static private $versions = array(
    '1.0.0' => 'create_customers_table'
  );

  /**
   * First database revision
   */
  static function create_customers_table () {

    Database::schema()->create( Database::getPrefix() . 'customers', function ($table) {
      $table->increments('id');
      $table->string('name', 100);
      $table->string('email');
      $table->string('phone');
      $table->softDeletes();
      $table->timestamps();
    });

  }

  /**
   * Create and check if db tables need to be updated
   * Get the current db version from wp_options
   */
  static function verifyVersion () {

    $current_version = get_option('cocoon_db_version', 0);

    foreach( self::$versions as $version => $callbackMethod )
      if ( version_compare($current_version, $version) < 0 ){
        call_user_func(array('CooconSchema', $callbackMethod));
        update_option('cocoon_db_version', $version);
      }
    
  }

}