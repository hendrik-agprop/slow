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
      case 'custom_content_vita_list':
        custom_content_vita_list( $paragraph );
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
  $image_url         = wp_get_attachment_image_src( $image_id, 'slow-small', false )[0];
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
    $gallery_classes = 'gallery--grid container container--medium';
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

    $image_item_classes = $image_width > $image_height ? 'gallery-image-item--landscape' : 'gallery-image-item--portrait';
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

/**
 * Body content vita list
 */
function custom_content_vita_list( $paragraph ) {
  
  $title = $paragraph['custom_content_vita_list_title'];
  $subtitle = $paragraph['custom_content_vita_list_subtitle'];
  $users = $paragraph['custom_content_vita_list_users'];

  if (!$users) {
    return;
  }

  echo '<div class="article-content-paragraph article-content-paragraph--vita-list">';
  echo '<div class="vita-list">';
  echo '<div class="vita-list-wrapper">';

  if ( $title ) {
    echo '<h2>' . $title .'</h2>';
  }
  if ( $subtitle ) {
    echo '<h3>' . $subtitle .'</h3>';
  }

  foreach ( (array)$users as $user ) {
    $user = $user['custom_content_vita_list_user'];
    $user_id = $user['ID'];
    $user_vita = get_field( 'vita_main', 'user_' . $user_id );
    $user_email = $user['user_email'];
    $name = $user_vita['vita_main_name'];
    $portrait = $user_vita['vita_main_portrait']['sizes']['slow-small'];
    $birthday = $user_vita['vita_main_birthday'];
    $position = $user_vita['vita_main_position'];
    $page_url = $user_vita['vita_main_page'];
    $links = $user_vita['vita_main_links'];

    echo '<div class="vita-list-item">';

    echo '<div class="vita-list-item-portrait">';
    if ( $page_url ) { echo '<a href="' . $page_url . '">'; }
    echo '<img src="' . $portrait . '">';
    if ( $page_url ) { echo '</a>'; }
    echo '</div>';

    echo '<div class="vita-list-item-text">';
    echo '<div class="vita-list-item-text-wrapper">';

    echo '<div class="vita-list-item-text-top">';
    echo '<h3 class="vita-list-item-name">';
    if ( $page_url ) { echo '<a href="' . $page_url . '">'; }
    echo $name; 
    if ( $page_url ) { echo '</a>'; }
    echo '</h3>';

    echo '<div class="vita-list-item-position">';
    echo '<span>' . $position . '</span>';
    echo '</div>';
    echo '</div>';

    echo '<div class="vita-list-item-text-bottom">';
    echo '<div class="vita-list-item-links">';
    echo '<ul>';
    
    if ( $page_url ) { 
      echo '<li class="vita-list-item-link vita-list-item-link--more">';
      echo '<a href="' . $page_url . '">Vita</a>';
      echo '</li>';
    } 

    if ( $user_email ) { 
      echo '<li class="vita-list-item-link vita-list-item-link--mail">';
      echo '<a href="mailto:' . $user_email . '">Mail</a>';
      echo '</li>';
    }

    if ( $links ) {
      foreach ($links as $link) {
        $link = $link['vita_main_link'];
        $link_title = $link['vita_main_link_title'];
        $link_url = $link['vita_main_link_url'];
        echo '<li class="vita-list-item-link">';
        echo '<a href="' . $link_url . '" target="_blank">' . $link_title . '</a>';
        echo '</li>';
      }
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  echo '</div>';
  echo '</div>';
  echo '</div>';
}

/**
 * Vita
 */
function vita( $post = null ) {
  
  if ( !$post ) return false;

  $user = get_field( 'vita_page_user', $post->ID );

  if (!$user) {
    return;
  }

  $user_id = $user['ID'];
  $user_vita = get_field( 'vita_main', 'user_' . $user_id );
  $user_email = $user['user_email'];
  $name = $user_vita['vita_main_name'];
  $portrait = $user_vita['vita_main_portrait']['sizes']['slow-small'];
  $birthday = $user_vita['vita_main_birthday'];
  $position = $user_vita['vita_main_position'];
  $introduction = $user_vita['vita_main_introduction'];
  $links = $user_vita['vita_main_links'];

  $careers = get_field( 'vita_careers', 'user_' . $user_id );

  echo '<div class="article-content-paragraph article-content-paragraph--vita">';
  echo '<div class="vita-wrapper">';

  echo '<div class="vita-position">';
  echo '<h2>' . $position . '</h2>';
  echo '</div>';

  echo '<div class="vita-links">';
  echo '<ul>';
  echo '<li class="vita-link vita-link--mail">';
  echo '<a href="mailto:' . $user_email . '">Mail</a>';
  echo '</li>';

  if ( $links ) {
    foreach ($links as $link) {
      $link = $link['vita_main_link'];
      $link_title = $link['vita_main_link_title'];
      $link_url = $link['vita_main_link_url'];
      echo '<li class="vita-link">';
      echo '<a href="' . $link_url . '" target="_blank">' . $link_title . '</a>';
      echo '</li>';
    }
  }
  echo '</ul>';
  echo '</div>'; // links

  echo '<div class="vita-introduction">';
  echo '<p>' . $introduction . '</p>';
  echo '</div>';

  if ( $careers ) {
    echo '<div class="vita-careers">';
    
    foreach ( $careers as $career ) {
      $career = $career['vita_career'];
      $title = $career['vita_career_title'];
      $steps = $career['vita_career_steps'];

      echo '<div class="vita-career">';
      echo '<strong class="vita-career-title">' .$title . '</strong>';

      foreach ($steps as $step ) {
        $step = $step['vita_career_step'];
        $step_title = $step['vita_career_step_title'];
        $step_url = $step['vita_career_step_url'];
        $step_period = $step['vita_career_step_period'];
        $step_period_from = $step_period['vita_career_step_period_from'];
        $step_period_to = $step_period['vita_career_step_period_to'];
        $step_description = $step['vita_career_step_description'];

        echo '<div class="vita-career-step">';

        echo '<div class="vita-career-step-period">';
        if ( !$step_period_to ) { echo '<span>seit</span> '; }
        echo '<span>' . $step_period_from . '</span>';
        if ( $step_period_to ) { 
          echo '<span> - </span>'; 
          echo '<span>' . $step_period_to . '</span>';
        }
        echo '</div>';

        echo '<div class="vita-career-step-title">'; 
        if ( $step_url ) { echo '<a href="'. $step_url . '">'; }
        echo $step_title;
        if ( $step_url ) { echo '</a>'; }
        echo '</div>';

        echo '<div class="vita-career-step-description">';
        echo '<p>' . $step_description . '</p>';
        echo '</div>';

        echo '</div>';
      }

      echo '</div>'; // vita-career
    }
    
    echo '</div>'; // careers
  }
  
  echo '</div>'; // vita-wrapper
  echo '</div>'; // article-content-paragraph
}

/**
 * Vita
 */
function vita_projects( $post = null ) {
  
  if ( !$post ) return false;

  $user = get_field( 'vita_page_user', $post->ID );

  if (!$user) {
    return;
  }

  $user_id = $user['ID'];
  $user_vita = get_field( 'vita_main', 'user_' . $user_id );
  $projects = $user_vita['vita_main_projects'];
  $name = $user_vita['vita_main_name'];

  $project_ids = array();
  foreach ( (array)$projects as $project) {
    $project = $project['vita_main_project'];
    array_push( $project_ids, $project->ID );
  }

  $projects = new WP_Query( array(
    "post_type" => "project",
    'post__in'  => $project_ids
  ) );

  if ( $projects->have_posts() ) : 
    echo '<div class="vita-projects container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<strong class="vita-projects-title">Projekte von ' . $name . '</strong>';
    echo '<a href="http://www.slow.cc" class="back">alle Projekte</a>';
    echo '</div>';
    echo '</div>';

    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<div class="article-list swiper-container--inline swiper-container--stream">';
    echo '<div class="swiper-wrapper">';
    /* Start the Loop */
    while ( $projects->have_posts() ) :
      $projects->the_post();
      echo '<div class="article-list-item-wrapper swiper-slide">';
      get_template_part( 'template-parts/list-item', 'projects' );
      echo '</div>';
    endwhile;

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  endif;
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
