<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>

    <title><?php wp_title( '|', true, 'right' ); ?> | <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></title>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <meta http-equiv="Content-Type" content="text/html" charset="<?php bloginfo( 'charset' ); ?>" />

    <meta name="keywords" content="<?php echo get_meta_keywords(); ?>" />
  	<meta name="description" content="<?php echo get_meta_description(); ?>" />
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="canonical" href="">

    <!-- Fonts: Lato / https://www.google.com/fonts#UsePlace:use/Collection:Lato -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Libre+Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  	<!-- RSS -->
  	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

    <?php wp_head(); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  
  <body <?php body_class(); ?>>
    <?php include(INC . 'gov-banner.php'); ?>
    <?php include(INC . 'top-bar.php'); ?>

    <div class="container">
      <?php include(INC . 'header.php'); ?>
      <?php include(INC . 'search-area.php'); ?>

  