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

$f3->route('GET /master-data/state','\App\Controllers\HomeController->index');
$f3->route('GET /system','\App\Controllers\HomeController->index');
$f3->route('GET /system/edit/@num','\App\Controllers\HomeController->index');
$f3->route('GET /system/new','\App\Controllers\HomeController->index');
$f3->route('GET /user','\App\Controllers\HomeController->index');
$f3->route('GET /user/edit/@num','\App\Controllers\HomeController->index');
$f3->route('GET /user/new','\App\Controllers\HomeController->index');
#### login
$f3->route('GET /login', '\App\Controllers\LoginController->index');
$f3->route('GET /login/sign-in', '\App\Controllers\LoginController->index');
$f3->route('GET /login/reset-password', '\App\Controllers\LoginController->index');
$f3->route('POST /login', '\App\Controllers\LoginController->access');
$f3->route('GET /log-out', '\App\Controllers\LoginController->logout');
### rest - state
$f3->route('GET /state/list', '\App\Controllers\StateController->list');
$f3->route('POST /state/save', '\App\Controllers\StateController->save');
### rest - specialism
$f3->route('GET /specialism/list', '\App\Controllers\SpecialismController->list');
$f3->route('POST /specialism/save', '\App\Controllers\SpecialismController->save');
#### rest - user
$f3->route('GET /user/info', '\App\Controllers\UserController->info');
$f3->route('GET /user/list', '\App\Controllers\UserController->list');
$f3->route('POST /user/detail/save', '\App\Controllers\UserController->detailSave');
$f3->route('GET /user/get', '\App\Controllers\UserController->get');
#### rest - system
$f3->route('GET /system/list', '\App\Controllers\SystemController->list');
$f3->route('GET /system/get', '\App\Controllers\SystemController->get');
$f3->route('POST /system/detail/save', '\App\Controllers\SystemController->detailSave');
$f3->route('POST /system/save', '\App\Controllers\SystemController->save');
#### rest - file
$f3->route('POST /upload', '\App\Controllers\FileController->upload');
# error handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
