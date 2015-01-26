<?php

use Cocoon\Components\Router;

/**
 * Routes
 */

// Home
Router::add('GET', '/?', array( 'MainController', 'getDashboard' ));

// Customers
Router::add('GET', '/customers/?', array( 'CustomersController', 'getCustomers' ));
Router::add('GET', '/customers/new/?', array( 'CustomersController', 'newCustomer' ));
Router::add('GET', '/customers/[i:id]/?', array( 'CustomersController', 'editCustomer' ));
Router::add('POST', '/customers/?', array( 'CustomersController', 'createCustomer' ));
Router::add('PUT', '/customers/[i:id]/?', array( 'CustomersController', 'updateCustomer' ));
Router::add('DELETE', '/customers/[i:id]', array( 'CustomersController', 'deleteCustomer' ));

/**
 * Handle errors
 */
Router::onHttpError(function ($code, $router) {
  $router->response()->body(
    'Oh no, a bad error happened that caused a <strong>'. $code . '</strong>!'
  );
});

/**
 * Start routing
 */
Router::start();