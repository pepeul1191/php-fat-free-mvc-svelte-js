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

  function beforeroute($f3) {
    BeforeAllFilter::before($f3);
  }
}