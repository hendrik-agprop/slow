<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package slow
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function slow_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'slow_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function slow_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'slow_pingback_header' );

/**
 * Custom navigations
 */
function slow_nav_menu( $theme_location, $classes = '', $list_classes = '' ) {

  if( ! $theme_location ) return false;

  $theme_locations = get_nav_menu_locations();
  if( ! isset( $theme_locations[$theme_location] ) ) return false;
 
  $menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
  if( ! $menu_obj ) return false;

  $menu_items = wp_get_nav_menu_items( $menu_obj );
  if ( ! $menu_items ) return false;

  echo '<nav id="' . $theme_location . '" class="navigation ' . $classes . '">';
  echo '<ul class="navigation-items list list-unstyled ' . $list_classes . '">';

  foreach ($menu_items as $item) {
    echo '<li class="navigation-item">';
    echo '<a href="' . $item->url . '">' . $item->title . '</a>';
    echo '</li>';
  }

  echo '</ul>';
  echo '</nav>';
  echo '<div class="navigation-burger"></div>';
}

/**
 * Custom excerpt from body content
 */
function slow_excerpt( $post = null, $length = 500 ) {
  
  $content = get_field( 'custom_content', $post->ID );

  for ($i = 0; $i < sizeof( $content ); $i++) { 

    $paragraph = $content[$i];

    switch ( $paragraph['acf_fc_layout'] ) {
      case 'custom_content_text':
        slow_custom_content_text( $paragraph, '', $length );
        return;
      default:
        break;
    } 
  }
}

/**
 * Body content loop functions
 */
function slow_custom_content( $post = null, $head = true, $tail = true, $length = 10000 ) {

  if ( !$post ) return false;

  $content = get_field( 'custom_content', $post->ID );
  $paragraph_count = sizeof( $content );

  if ( $paragraph_count == 0 ) return false;
  if ( !$head AND $tail AND $paragraph_count == 1 ) return false;

  $display_count = $paragraph_count;
  $start_index = 0;

  if ($head == true AND $tail == true) {
    // display all content paragraphs
  } elseif ($head == true) {
    // display only the first
    $display_count = 1;
  } elseif ($tail == true) {
    // display all but the first
    $display_count = $paragraph_count;
    $start_index = 1;
  }

  for ($i = $start_index; $i < $display_count; $i++) { 

    $paragraph = $content[$i];
    $classes = ($head == false AND $tail == true) ? 'container--small' : '';

    switch ( $paragraph['acf_fc_layout'] ) {
      case 'custom_content_text':
        slow_custom_content_text( $paragraph, $classes, $length );
        break;
      case 'custom_content_image':
        slow_custom_content_image( $paragraph, $classes );
        break;
      case 'custom_content_gallery':
        slow_custom_content_gallery( $paragraph, 'container--full' );
        break;
      case 'custom_content_video':
        $classes = ($head == false AND $tail == true AND $i > 1) ? 'container--medium' : $classes;
        slow_custom_content_video( $paragraph, $classes );
        break;
      default:
        return false;
    } 
  }
}

/**
 * Body content text
 */
function slow_custom_content_text( $paragraph, $classes = '', $length ) {
  
  $type   = $paragraph['custom_content_text_type'];
  $title  = $paragraph['custom_content_text_title'];
  $text   = $paragraph['custom_content_text_text'];
  $author = $paragraph['custom_content_text_author'];

  $text = $length ? (substr( $text, 0, $length ) . (strlen( $text ) > $length ? "..." : "")) : $text;

  if ( strlen( $text ) > 0 ) {
    if ( strtolower( $type ) == 'simple' OR strtolower( $type ) == 'advanced' ) {
      echo '<div class="article-content-paragraph article-content-paragraph--text ' . $classes . '">';
      if ( strlen( $title ) > 0 ) {
        echo '<h3>' . $title . '</h3>';
      }
      echo $text;
      echo '</div>';
    } elseif ( strtolower( $type ) == 'quote' ) {
      echo '<div class="article-content-paragraph article-content-paragraph--text ' . $classes . '">';
      echo '<blockquote>' . $text . '</blockquote>';
      if ( strlen( $author ) > 0 ) {
        echo '<span class="article-content-paragraph-footer article-content-paragraph-footer--author">';
        echo $author;
        echo '</span>';
      }
      echo '</div>';
    }
  }
}

/**
 * Body content text
 */
function slow_custom_content_image( $paragraph, $classes = '' ) {
  
  $size              = $paragraph['custom_content_image_size'];
  $image_meta        = $paragraph['custom_content_image_meta'];
  $image_data        = $paragraph['custom_content_image_image'];
  $image_id          = $image_data['ID'];
  $image_size        = strtolower( $size ) == 'small' ? 'slow-small' : (strtolower( $size ) == 'large' ? 'slow-large' : '');
  $image_url         = wp_get_attachment_image_src( $image_id, $image_size, false )[0];
  $image_zoom_url    = wp_get_attachment_image_src( $image_id, 'slow-large', false )[0];
  $title             = $image_meta['custom_content_image_meta_title'];
  $caption           = $image_meta['custom_content_image_meta_caption'];
  $copyright         = $image_meta['custom_content_image_meta_copyright'];
  $copyright_year    = $copyright['custom_content_image_meta_copyright_year'];
  $copyright_creator = $copyright['custom_content_image_meta_copyright_creator'];

  $classes = $image_size == 'slow-large' ? 'container--full' : $classes;

  $id = slow_generate_random_string();
  echo '<div id="' . $id .'" class="article-content-paragraph article-content-paragraph--image zoomable-image ' . $classes . '"';
  echo ' data-zoomable-image="' . $image_zoom_url .'">';
  echo '<img src="' . $image_url . '">';
  if ($caption) {
    echo '<div class="article-content-paragraph--image-caption">';
    echo $caption;
    echo '</div>';
  }
  if ($title) {
    echo '<div class="article-content-paragraph--image-title">';
    echo $title;
    echo '</div>';
  }
  if ($copyright_year AND $copyright_creator) {
    echo '<div class="article-content-paragraph--image-copyright">';
    echo '© ' . $copyright_year . ' ' . $copyright_creator;
    echo '</div>';
  }
  echo '</div>';
}

