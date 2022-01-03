<?php

namespace App\Filters;

class BeforeAllFilter
{
  public static function before($f3, $params = null)
  {
    echo 'beforeAllFilter<br>';
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}