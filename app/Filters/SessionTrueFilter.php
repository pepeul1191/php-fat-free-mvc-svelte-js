<?php

namespace App\Filters;

class SessionTrueFilter
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
        $f3->reroute('/error/access/505');
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}