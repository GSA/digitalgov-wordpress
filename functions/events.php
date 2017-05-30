<?php
function cptui_register_my_cpts_events() {

  /**
   * Post Type: events.
   */

  $labels = array(
    "name" => __( 'Events', '' ),
    "singular_name" => __( 'event', '' ),
  );

  $args = array(
    "label" => __( 'Events', '' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "events", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  // register_post_type( "tribe_events", $args );
}

// add_action( 'init', 'cptui_register_my_cpts_events' );
