<?php

namespace Cocoon\Models;
use \Cocoon\Components\Router;

/**
 * Post model
 */
class Customer extends BaseModel {

  /**
   * Allowed vars
   * @var array
   */
  protected $fillable = array('name', 'email', 'phone');

  static $rules = array(
    'name'  =>  'required|between:5,30',
    'email' =>  'required|unique:customers,email,{id}|email',
    'phone' =>  'numeric|between:8,15'
  );

  protected $appends = array(
    'uri' => ''
  );

  public function getURI() {
    return Router::getURI('/customers/' . $this->id);
  }

  public function getUriAttribute(){
    $this->attributes['uri'] = $this->getURI();
    return $this->attributes['uri'];
  }

}