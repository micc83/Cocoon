<?php

namespace Cocoon\Components;
use \Cocoon\Patterns\Singleton;
use \Cocoon\Components\Database;
use \Cocoon\Components\Router;
use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\DatabasePresenceVerifier;

/** 
 * Validator
 */
class Validator {

  use Singleton;

  private $factory;

  /**
   * Initialize the validator
   */
  function init() {
    $translationLoader = new FileLoader(new Filesystem, COCOON_PATH . '/locale');
    $translator = new Translator($translationLoader, 'it');
    $this->factory = new Factory($translator);
    $db = Database::getDatabaseManager();
    $presenceVerifier = new DatabasePresenceVerifier($db);
    $this->factory->setPresenceVerifier($presenceVerifier);
  }

  /**
   * Get the validator
   * @return Illuminate\Validation\Factory Validator factory
   */
  static function getFactory() {
    return self::instance()->factory;
  }

  /**
   * Create a validator
   * @param  Array $data  Array of data to validate
   * @param  Array $rules Validation rules
   * @return Illuminate\Validation\Validator        The actual validator
   */
  static function make($data, $rules) {
    return self::getFactory()->make($data, $rules);
  }

  /**
   * Static function validate
   * @param  Array $data  Array of data to validate
   * @param  Array $rules Validation rules
   * @return Bool       Validation result
   */
  static function validate ($data, $rules) {

    if (isset($data['id']))
      foreach ($rules as $key => $rule)
        $rules[$key] = str_replace('{id}', $data['id'], $rule);

    $validator = self::make($data, $rules);

    if (!$validator->fails())
      return true;

    $service = Router::getKlein()->service();
    foreach($validator->messages()->all() as $message)
      $service->flash($message, 'error');

    return false;
    
  }

}