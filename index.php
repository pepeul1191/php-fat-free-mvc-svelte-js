<?php

require 'vendor/autoload.php';

define('FCPATH', dirname(__FILE__));

$f3 = \Base::instance();

$f3->route('GET /', '\App\Controllers\HomeController->index');
$f3->route('GET /specialism/list', '\App\Controllers\HomeController->specialisms');

$f3->run();