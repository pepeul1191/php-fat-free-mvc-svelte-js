<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ErrorController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {}

  function access($f3, $params) 
  {
    // data
    $data = [];
    $status = 404;
    // logic
    switch ($params['code']) {
      case '404':
        $data = [
          'number' => 404,
          'message' => 'Archivo no encontrado',
          'description' => 'La página que busca no se encuentra en el servidor',
          'icon' => 'fa fa-exclamation-triangle',
          'hrefError' => '',
        ];
        $status = 404;
        break;
      case '501':
        $data = [
          'number' => 501,
          'message' => 'Página en Contrucción',
          'description' => 'Lamentamos el incoveniente, estamos trabajando en ello.',
          'icon' => 'fa fa-code-fork',
          'hrefError' => '',
        ];
        $status = 500;
        break;
      case '505':
        $data = [
          'number' => 505, 
          'message' => 'Acceso restringido',
          'description' => 'Necesita estar logueado.',
          'icon' => 'fa fa-ban',
          'hrefError' => 'login',
        ];
        $status = 501;
        break;
      case '8080':
        $data = [
          'number' => 8080, 
          'message' => 'Tiempo de la sesion agotado',
          'description' => 'Vuelva a ingresar al sistema.',
          'icon' => 'fa fa-clock-o',
          'hrefError' => '',
        ];
        $status = 502;
        break;
      default:
        $data = [
          'number' => 404,
          'message' => 'Archivo no encontrado',
          'description' => 'La página que busca no se encuentra en el servidor',
          'icon' => 'fa fa-exclamation-triangle',
          'hrefError' => '',
        ];
        $status = 404;
        break;
    }
    // response
    parent::loadHelper('error');
    $f3->mset(array(
      'title' => 'Error',
      'href' => '/error/access',
      'number' => $data['number'],
      'session' => false,
      'message' => $data['message'],
      'description' => $data['description'],
      'icon' => $data['icon'],
      'hrefError' => $data['hrefError'],
      'stylesheets' => stylesheetsAccess($f3->get('staticURL')),
      'javascripts' => [],
    ));
    // response
    http_response_code($status);
    echo $this->render('error/access', $locals);
  }
}