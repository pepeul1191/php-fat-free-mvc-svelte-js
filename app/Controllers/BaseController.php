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
    include_once FCPATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR  . 'Helpers' . DIRECTORY_SEPARATOR. $helper . 'Helper.php';
  }

  function beforeroute($f3) {
    BeforeAllFilter::before($f3);
  }
}