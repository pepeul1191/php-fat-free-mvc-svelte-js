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

  function access($f3, $args)
  {
    $payload = $f3->get('POST');
    $user = $payload['user'];
    $password = $payload['password'];
    if($user == 'admin' && $password == '123'){
      $f3->set('SESSION.csrfKey', \App\Libraries\RandomLib::stringNumber(20));
      $f3->set('SESSION.csrfValue', \App\Libraries\RandomLib::stringNumber(30));
      $f3->set('SESSION.status', 'active');
      $f3->set('SESSION.user', $user);
      $f3->set('SESSION.name', 'Pepe Valdivia');
      $f3->set('SESSION.img', $f3->get('staticURL') . 'assets/img/default-user.png');
      $f3->set('SESSION.time', date('Y-m-d H:i:s'));
      header('Location: ' . '/');
      exit();
    }else{
      $f3->reroute($f3->get('PATH') . '?error=user-pass-mismatch');
      exit();
    }
  }
}