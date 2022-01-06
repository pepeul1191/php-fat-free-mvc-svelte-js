<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
  function __construct()
  {
    parent::__construct();
    parent::loadHelper('orm');
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

  function list($f3)
  {
    // data
    $resp = [];
    $status = 200;
    // logic
    try {
      $stmt = \Model::factory('App\\Models\\User', 'access')
        ->select('id')
        ->select('user')
        ->select('email');
      // filter user
      if(
        $f3->get('GET.user') != null
      ){
        $stmt = $stmt->where_like('user', '%' . $f3->get('GET.user') . '%');
      }
      // filter email
      if(
        $f3->get('GET.email') != null
      ){
        $stmt = $stmt->where_like('email', '%' . $f3->get('GET.email'). '%');
      }
      // pages with final statement
      $pages = ceil(
        $stmt->count()
        / $f3->get('GET.step')
      );
      // pagination
      if(
        $f3->get('GET.step') != null && 
        $f3->get('GET.page') != null
      ){
        $offset = ($f3->get('GET.page') - 1) * $f3->get('GET.step');
        $stmt = $stmt->offset($offset)->limit($f3->get('GET.step'));
      }
      $rs = $stmt->find_array();
      $resp = json_encode(array(
        'list' => $rs,
        'pages' => $pages,
      ));
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}