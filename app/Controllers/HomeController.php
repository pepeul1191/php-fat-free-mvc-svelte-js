<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) {
    parent::beforeroute($f3);
    echo 'beforeHomeFilter<br>';
  }

  function index() 
  {

    echo 'I cannot object to an object';
  }
}