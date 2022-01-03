<?php

$f3->route('GET /', '\App\Controllers\HomeController->index');
$f3->route('GET /specialism/list', '\App\Controllers\HomeController->specialisms');
