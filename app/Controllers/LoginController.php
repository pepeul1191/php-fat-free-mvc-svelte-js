<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
  }

  function index($f3) 
  {
    // session
    $f3->set('SESSION.csrfKey', $f3->get('csrfKey'));
    $f3->set('SESSION.csrfValue', $f3->get('csrfValue'));
    // response
    parent::loadHelper('login');
    $f3->mset(array(
      'title' => 'Inicio',
      'href' => '/login',
      'stylesheets' => stylesheetsIndex($f3->get('staticURL')),
      'javascripts' => javascriptsIndex($f3->get('staticURL')),
    ));
    http_response_code(200);
    echo $this->render('login/index', $locals);
  }
}