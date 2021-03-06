<?php

# app
$f3->route('GET /', '\App\Controllers\HomeController->index');
$f3->route('GET /master-data/location','\App\Controllers\HomeController->index');
$f3->route('GET /master-data/specialism','\App\Controllers\HomeController->index');
$f3->route('GET /coa/dentist','\App\Controllers\HomeController->index');
$f3->route('GET /coa/dentist/edit/@num','\App\Controllers\HomeController->index');
$f3->route('GET /coa/dentist/add','\App\Controllers\HomeController->index');
$f3->route('GET /coa/branch','\App\Controllers\HomeController->index');
$f3->route('GET /coa/branch/edit/@num','\App\Controllers\HomeController->index');
$f3->route('GET /coa/branch/add','\App\Controllers\HomeController->index');
#### login
$f3->route('GET /login', '\App\Controllers\LoginController->index');
$f3->route('GET /login/sign-in', '\App\Controllers\LoginController->index');
$f3->route('GET /login/reset-password', '\App\Controllers\LoginController->index');
$f3->route('POST /login', '\App\Controllers\LoginController->access');
$f3->route('GET /log-out', '\App\Controllers\LoginController->logout');
# rest - specialism
$f3->route('GET /specialism/list', '\App\Controllers\SpecialismController->list');
$f3->route('POST /specialism/save', '\App\Controllers\SpecialismController->save');
#### user
$f3->route('GET /user', '\App\Controllers\UserController->info');
# error handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
