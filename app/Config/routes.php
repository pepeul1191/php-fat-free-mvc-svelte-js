<?php

# app
$f3->route('GET /', '\App\Controllers\HomeController->index');
# rest - student
$f3->route('POST /student/upload', '\App\Controllers\StudentController->upload');
$f3->route('POST /student/send', '\App\Controllers\StudentController->send');
$f3->route('GET /student/delete-pdfs', '\App\Controllers\StudentController->deletePDFs');
#### user
# error handler
$f3->route('GET /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
