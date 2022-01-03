<?php

function loadStylesheets($array_css)
{
  $resp = '';
  foreach ($array_css as &$css) {
    $tmp = '<link rel="stylesheet" type="text/css" href="' . $css . '.css"/>';
    $resp = $resp . $tmp;
  }
  return $resp;
}

function loadJavascripts($array_js)
{
  $resp = '';
  foreach ($array_js as &$js) {
    $tmp = '<script src="' . $js . '.js" type="text/javascript"></script>';
    $resp = $resp . $tmp;
  }
  return $resp;
}