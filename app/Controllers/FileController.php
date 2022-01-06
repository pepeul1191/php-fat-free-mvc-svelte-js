<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class FileController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    $path = $f3->get('PATH');
    SessionTrueApiFilter::before($f3);
    CsrfApiFilter::before($f3);
  }

  function upload($f3)
  {
    $resp = '';
    $rand = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
    try {
      $extension = explode('.', $_FILES['file']['name']); $extension = end($extension);
      $status = 200;
      $path = UPLOAD_PATH. $rand . '.' . $extension;
      $response_path = 'uploads/' . $rand . '.' . $extension;
      if(
        $f3->get('POST.path') != null
      ){
        $path = UPLOAD_PATH. $rand . '.' . $extension;
        $response_path = 'uploads/' . $f3->get('POST.path') . '/' . $rand . '.' . $extension;
      }
      move_uploaded_file(
        $_FILES['file']['tmp_name'], 
        $path
      );
      $resp = $response_path;
    }catch (Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}