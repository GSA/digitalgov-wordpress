<?php

// Hide WP Admin Bar
add_filter('show_admin_bar', '__return_false');

// infinite-scroll
add_theme_support( 'infinite-scroll', array(
  'type'           => 'click',
  'container'      => 'stream-box',
  'render'         => 'stream_loop'
) );

// Post Thumbs / Featured Image
add_theme_support( 'post-thumbnails' );