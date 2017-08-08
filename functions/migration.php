<?php

// Controls the Image HTML by modifying the WordPress Image shortcode.
// http://codex.wordpress.org/Function_Reference/add_filter
// This addresses all of the images that were ever inserted into WordPress, with a caption.
// http://codex.wordpress.org/Function_Reference/add_filter
function new_img_shortcode_filter($val, $attr, $content = null) {

  extract(shortcode_atts(array(
    'id'  => '',
    'align' => '',
    'width' => '',
    'caption' => '',
    'src' => ''
  ), $attr));

  // Get the specific ID of the Attachment  
  $find = 'attachment_';
  $cust_id = str_replace($find, '', $id);
  $caption = str_replace('"', '', get_post($cust_id)->post_excerpt);
  $description = get_post($cust_id)->post_content;
  $raw = do_shortcode( $content );
  
  $pattern = '/<img.*?src="([^"]+)"\s*alt="([^"]+)"[^>]+>/'; // the whole SRC
  $liquid = '{{< legacy-img src="$1" alt="$2" caption="'.$caption.'" >}}';
  $imgtag = preg_replace($pattern, $liquid, $raw);

  preg_match('/alt=\"(.+?)\"/', $imgtag, $alttag);
  $alt = str_replace('"', '', $alttag[1]);
  $alt = str_replace('&quot;', '', $alt);

  $pattern = '/alt=\"(.+?)\"/';
  $imgtag = preg_replace($pattern, 'alt="'.$alt.'"', $imgtag);

  return $imgtag;
}
add_filter('img_caption_shortcode', 'new_img_shortcode_filter',2,3);

// the_content img filter
// This addresses all of the images that were ever inserted into WordPress, without a caption.
// It pulls out just the filename for the image SRC
// For regex context, see
// - https://stackoverflow.com/questions/44217482/find-and-transform-image-tags-in-a-block-of-text
// - https://regex101.com/r/E7TRsg/8
function dg_replace_img($match) {
  // print_r($match);
  $alt = str_replace('"', '', $match[2]);
  $alt = str_replace('&quot;', '', $alt);
  $shortcode = '{{< legacy-img src="'.$match[1].'" alt="'.$alt.'" >}}';
  return $shortcode;
}
function dg_img_filter($content) {
  $pattern = '/<img.*?src="([^"]+)"\s*alt="([^"]{0,})"[^>]+>/'; // the whole SRC
  $content = preg_replace_callback($pattern, 'dg_replace_img', $content);
  return $content;
}
add_filter( 'the_content', 'dg_img_filter', 99, 1); 



// Get Co-authors slugs
// A way to get the author slugs from the Co-authors plugin
function dg_author_slugs($id){
  $output = array();
  $authors = get_coauthors( $id );
  // print_r($authors);
  if (empty($authors)) {
    $meta = get_the_author_meta();
    $output = wp_list_pluck( $meta, 'user_nicename' );
    return $output;
  }
  $output = wp_list_pluck( $authors, 'user_nicename' );
  return $output;
}



function dg_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'dg_excerpt_more');

function dg_summary($id){
  $excerpt = get_the_excerpt($id);
  $excerpt = preg_replace('/{{<\s.*?\s>}}/', '', $excerpt);
  $excerpt = preg_replace("/\A'(\X+)\'/", "", $excerpt); // removes single quotes around summary for some posts
  $excerpt = htmlentities($excerpt);
  // $excerpt = preg_replace("/:/", "\:", $excerpt);
  return $excerpt;
}

function dg_title($id){
  $title = get_the_title($id);
  // $title = preg_replace("/\A'(\X+)\'/", "", $title); // removes single quotes around titles
  // $title = htmlentities($title);
  // $title = preg_replace("/:/", "\:", $title);
  // $title = "'" . $title . "'";
  return $title;
}

function dg_date($id){
  // 2013-11-29 00:00:00 -0500
  $date = get_the_date( 'Y-m-d g:i:s O', $id );
  return $date;
}


function dg_content_filters($content) {
  // Shortcodes, YouTube, slideshare, etc...
  $pattern = '/\[youtube=http:\/\/www\.youtube\.com\/watch\?v=(.+)\&w=600]/';
  $content = preg_replace($pattern, '{{< youtube $1 >}}', $content);

  $pattern = '/\[youtube http:\/\/www\.youtube\.com\/watch\?v=(.+)\&w=600]/';
  $content = preg_replace($pattern, '{{< youtube $1 >}}', $content);

  // $pattern = '/\[\syoutube=(.+)\]/';
  // $content = preg_replace($pattern, '{{% video youtube=$1 %}}', $content);

  // $pattern = '/\[slideshare\s(.+)\]/';
  // $content = preg_replace($pattern, '{{% slideshare $1 %}}', $content);

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
