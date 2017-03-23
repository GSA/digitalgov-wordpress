<?php 
// Navigation bar that shows up everywhere (Conditional)
$args = array(
  'theme_location'  => 'site-nav',
  'menu_class'      => 'nav',
  'menu_id'         => 'menu-main-nav',
  'container'       => 'nav',
  'container_class' => 'nav-area',
  'container_id'    => 'site-nav',
  'echo'            => true,
  'before'          => '',
  'after'           => '',
  'link_before'     => '',
  'link_after'      => '',
  'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
);
wp_nav_menu( $args );