<?php

namespace App\Filters;

class CsrfApiFilter
{
  public static function before($f3, $params = null)
  {
    $headers = $f3->get('HEADERS');
    if($_ENV['FF_CSRF'] == 'true'){
      $sessionCsrfKey = $_SESSION['csrfKey'];
      $sessionCsrfValue = $_SESSION['csrfValue'];
      $pass = true;
      if($headers[ucfirst($sessionCsrfKey)] != null){
        if(
          $headers[ucfirst($sessionCsrfKey)] != $sessionCsrfValue
        ){
          $pass = false;
        }
      }else{
        $pass = false;
      }
      if(!$pass){
        http_response_code(500);
        echo 'HTTP 500 Acceso Prohibido';
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}