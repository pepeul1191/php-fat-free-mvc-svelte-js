<!DOCTYPE html>
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" href="<?php echo $constants->{'staticURL'}; ?>favicon.ico">
  <meta name="description" content="Sitio Web con SvelteJS">
  <meta name="author" content="Software Web Perú">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php if(isset($stylesheets)) echo loadStylesheets($stylesheets); ?>
  <title><?php echo($title); ?></title>
</head>
<body>