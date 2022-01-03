<?php

require 'vendor/autoload.php';

define('FCPATH', dirname(__FILE__));

$f3 = \Base::instance();

include_once 
  FCPATH . DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'routes.php';

$f3->run();