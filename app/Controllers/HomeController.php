<?php

namespace App\Controllers;

class HomeController 
{
  function __construct()
  {
    // pass
  }

  function beforeroute($f3) {
    echo $path = $f3->get('PATH');
    echo $method = $f3->get('VERB');
  }

  function index() 
  {

    echo 'I cannot object to an object';
  }
}