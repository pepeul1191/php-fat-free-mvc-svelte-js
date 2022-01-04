<?php

namespace App\Controllers;

use App\Filters\BeforeAllFilter;

abstract class BaseController 
{
  function __construct()
  {
    if($_ENV['FF_ENVIRONMENT'] == 'production'){
      $this->baseURL = 'https://softweb.pe/XD';
      $this->staticURL = 'https://softweb.pe/public/';
      $this->csrfKey = 'demo_';
      $this->csrfValue = '123_';
    }else if($_ENV['FF_ENVIRONMENT'] == 'development'){
      $this->baseURL = 'http://localhost:8080/';
      $this->staticURL = '/public/';
      $this->csrfKey = '_demo';
      $this->csrfValue = '_123';
    }
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