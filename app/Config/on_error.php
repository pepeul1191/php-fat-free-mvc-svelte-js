<?php 

return function($f3)
{
  if($f3->get('ERROR.code') == 404){
    if($f3->get('VERB') == 'GET'){
      $f3->reroute('/error/access/404');
    }else{
      http_response_code($f3->get(404));
      echo '404 - Recurso no encontrado';
    }
  }else{
    http_response_code($f3->get('ERROR.code'));
    echo json_encode($f3->get('ERROR'));
  }
};