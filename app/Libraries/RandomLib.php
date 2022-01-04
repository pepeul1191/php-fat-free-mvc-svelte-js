<?php

namespace App\Libraries;

class RandomLib
{
  private static $initialized = false;
  private static $SNChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  private static $SChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  private static $NChars = '0123456789';

  private static function initialize()
  {
    if (self::$initialized)
      return;
    self::$initialized = true;
  }

  public static function stringNumber($length = 10)
  {
    self::initialize();
    $charactersLength = strlen(self::$SNChars);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= self::$SNChars[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
