<!DOCTYPE html>
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" href="<?php echo $staticURL; ?>favicon.ico">
  <meta name="description" content="Sitio Web con SvelteJS">
  <meta name="author" content="Software Web Perú">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php if($SESSION != false){ ?><meta name="csrf" key="<?php echo $SESSION['csrfKey']; ?>" value="<?php echo $SESSION['csrfValue']; ?>"><?php } ?>
  <?php if(isset($stylesheets)) echo loadStylesheets($stylesheets); ?>
  <base href="<?php echo $href; ?>">
  <title><?php echo($title); ?></title>
  <script type="text/javascript">
    const BASE_URL = "<?php echo $baseURL;?>";
    const STATIC_URL = "<?php echo $staticURL;?>";
  </script>
</head>
<body>