/**
 * Body content gallery
 */
function slow_custom_content_gallery( $paragraph, $classes = '' ) {
  
  $layout = $paragraph['custom_content_gallery_layout'];
  $images = $paragraph['custom_content_gallery_images'];

  echo '<div class="article-content-paragraph article-content-paragraph--gallery ' . $classes . '">';

  $gallery_classes = '';
  if ( $layout == 'stream' ) {
    $gallery_classes = 'gallery--stream gallery--inline swiper-container swiper-container--stream swiper-container--inline';
  } elseif ( $layout == 'grid' ) {
    $gallery_classes = 'gallery--grid container--large';
  }

  echo '<div class="gallery ' . $gallery_classes . '">';
  echo '<div class="gallery-images swiper-wrapper">';

  $i = 0;
  foreach ( $images as $image_data ) {
    $image_data = $image_data['custom_content_gallery_images_image'];
    $image = $image_data['custom_content_gallery_images_image_image'];
    $image_src = wp_get_attachment_image_src( $image['ID'], 'slow-small', false );
    $image_url = $image_src[0];
    $image_width = $image_src[1];
    $image_height = $image_src[2];
    $image_zoom_url = wp_get_attachment_image_src( $image['ID'], 'slow-large', false )[0];
    $id = slow_generate_random_string();
    $image_meta = $image_data['custom_content_gallery_images_image_meta'];
    $title = $image_meta['custom_content_gallery_images_image_meta_title'];
    $caption = $image_meta['custom_content_gallery_images_image_meta_caption'];
    $copyright = $image_meta['custom_content_gallery_images_image_meta_copyright'];
    $copyright_year = $copyright['custom_content_gallery_images_image_meta_copyright_year'];
    $copyright_creator = $copyright['custom_content_gallery_images_image_meta_copyright_creator'];

    if ( $layout == 'grid' && $i % 2 == 0 ) {
      echo '<div class="gallery-images-row">';
    }

    $image_item_classes = $image_width > $image_height ? 'gallery-image-item--landscape' : 'gallery-image-item--protrait';
    echo '<div class="gallery-image-item swiper-slide ' . $image_item_classes . '">';
    echo '<div id="' . $id .'" class="gallery-image zoomable-image" style="background-image: url(' . $image_url . ');"';
    echo ' data-zoomable-image="' . $image_zoom_url .'"></div>';
    echo '<div class="gallery-image-item-meta">';
      if ( strlen( $title ) > 0 ) {
        echo '<div class="gallery-image-item-title">';
        echo $title;
        echo '</div>';
      }
      if ( strlen( $copyright_year ) > 0 OR strlen( $copyright_creator ) > 0 ) {
        echo '<div class="gallery-image-item-copyright">';
        echo '© ' . $copyright_year . ' ' . $copyright_creator;
        echo '</div>';
      }
    echo '</div>';
    echo '</div>';

    if ( $layout == 'grid' && $i % 2 == 1 ) {
      echo '</div>'; // images row
    }

    $i++;
  }

  echo '</div>';

  if ( $layout == 'stream' ) {
    echo '<div class="container container--small">';
    echo '<div class="swiper-button-prev"></div>';
    echo '<div class="swiper-button-next"></div>';
    echo '</div>';
  }

  echo '</div>';
  echo '</div>';
}

/**
 * Body content video
 */
function slow_custom_content_video( $paragraph, $classes = 'container--medium' ) {
  
  $embed = $paragraph['custom_content_video_embed'];

  echo '<div class="article-content-paragraph article-content-paragraph--video ' . $classes . '">';
  echo '<div class="video">';
  echo '<div class="video-wrapper">';
  echo $embed;
  echo '</div>';
  echo '</div>';
  echo '</div>';
}

function slow_project_period( $post ) {
  /* Project Period */
  $project_meta_period = get_field( 'project_meta_period', $post );
  $project_meta_client = get_field( 'project_meta_client', $post );
  
  if ( $project_meta_period ) {
    $period_start = $project_meta_period['project_meta_period_start'];
    $period_end = $project_meta_period['project_meta_period_end'];
    if ( $period_start ) {
      $start_month = $period_start['project_meta_period_start_month'];
      if ( strlen( $start_month ) > 0 ) {
        $date = DateTime::createFromFormat('!m', $start_month);
        $start_month = $date->format('M'); // Jan
      }
      $start_year  = $period_start['project_meta_period_start_year'];
      $period = $start_month ? ($start_month . ' ' . $start_year) : $start_year;
      if ( $period_end ) {
        $end_month = $period_end['project_meta_period_end_month'];
        if ( strlen( $end_month ) > 0 ) {
          $date = DateTime::createFromFormat('!m', $end_month);
          $end_month = $date->format('M'); // Jan
        }
        $end_year  = $period_end['project_meta_period_end_year'];
        $period_end = $end_month ? ($end_month . ' ' . $end_year) : $end_year;
        if ( $period_end != $period ) {
          $period = $period . ' - ' . $period_end;
        }
      }
      if ($period) {
        echo '<dt>Zeitraum</dt>';
        echo '<dd>' . $period . '</dd>';
      }
    }
  }
}
