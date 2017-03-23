<?php
// Entry — All elements that make up entry

// When there is no excerpt, wp inserts an excerpt that is ~55 words long.
// This truncates it to a shorter length
function custom_excerpt_length( $length ) {
  return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// When there is no excerpt, wp inserts a [...] at the end of the auto-excerpt.
// This replaces the [...] with an empty string.
function new_excerpt_more( $more ) {
  return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

// This is a custom DG function that inserts the Read more tag for excerpts
function dg_excerpt() {
  global $post;
  $excerpt = '<p>' . get_the_excerpt() . ' <a class="more" href="'. get_permalink($post->ID) . '" title="'. get_the_title($post->ID) .'">Read&nbsp;more&nbsp;»</a></p>';
  echo $excerpt;
}


// - - - - - - - - - - 
// IMAGES

function dg_featured_media($size, $source) {
  global $post;
  if ( has_post_thumbnail() ) {
    $thumb = get_the_post_thumbnail( $post->ID, $size);
    $thumb = preg_replace( '/(width|height)="\d*"\s/', "", $thumb ); // Removes height & width
    $thumb = str_replace( 'class="', 'class="img-responsive ', $thumb );
    if (is_single()) {
      echo '<div class="media '.$size.'">' . $thumb . '</div>';
    } else {
      echo '<div class="media '.$size.'"><a href="' . $source . '">' . $thumb . '</a></div>';
    }
    
  }
}



// - - - - - - - - - - 
// META TAGS
function get_meta_keywords(){
  $terms = array();
  $tags = wp_get_post_tags(get_the_ID());
  foreach ($tags as $keyword) {
    $name = $keyword->name;
    array_push($terms, $name);
  }
  $categories = get_the_category( get_the_ID() );
  foreach ($categories as $keyword) {
    $name = $keyword->name;
    array_push($terms, $name);
  }

  $keywords = '';
  if (is_home() || is_archive()) {
    return $keywords = 'Digital, Government, 21st Century Government, Open Government Initiative, U.S. Digital Registry, Mobile, Social Media, Challenges, Code, APIs, Data, Open Source, Open Data, Innovation, Content, Metrics, UX, Usability, Accessibility, CX, Crowdsourcing, Citizen Science, Digital Analytics Program, DAP, Open Gov, OpenGov, Analytics, Metrics, Governance, Strategy, Policy, Community of Practice, Communities, testing, research, case study, case studies, digitalgov, digital gov, OCSIT, GSA, Office of Citizen Services and Innovative Technologies, Digital Government Division, U.S. General Services Administration, Federal Terms of Service, Federal Digital Services, Toolkit, Playbook, Initiatives';
  } else {
    return $keywords = implode(", ",$terms);
  }
}

function get_meta_description(){
  if (is_home() || is_archive()) {
    return $desc = 'Official U.S. Federal Portal for Digital Government from General Services Administration&#039;s Office of Citizen Services and Innovative Technologies.';
  } else {
    return $desc = get_the_excerpt();
  }
}




// - - - - - - - - - - 
// SHARETOOLS

function dg_sharetools($id){
  $link = dg_permalink($id);
  $fb_share = 'http://www.facebook.com/sharer.php?s=100&p[url]=' . $link;
  $twtr = esc_html(get_the_title($id));
  echo <<< EOF
  <p class="dg_sharetools">
    <a class="btn-share btn-share-facebook" href="$fb_share" title=""><i class="fa fa-facebook"></i></a>
    <a class="btn-share btn-share-twitter" href="http://twitter.com/share?text=$twtr&url=$link&via=supchinanews" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
  </p>
EOF;
}



// - - - - - - - - - - 
// BYLINE and DATE
function dg_entry_date( $echo = true ) {
  $date = '<a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'" rel="bookmark"><time class="dt-published published entry-date rel_time" datetime="'.get_the_date('c').'"><span>'.get_the_time('F j, Y g:i a').'</span></time></a>';
  echo $date;
}

function dg_editlink($id){
  $edit = '';
  $status = '';
  if ( is_user_logged_in() ) {
    $status = (get_post_status($id) == 'draft') ? 'draft' : '';
    $editlink = get_edit_post_link($id);
    $edit = '<a class="'.$status.'" href="'.$editlink.'" title="Edit" target="_blank"><i class="fa fa-pencil"></i></a>';
  }
  echo $edit;
}

function dg_byline(){
  $author = get_the_author();
  $author_link = get_author_posts_url(get_the_author_meta( 'ID' ));
  echo 'By <a href="'.$author_link.'" title="'.$author.'">'.$author.'</a>';
}

function dg_permalink($id){
  $link_out = get_post_meta( $id, 'link_out', true );
  if (!empty($link_out)) {
    if ($link_out == 'off') {
      $permalink = get_permalink();
    } else {
      $permalink = get_post_meta( $id, 'source_url', true );
      // print_r($permalink);
      if (empty($permalink)) {
        $permalink = get_post_meta( $id, 'bookmark_url', true );
        // print_r($permalink);
      }
    }
  } else {
    $permalink = get_post_meta( $id, 'bookmark_url', true );
    if (empty($permalink)) {
      $permalink = get_permalink();
    }
  }
  return $permalink;
}



