<?php

function stylesheetsHome($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $stylesheets = [
        $staticURL . 'build/bundle.app',
      ];
      break;
    case 'production':
      $stylesheets = [
        $staticURL . 'build/bundle.app',
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
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/bundle.app',
      ];
      break;
    case 'production':
      $javascripts = [
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/bundle.app.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}