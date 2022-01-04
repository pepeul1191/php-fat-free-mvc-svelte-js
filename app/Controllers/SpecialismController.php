<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class SpecialismController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    SessionTrueApiFilter::before($f3);
    CsrfApiFilter::before($f3);
  }

  function list($f3)
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