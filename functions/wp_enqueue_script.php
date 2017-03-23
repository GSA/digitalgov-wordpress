<?php

function dg_scripts() {
  $assets = array(
    'flexboxgrid'       => '/assets/css/flexboxgrid.min.css',
    'font-awesome'       => 'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
    'css'       => '/assets/css/main.css',
    'js'        => '/assets/js/main.js',
    'uswdsjs'        => '/assets/js/uswds.min.js',
    // 'modernizr' => '/assets/vendor/modernizr/modernizr.js',
    'moment'    => '/assets/js/moment.js',
    'jquery'    => 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js'
  );
  wp_enqueue_style('dg_flexboxgrid', get_template_directory_uri() . $assets['flexboxgrid'], false, null);
  wp_enqueue_style('dg_font-awesome', $assets['font-awesome'], false, null);
  wp_enqueue_style('dg_css', get_template_directory_uri() . $assets['css'], false, null);

  // Le JS
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', $assets['jquery'], array(), null, false);
    add_filter('script_loader_src', 'roots_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('jquery');
  wp_enqueue_script('moment', get_template_directory_uri() . $assets['moment'], array(), null, true);
  wp_enqueue_script('uswdsjs', get_template_directory_uri() . $assets['uswdsjs'], array(), null, true);
  wp_enqueue_script('js', get_template_directory_uri() . $assets['js'], array(), null, true);
  
}
add_action('wp_enqueue_scripts', 'dg_scripts', 100);
