<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

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
    // logger
    $logger = new Logger('my_logger');
    // data
    $status = 200;
    $payload = $f3->get('POST');
    $createdIds = [];
    $students = json_decode($payload['data']);
		$baseFile = $payload['file'];
    $folder = $payload['folder'];
    $type = $payload['type'];
    $event_id = $payload['event_id'];
    $resp = array();
    $logger->pushHandler(new StreamHandler($folder . 'sendding.log', Logger::DEBUG));
    $logger->pushHandler(new FirePHPHandler());
    try {
      parent::loadHelper('student');
      foreach ($students as &$student) {
        try {
          $pdfInfo = doPDF($student, $folder, $baseFile, $type, $event_id, $f3->webURL);
          $logger->info('Certificado (' . $type . ') del alumno ' . $student->{'last_names'} . ' ' . $student->{'first_names'} . 'creado. ');
          if($type == 'course' || $type == 'free-course'){
            sendEmail(
              $student,
              $f3->webURL,
              $pdfInfo,
            );
            $logger->info('Certificado (' . $type . ') del alumno ' . $student->{'last_names'} . ' ' . $student->{'first_names'} . 'enviado al correo ' . $student->{'email'} . '.');
          }
        }catch (Exception $e) {
          $logger->error('El certificado del alumno ' . $student . 'no ha sido creado correctamente o enviado');
        }
      }
      // download zip
      $zipper = new \Chumper\Zipper\Zipper;
      $files = glob($folder . '*');
      $rand = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
      $zipper->make(UPLOAD_PATH . $rand . '.zip');
      $zipper->add($files); 
      $zipper->close();
      // response
      $resp = 'uploads/' . $rand . '.zip';
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
    system('rm -rf '.escapeshellarg(UPLOAD_PATH));
    mkdir(UPLOAD_PATH, 0755);
    // resp
    http_response_code(200);
    echo 'ok';
  }
}
