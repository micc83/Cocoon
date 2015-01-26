<?php

use Cocoon\Components\Router;

/**
 * Routes
 */

// Home
Router::add('GET', '/?', array( 'Cocoon\Controllers\MainController', 'getDashboard' ));

// Customers
Router::add('GET', '/customers/?', array( 'Cocoon\Controllers\CustomersController', 'getCustomers' ));
Router::add('GET', '/customers/new/?', array( 'Cocoon\Controllers\CustomersController', 'newCustomer' ));
Router::add('GET', '/customers/[i:id]/?', array( 'Cocoon\Controllers\CustomersController', 'editCustomer' ));
Router::add('POST', '/customers/?', array( 'Cocoon\Controllers\CustomersController', 'createCustomer' ));
Router::add('PUT', '/customers/[i:id]/?', array( 'Cocoon\Controllers\CustomersController', 'updateCustomer' ));
Router::add('DELETE', '/customers/[i:id]', array( 'Cocoon\Controllers\CustomersController', 'deleteCustomer' ));

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