<?php

namespace App\Filters;

class CsrfFormFilter
{
  public static function before($f3, $params = null)
  {
    if($_ENV['FF_CSRF'] == 'true'){
      if(
        $f3->get('csrfKey') != $_SESSION['csrfKey'] 
        || 
        $f3->get('csrfValue') != $_SESSION['csrfValue'] 
      ){
        $f3->reroute($f3->get('PATH') . '?error=csrf-mismatch');
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}