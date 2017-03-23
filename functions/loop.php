<?php

function single_loop(){
	if (have_posts()) {
		while (have_posts()) {
			the_post();
      get_template_part('content', '' );
		}
	}
}

function collection_loop(){
  if (have_posts()) {
    $i = 1;
    echo '<div class="row">';
    while (have_posts()) {
      the_post();
      
      get_template_part('content', 'promo' );

      if ( $i % 3 === 0 ) { echo '</div><div class="row">'; }
      $i++;
    }
    echo '</div>';
  }
}