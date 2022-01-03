<?php

namespace App\Controllers;

use App\Filters\BeforeAllFilter;

abstract class BaseController 
{
  function __construct()
  {
    // pass
    echo 'constructor padre<br>';
  }

  function loadHelper($helper)
  {
    include_once BASE_PATH . '/app/Helpers/' . $helper . 'Helper.php';
  }

  function beforeroute($f3) {
    BeforeAllFilter::before($f3);
  }

  function render($template)
  {
    $this->loadHelper('View');
    $view = new \View;
    echo $view->render('app/Views/' . $template . '.php');
  }
}