<?php

namespace App\Filters;

class SessionTrueApiFilter
{
  public static function before($f3, $params = null)
  {
    if($_ENV['FF_SESSION'] == 'true'){
      $status = $_SESSION['status'];
      $pass = true;
      if($status != null){
        if($status != 'active'){
          $pass = false;
        }
      }else{
        $pass = false;
      }
      if(!$pass){
        http_response_code(500);
        echo 'HTTP 500 Acceso Prohibido - No se encuentra logeado';
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}