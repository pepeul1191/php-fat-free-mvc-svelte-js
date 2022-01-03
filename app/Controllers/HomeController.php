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

  function specialisms()
  {
    parent::loadHelper('ORM');
    // data
    $resp = [];
    $status = 200;
    // logic
    try {
      $rs = \Model::factory('App\\Models\\Speciailism', 'classroom')
        ->find_array();
      $resp = json_encode($rs);
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    echo $resp;
  }
}