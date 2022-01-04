<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\CsrfFormFilter;
use App\Filters\SessionFalseFilter;

class LoginController extends BaseController
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
    if($path == '/login' && $method == 'GET'){
      SessionFalseFilter::before($f3);
    }else if($path == '/login' && $method == 'POST'){
      CsrfFormFilter::before($f3);
    }
  }

  function index($f3) 
  {
    // session
    $_SESSION['csrfKey'] = $f3->get('csrfKey');
    $_SESSION['csrfValue'] = $f3->get('csrfValue');
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
      $_SESSION['csrfKey'] = \App\Libraries\RandomLib::lowerStringNumber(20);
      $_SESSION['csrfValue'] = \App\Libraries\RandomLib::lowerStringNumber(30);
      $_SESSION['status'] = 'active';
      $_SESSION['user'] = $user;
      $_SESSION['name'] = 'Pepe Valdivia';
      $_SESSION['img'] = $f3->get('staticURL') . 'assets/img/default-user.png';
      $_SESSION['time'] = date('Y-m-d H:i:s');
      $f3->reroute('/');
    }else{
      $f3->reroute($f3->get('PATH') . '?error=user-pass-mismatch');
    }
  }

  function logout($f3)
  {
    $_SESSION = array();
    $f3->reroute('/login');
  }
}