<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class SystemController extends BaseController
{
  function __construct()
  {
    parent::__construct();
    parent::loadHelper('orm');
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    SessionTrueApiFilter::before($f3);
    CsrfApiFilter::before($f3);
  }

  function list($f3)
  {
    // data
    $resp = [];
    $status = 200;
    // logic
    try {
      $rs = \Model::factory('App\\Models\\System', 'access')
        ->select('id')
        ->select('name')
        ->select('repository')
        ->select('branch')
        ->find_array();
      $resp = json_encode($rs);
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
      $r = \Model::factory('App\\Models\\System', 'access')->find_one($id);
      $resp = json_encode(array(
        'id' => $r->{'id'},
        'name' => $r->{'name'},
        'repository' => $r->{'repository'},
        'branch' => $r->{'branch'},
        'value' => $r->{'value'},
        'key' => $r->{'key'},
        'description' => $r->{'description'},
      ));
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function save($f3)
  {
    // data
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'), true);
    $deletes = $payload['deletes'];
    // logic
    \ORM::get_db('access')->beginTransaction();
    try {
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\System', 'access')->find_one($delete['id']);
			    $d->delete();
				}
      }
      // commit
      \ORM::get_db('access')->commit();
      // response data
      $resp = json_encode($createdIds);
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
        $n = \Model::factory('App\\Models\\System', 'access')->create();
        $n->name = $payload['name'];
        $n->description = $payload['description'];
        $n->key = $payload['key'];
        $n->branch = $payload['branch'];
        $n->repository = $payload['repository'];
        $n->value = $payload['value'];
        $n->save();
        $createdId = $n->id;
      }else{
        $e = \Model::factory('App\\Models\\System', 'access')->find_one($payload['id']);
        $e->name = $payload['name'];
        $e->description = $payload['description'];
        $e->key = $payload['key'];
        $e->branch = $payload['branch'];
        $e->repository = $payload['repository'];
        $e->value = $payload['value'];
        $e->save();
      }
      // commit
      \ORM::get_db('access')->commit();
      // response data
      $resp = json_encode($createdId);
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}