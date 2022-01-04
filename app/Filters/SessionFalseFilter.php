<?php

namespace App\Filters;

class SessionFalseFilter
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
      if($pass){
        $f3->reroute('/');
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}