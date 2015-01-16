<?php

namespace Cocoon\Models;

/**
 * Post model
 */
class Customer extends BaseModel {

  /**
   * Allowed vars
   * @var array
   */
  protected $fillable = array('name', 'email', 'phone');

}