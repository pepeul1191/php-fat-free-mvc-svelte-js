<?php

if($_ENV['FF_ENVIRONMENT'] == 'production'){
  return array(
    'baseURL' => 'https://softweb.pe/XD',
    'staticURL' => 'https://softweb.pe/public/',
    'webURL' => 'https://legisjuristas.com/',
    'csrfKey' => 'demo_',
    'csrfValue' => '123_',
  );
}else if($_ENV['FF_ENVIRONMENT'] == 'development'){
  return array(
    'baseURL' => 'http://localhost:8080/',
    'webURL' => 'https://localhost:8090/',
    'staticURL' => '/public/',
    'csrfKey' => '_demo',
    'csrfValue' => '_123',
  );
}
