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
    SessionTrueApiFilter::before($f3);
    CsrfApiFilter::before($f3);
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

  function send($f3)
  {
    // data
    $payload = $f3->get('POST');
    $createdIds = [];
    $students = json_decode($payload['data']);
		$baseFile = $payload['file'];
    $folder = $payload['folder'];
    $type = $payload['type'];
    $event_id = $payload['event_id'];
    $resp = array();
    try {
      parent::loadHelper('student');
      foreach ($students as &$student) {
        $statusStudent = 'ok';
        try {
          $pathPDF = sendPDF($student, $folder, $baseFile, $type, $event_id, $f3->webURL);
          if($type == 'course' || $type == 'free-course'){
            sendEmail(
              $student->{'email'},
              $student->{'subject'},
              $f3->webURL,
              $pathPDF,
            );
          }
        }catch (Exception $e) {
          $statusStudent = 'error';
        }
        array_push($resp, array(
          '_id' => $student->{'id'},
          'status' => $statusStudent,
        ));
      }
      // response
      $resp = json_encode($resp);
    }catch (Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function deletePDFs($f3)
  {
    parent::loadHelper('student');
    deleleUpload(substr(UPLOAD_PATH, 0, -1));
    mkdir(UPLOAD_PATH, 0755);
    // resp
    http_response_code(200);
    echo 'ok';
  }
}