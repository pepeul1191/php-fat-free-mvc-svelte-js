<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueFilter;

class HomeController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    $path = $f3->get('PATH');
    $method = $f3->get('VERB');
    if($path == '/'){
      SessionTrueFilter::before($f3);
    }
  }

  function index($f3) 
  {
    parent::loadHelper('home');
    $f3->mset(array(
      'title' => 'Inicio',
      'href' => '/login',
      'stylesheets' => stylesheetsHome($f3->get('staticURL')),
      'javascripts' => javascriptsHome($f3->get('staticURL')),
    ));
    http_response_code(200);
    echo $this->render('home/index', $locals);
  }

  function specialisms($f3)
  {
    parent::loadHelper('orm');
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
    http_response_code($status);
    echo $resp;
  }
}