<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class StateController extends BaseController
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
      $rs = \Model::factory('App\\Models\\State', 'access')
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

  function save($f3)
  {
    // data
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'), true);
    $createdIds = [];
    $news = $payload['news'];
		$edits = $payload['edits'];
    $deletes = $payload['deletes'];
    // logic
    \ORM::get_db('access')->beginTransaction();
    try {
      // news
      if(count($news) > 0){
				foreach ($news as &$new) {
				  $n = \Model::factory('App\\Models\\State', 'access')->create();
					$n->name = $new['name'];
					$n->save();
				  $temp = [];
				  $temp['tempId'] = $new['id'];
	        $temp['newId'] = $n->id;
	        array_push($createdIds, array(
            'tmp' => $new['id'],
            'id' => $n->id,
          ));
				}
      }
      // edits
      if(count($edits) > 0){
				foreach ($edits as &$edit) {
          $e = \Model::factory('App\\Models\\State', 'access')->find_one($edit['id']);
					$e->name = $edit['name'];
					$e->save();
        }
      }
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\State', 'access')->find_one($delete['id']);
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
}