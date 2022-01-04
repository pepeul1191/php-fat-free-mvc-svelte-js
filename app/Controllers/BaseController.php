<?php

namespace App\Controllers;

use App\Filters\BeforeAllFilter;

abstract class BaseController 
{
  function __construct()
  {
    // PASS
    session_start();
  }

  function loadHelper($helper)
  {
    include_once BASE_PATH . '/app/Helpers/' . $helper . '_helper.php';
  }

  function beforeroute($f3) {
    BeforeAllFilter::before($f3);
  }

  function render($template)
  {
    $this->loadHelper('view');
    $view = new \View;
    echo $view->render('app/Views/' . $template . '.php');
  }
}