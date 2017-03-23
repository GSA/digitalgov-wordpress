<?php

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

include_once 'functions/wp_enqueue_script.php';
include_once 'functions/wp_actions.php';
include_once 'functions/loop.php';
include_once 'functions/images.php';
include_once 'functions/entry.php';

// Variables
if (! defined('WP_ENV'))
{
	define('WP_ENV', 'production');	// default to production environment
}

$tdir = get_template_directory_uri();
define('TDIR', $tdir);

$theme = get_template_directory_uri();
define('THEME', $theme);

$root = get_template_directory();
define('ROOT', $root);

// Includes Path
$inc = $root . '/inc/';
define('INC', $inc);

// Images Path
$img = $theme . '/assets/img/';
define('IMG', $img);

// Templates Path
$temp = $root . '/templates/';
define('TEMP', $temp);

$home_url = esc_url( home_url( '/' ) );
define('HOMEURL', $home_url);





// Register a Menu
function dg_register_menu() {
  register_nav_menu('site-nav',__( 'Site Nav' ));
  register_nav_menu('footer-nav',__( 'Footer Nav' ));
}
add_action( 'init', 'dg_register_menu' );


// Nav Menu
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
	if( in_array('current-menu-item', $classes) ){
		$classes[] = 'active ';
	}
	return $classes;
}
