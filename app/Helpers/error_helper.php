<?php

function stylesheetsAccess($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $stylesheets = [
        $staticURL . 'build/bundle.error',
      ];
      break;
    case 'production':
      $stylesheets = [
        $staticURL . 'build/bundle.error.min',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}
