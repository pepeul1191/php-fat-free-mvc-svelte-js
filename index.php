<?php

require 'vendor/autoload.php';

$f3 = \Base::instance();

$f3->route('GET /', '\App\Controllers\HomeController->index');

$f3->run();