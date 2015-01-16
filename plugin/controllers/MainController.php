<?php

namespace Cocoon\Controllers;
use Cocoon\Components\Database;
use Cocoon\Components\Template;

/**
 * Main Controller
 */
class MainController extends BaseController {

  /**
   * Get the dashboard
   * @return String Dashboard HTML
   */
  static function getDashboard () {

    return Template::render('dashboard.twig', array(
      'name' => 'Alessandro Benoit'
    ));

  }

}