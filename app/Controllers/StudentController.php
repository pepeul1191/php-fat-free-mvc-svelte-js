<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class StudentController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    //SessionTrueApiFilter::before($f3);
    //CsrfApiFilter::before($f3);
  }

  function upload($f3)
  {
    $resp = '';
    $rand = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
    try {
      // folder name
      $dateTime = new \DateTime();
      $timestamp = $dateTime->getTimestamp();
      // folder
      $path = UPLOAD_PATH . $timestamp;
      mkdir($path, 0755);
      // file
      $extension = explode('.', $_FILES['pdf_file']['name']); $extension = end($extension);
      $status = 200;
      $filePath = $path . '/' . $rand . '.' . $extension;
      move_uploaded_file(
        $_FILES['pdf_file']['tmp_name'], 
        $filePath
      );
      // response
      $resp = json_encode(array(
        'name' => $rand . '.' . $extension,
        'folder' => UPLOAD_PATH . $timestamp . '/',
      ));
    }catch (Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}