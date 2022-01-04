<?php

// views
$f3->route('GET /', '\App\Controllers\HomeController->index');
// login
$f3->route('GET /login', '\App\Controllers\LoginController->index');
$f3->route('GET /login/sign-in', '\App\Controllers\LoginController->index');
$f3->route('GET /login/reset-password', '\App\Controllers\LoginController->index');
$f3->route('POST /login', '\App\Controllers\LoginController->access');
// rest
$f3->route('GET /specialism/list', '\App\Controllers\SpecialismController->list');
// handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
// error handler
$f3->set('ONERROR', include_once 'on_error.php');
