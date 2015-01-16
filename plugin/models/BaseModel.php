<?php
/**
 * Base Model
 * @uses http://laravel.com/docs/4.2/eloquent
 */

namespace Cocoon\Models;
use Cocoon\Components\Database;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Base model
 */
class BaseModel extends Eloquent {

  // Set the connection name to be used by Eloquent ORM
  protected $connection = 'default';

}