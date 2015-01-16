<?php

namespace Cocoon\Controllers;
use Cocoon\Components\Database;
use Cocoon\Components\Template;
use Cocoon\Components\Router;
use Cocoon\Models\Customer;

/**
 * Main Controller
 */
class CustomersController extends BaseController {

  /**
   * Get all the customers View
   * @return String Dashboard HTML
   */
  static function getCustomers ($request, $response, $service) {

    return Template::render('customers/index.twig', array(
      'customers' => Customer::all()
    ));

  }

  /**
   * Edit a single customer View
   * @return String Dashboard HTML
   */
  static function editCustomer ($request, $response, $service) {

    return Template::render('customers/edit.twig', array(
      'action'    =>  Router::getURI('/customers/' . $request->id),
      'method'    =>  'PUT',
      'customer'  =>  Customer::find($request->id),
      'infos'     =>  $service->flashes('info'),
      'errors'    =>  $service->flashes('error')
    ));

  }

  /**
   * Update the customer and redirect back
   */
  static function updateCustomer ($request, $response, $service) {

    // Validation
    try {
      $service->validateParam('name', 'Name must be set')->notNull();
      $service->validateParam('email', 'Email was not in the correct format')->isEmail()->notNull();
    } catch (\Exception $e) {
      $service->flash($e->getMessage());
      return $service->back();
    }

    // Update
    $customer = Customer::find($request->id)->update($request->params());

    // Verify update
    if (!$customer){
      $service->flash('The specified customer doesn\'t exist anymore', 'error');
      return $service->back();
    }

    $service->flash('Customer data updated!', 'info');
    $service->back();

  }

  /**
   * New Customer View
   * @return String HTML template
   */
  static function newCustomer ($request, $response, $service) {

    return Template::render('customers/new.twig', array(
      'action'    =>  Router::getURI('/customers/'),
      'method'    =>  'POST',
      'customer'  =>  $request->params(),
      'infos'     =>  $service->flashes('info'),
      'errors'    =>  $service->flashes('error')
    ));

  }

  /**
   * Create customer
   */
  static function createCustomer ($request, $response, $service) {

    // Validation
    try {
      $service->validateParam('name', 'Name must be set')->notNull();
      $service->validateParam('email', 'Email was not in the correct format')->isEmail()->notNull();
    } catch (\Exception $e) {
      $service->flash($e->getMessage());
      return $service->back();
    }

    // Update
    $customer = Customer::create($request->params());

    // Verify update
    if (!$customer){
      $service->flash('There was an error trying to create the user', 'error');
      return $service->back();
    }

    $service->flash('Customer created', 'info');
    $response->redirect(Router::getURI('/customers/' . $customer->id));

  }


}