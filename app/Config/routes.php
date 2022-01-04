<?php

// views
$f3->route('GET /', '\App\Controllers\HomeController->index');
// rest
$f3->route('GET /specialism/list', '\App\Controllers\SpecialismController->list');
// handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
// error handler
$f3->set('ONERROR', include_once 'on_error.php');
