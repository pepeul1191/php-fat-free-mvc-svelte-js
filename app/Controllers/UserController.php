<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\RandomLib;

class UserController extends BaseController
{
  function __construct()
  {
    parent::__construct();
    parent::loadHelper('orm');
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
  }

  function info($f3) 
  {
    // data
    $resp = json_encode([
      'user' => $_SESSION['user'],
      'name' => $_SESSION['name'],
      'img' => $_SESSION['img'],
    ]);
    $status = 200;
    // resp
    http_response_code($status);
    echo $resp;
  }

  function list($f3)
  {
    // data
    $resp = [];
    $status = 200;
    // logic
    try {
      $stmt = \Model::factory('App\\Models\\User', 'access')
        ->select('id')
        ->select('user')
        ->select('email');
      // filter user
      if(
        $f3->get('GET.user') != null
      ){
        $stmt = $stmt->where_like('user', '%' . $f3->get('GET.user') . '%');
      }
      // filter email
      if(
        $f3->get('GET.email') != null
      ){
        $stmt = $stmt->where_like('email', '%' . $f3->get('GET.email'). '%');
      }
      // pages with final statement
      $pages = ceil(
        $stmt->count()
        / $f3->get('GET.step')
      );
      // pagination
      if(
        $f3->get('GET.step') != null && 
        $f3->get('GET.page') != null
      ){
        $offset = ($f3->get('GET.page') - 1) * $f3->get('GET.step');
        $stmt = $stmt->offset($offset)->limit($f3->get('GET.step'));
      }
      $rs = $stmt->find_array();
      $resp = json_encode(array(
        'list' => $rs,
        'pages' => $pages,
      ));
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function detailSave($f3)
  {
    // data
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'), true);
    $createdId = [];
    // logic
    \ORM::get_db('access')->beginTransaction();
    try {
      if($payload['id'] == 'E'){
        // check user or email not exist in created users
        $count = \Model::factory('App\\Models\\User', 'access')
          ->where_raw('user = ? OR email = ?', array($payload['user'], $payload['email']))
          ->count();
        if($count == 0){
          parent::loadHelper('mail');
          $n = \Model::factory('App\\Models\\User', 'access')->create();
          $n->email = $payload['email'];
          $n->password = $payload['password'];
          $n->url_picture = $payload['url_picture'];
          $n->user = $payload['user'];
          $n->reset_key = RandomLib::stringNumber(15);
          $n->activation_key = RandomLib::stringNumber(15);
          $n->save();
          // response data
          $resp = $n->id;
          // send mail
          sendActivationMail();
        }else{
          $status = 501;
          $resp = 'Usuario y/o correo ya registrado';
        }
      }else{
        // check user or email not exist in other users distinct user id to update
        $count = \Model::factory('App\\Models\\User', 'access')
          ->where_raw(
            '(user = ? OR email = ?) AND id != ?', 
            array($payload['user'], $payload['email'], $payload['id'])
          )->count();
        if($count == 0){
          $e = \Model::factory('App\\Models\\User', 'access')->find_one($payload['id']);
          $e->email = $payload['email'];
          $e->user = $payload['user'];
          $e->url_picture = $payload['url_picture'];
          $e->save();
          $resp = '';
        }else{
          $status = 501;
          $resp = 'Usuario y/o correo ya registrados a otro usuario';
        }
      }
      // commit
      \ORM::get_db('access')->commit();
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function get($f3)
  {
    // data
    $resp = [];
    $status = 200;
    $id = $f3->get('GET.id');
    // logic
    try {
      $r = \Model::factory('App\\Models\\User', 'access')->find_one($id);
      $resp = json_encode(array(
        'id' => $r->{'id'},
        'user' => $r->{'user'},
        'email' => $r->{'email'},
        'url_picture' => $r->{'url_picture'},
      ));
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}