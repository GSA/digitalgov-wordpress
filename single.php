<?php get_header(); ?>
  
  <?php 
    $meta = get_post_custom( $post->ID );
    // print_r($meta['_tribe_modified_fields']);
    // echo tribe_get_start_date( $event, false);

  ?>
  <?php single_loop(); ?>
  
<?php get_footer(); ?>