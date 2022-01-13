<?php

# app
$f3->route('GET /', '\App\Controllers\HomeController->index');
# rest - student
$f3->route('POST /student/upload', '\App\Controllers\StudentController->upload');
#### user
# error handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
