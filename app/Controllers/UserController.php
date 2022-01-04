<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
  }

  function info($f3) 
  {
    // data
    $resp = json_encode([
      'user' => $_SESSION['user'],
      'name' => $_SESSION['name'],
      'img' => $_SESSION['img'],
    ]);
    $status = 200;
    // resp
    http_response_code($status);
    echo $resp;
  }
}