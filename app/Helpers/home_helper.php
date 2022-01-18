<?php

function stylesheetsHome($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $stylesheets = [
        $staticURL .'bower_components/bootstrap/dist/css/bootstrap.min',
        $staticURL .'bower_components/font-awesome/css/font-awesome.min',
        $staticURL .'assets/css/constants',
        $staticURL .'assets/css/styles',
      ];
      break;
    case 'production':
      $stylesheets = [
        $staticURL .'bower_components/bootstrap/dist/css/bootstrap.min',
        $staticURL .'bower_components/font-awesome/css/font-awesome.min',
        $staticURL .'assets/css/constants',
        $staticURL .'assets/css/styles',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}

function javascriptsHome($staticURL)
{
  $javascripts = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $javascripts = [
        $staticURL . 'bower_components/jquery/dist/jquery.min',
        $staticURL . 'bower_components/bootstrap/dist/js/bootstrap.min',
        $staticURL . 'bower_components/underscore/underscore-min',
        $staticURL . 'bower_components/backbone/backbone-min',
        $staticURL . 'assets/js/app',
      ];
      break;
    case 'production':
      $javascripts = [
        $staticURL . 'bower_components/jquery/dist/jquery.min',
        $staticURL . 'bower_components/bootstrap/dist/js/bootstrap.min',
        $staticURL . 'bower_components/underscore/underscore-min',
        $staticURL . 'bower_components/backbone/backbone-min',
        $staticURL . 'assets/js/app',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}