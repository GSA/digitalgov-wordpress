<?php
// These are the additional image sizes that will be cut when adding an image to WP
add_image_size('w50', 50, 50, true );
add_image_size('w75', 75, 75, true );
add_image_size('w150', 150, 100, false );
add_image_size('sq225', 225, 225, true );
add_image_size('w300', 300, 300, true );
add_image_size('w600', 600, 450, true );
add_image_size('featured', 920, 9999, true);

// These are the sizes that show up in the Admin
$dg_imgsizes = array(
  "w75" => __("Thumb (75)"),
  "w100S" => __("Square (100)")
);

function custom_image_sizes($sizes) {
  global $dg_imgsizes;
  $newimgsizes = array_merge($sizes, $dg_imgsizes);
  return $newimgsizes;
}
add_filter('image_size_names_choose', 'custom_image_sizes');

// add_image_size( 'homepage-thumb', 280, 180, true ); //(cropped)




// // Controls the Image HTML by modifying the WordPress Image shortcode.
// // http://codex.wordpress.org/Function_Reference/add_filter
function new_img_shortcode_filter($val, $attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => '',
		'src' => ''
	), $attr));

  
  // Get the specific ID of the Attachment  
  $find = 'attachment_';
  $cust_id = str_replace($find, '', $id);

  $caption = get_post($cust_id)->post_excerpt;
  $description = get_post($cust_id)->post_content;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '"';
	}

  $raw = do_shortcode( $content );

  // Removes Height and Width from images
  $img = preg_replace( '/(width|height)="\d*"\s/', "", $raw);
  // adds in the .img-responsive class to all images
  $img = str_replace('class="', 'class="img-responsive ', $img);
  

  if ($width == 75 || $width == 163 ) { // if image doesn't need a caption
    return '<div class="media w'.(0 + (int) $width).'">' . $img . '</div>';
  } else { // all other images
    return '<div class="media w'.(0 + (int) $width).'">' . $img . '<p class="caption">' . $caption . '</p></div>';
  }
}
add_filter('img_caption_shortcode', 'new_img_shortcode_filter',10,3);







/******    REWRITE THE GALLERY FUNCTION FROM WORDPRESS   **********/

add_shortcode('gallery', 'dg_gallery_shortcode');

function dg_gallery_shortcode($attr) {
  $counter=0;

    $post = get_post();

static $instance = 0;
$instance++;

if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
        $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
}


// Allow plugins/themes to override the default gallery template.
$output = apply_filters('post_gallery', '', $attr);
if ( $output != '' )
    return $output;

// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
        unset( $attr['orderby'] );
}

extract(shortcode_atts(array(

/******    CHANGE TO FULL SIZE TO GET THE CORRECT INFORMATION **********/
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'Full size',
    'include'    => '',
    'exclude'    => ''
), $attr));

/***********************************************************************/

$id = intval($id);
if ( 'RAND' == $order )
    $orderby = 'none';

if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
    }
} elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
} else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
}

if ( empty($attachments) )
    return '';

if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
        $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
}

$itemtag = tag_escape($itemtag);
$captiontag = tag_escape($captiontag);
$icontag = tag_escape($icontag);
$valid_tags = wp_kses_allowed_html( 'post' );
if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

$columns = intval($columns);
$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
$float = is_rtl() ? 'right' : 'left';

$selector = "gallery-{$instance}";
$gallery_div ="<div class='pictures-content'>";
$gallery_style ="";

$output = apply_filters( 'gallery_style', "\n\t\t" . $gallery_div );

$i = 0;
$count=0;
$c=0;

$output .= <<<EOF

EOF;
$output .= "<div id='carousel-post-".$post->ID."' class='carousel slide' data-ride='carousel'>\n";
$output .= "<ol class='carousel-indicators'>\n";

foreach ( $attachments as $id => $attachment ) {
  if ($c == 0) {
    $output .= "<li data-target='#carousel-post-".$post->ID."' data-slide-to='".$c."' class='active'></li>\n";
  } else {
    $output .= "<li data-target='#carousel-post-".$post->ID."' data-slide-to='".$c."'></li>\n";
  }
  $c++;
}
$output .= "</ol>\n";

$output .= "<div class='carousel-inner'>\n";
foreach ( $attachments as $id => $attachment ) {
  $test = $attachments[$id];
  $link = $test->guid;
  if ($count == 0) {
    $output .= "<div class='item active'><img src='$link'/></div>";
  } else {
    $output .= "<div class='item'><img src='$link'/></div>";
  }
  $count++;
}
$output .= "</div>\n";
$output .= <<<EOF
  <a class="left carousel-control" href="#carousel-post-$post->ID" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-post-$post->ID" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
EOF;
$output .= "</div>\n";
$output .= "</div>\n";
// $output .= "</div>\n";
return $output;
}
