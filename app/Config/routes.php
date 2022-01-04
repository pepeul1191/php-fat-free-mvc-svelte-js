<?php

$f3->route('GET /', '\App\Controllers\HomeController->index');
$f3->route('GET /specialism/list', '\App\Controllers\SpecialismController->list');
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
// error
$f3->set('ONERROR', include_once 'on_error.php');
