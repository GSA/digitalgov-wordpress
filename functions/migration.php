<?php

// the_content img filter
// This addresses all of the images that were ever inserted into WordPress, without a caption.
// It pulls out just the filename for the image SRC
// For regex context, see
// - https://stackoverflow.com/questions/44217482/find-and-transform-image-tags-in-a-block-of-text
// - https://regex101.com/r/E7TRsg/8
function dg_img_filter($content) {
  // $pattern = '/<img.*?src=".*\/(?!>)([^"]+)"\s*alt="([^"]+)"[^>]+>/'; // just the SRC filename.jpg
  $pattern = '/<img.*?src="([^"]+)"\s*alt="([^"]+)"[^>]+>/'; // the whole SRC
  $liquid = '{% img="$1" alt="'.htmlspecialchars('$2', ENT_QUOTES, 'UTF-8').'" %}';
  $content = preg_replace($pattern, $liquid, $content);
  return $content;
}
add_filter( 'the_content', 'dg_img_filter', 99, 1); 


// WordPress Image shortcode filter
// This addresses all of the images that were ever inserted into WordPress, with a caption.
// http://codex.wordpress.org/Function_Reference/add_filter
function dg_img_shortcode_filter($val, $attr, $content = null) {
  $raw = do_shortcode( $content );
  // $pattern = '/<img.*?src=".*\/(?!>)([^"]+)"\s*alt="([^"]+)"[^>]+>/'; // just the SRC filename.jpg
  $pattern = '/<img.*?src="([^"]+)"\s*alt="([^"]+)"[^>]+>/'; // the whole SRC
  $liquid = '{% img="$1" alt="'.htmlspecialchars('$2', ENT_QUOTES, 'UTF-8').'" %}';
  $raw = preg_replace($pattern, $liquid, $raw);
  return $raw;
}
add_filter('img_caption_shortcode', 'dg_img_shortcode_filter',1,3);



// Get Co-authors slugs
// A way to get the author slugs from the Co-authors plugin
// e.g. eric-mill, omid-ghaffari-tabrizi, waldo-jaquith
function dg_author_slugs($id){
  $authors = get_coauthors( $id );
  if (empty($authors)) {
    $slug = get_the_author_meta( 'user_nicename' );
    return $slug;
  }
  $slugs = '';
  foreach ($authors as $author) {
    if ($author === end($authors)){
      $slugs .= $author->user_nicename . '';
    } else {
      $slugs .= $author->user_nicename . ', ';
    }
  }
  return $slugs;
}



function dg_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'dg_excerpt_more');

function dg_summary($id){
  $excerpt = get_the_excerpt($id);
  $excerpt = preg_replace('/{%\s.*?\s%}/', '', $excerpt);
  $excerpt = preg_replace("/\A'(\X+)\'/", "", $excerpt); // removes single quotes around summary for some posts
  return $excerpt;
}

function dg_title($id){
  $title = get_the_title($id);
  $title = preg_replace("/\A'(\X+)\'/", "", $title); // removes single quotes around titles
  return $title;
}

function dg_date($id){
  // 2013-11-29 00:00:00 -0500
  $date = get_the_date( 'Y-m-d g:i:s O', $id );
  return $date;
}


function dg_content_filters($content) {
  $pattern = '/<span\sstyle="font-weight:\s400">.*?(.+)<\/span>/';
  $content = preg_replace($pattern, '$1', $content);

  // <p style="padding-left: 30px"> ... </p>
  $pattern = '/<p\sstyle="padding-left:\s30px">(\X+)<\/p>/U';
  $content = preg_replace($pattern, '<p>$1</p>', $content);

  // <p style="text-align: center;"> ... </p>
  $pattern = '/<p\sstyle="text-align:\scenter;">(\X+)<\/p>/U';
  $content = preg_replace($pattern, '<p>$1</p>', $content);

  // // <p style="text-align: left">
  $pattern = '/<p\sstyle="text-align:\sleft;">(\X+)<\/p>/U';
  $content = preg_replace($pattern, '<p>$1</p>', $content);

  // <span style="line-height: 1.5em"> ... </span>
  $pattern = '/<span\sstyle="line-height:\s1.5em">(\X+)<\/span>/U';
  $content = preg_replace($pattern, '$1', $content);  

  // <div class="hdivider"></div>
  $pattern = '/<div\sclass="hdivider"><\/div>/U';
  $content = preg_replace($pattern, '', $content);  

  return $content;
}

add_filter('the_content', 'dg_content_filters');


if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
