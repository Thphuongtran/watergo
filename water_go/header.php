<?php 
   atlantis_setup_language();
?>

<!DOCTYPE html>
<html lang="<?php echo get_locale(); ?>">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

   <title>WaterGo</title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

   <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;700;900&display=swap" rel="stylesheet">

   <?php if( is_page('nearby') && isset($_GET['nearby_page']) && $_GET['nearby_page'] == 'nearby' ){ ?>
      <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
      <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
      <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
   <?php } ?>

   <?php wp_head(); ?>
</head>

<body <?php body_class( ); ?>>