<div class="article-header article-header--fullscreen">
  <?php
  $header_type = get_field( 'header_type' );

  if ( $header_type === 'gallery' ) {
    get_template_part( 'template-parts/general/header-content-gallery' );
  } elseif ( $header_type === 'video' ) {
    get_template_part( 'template-parts/general/header-content-video' );
  }
  ?>

  <div class="article-headline article-headline--large">
    <h1 class="article-headline-first">
      <?php the_title(); ?>
    </h1>
    <?php 
    $subtitle = get_field( 'subtitle' );
    if ( strlen( $subtitle ) > 0 ) {
      echo '<h2 class="article-headline-second">' . $subtitle . '</h2>';
    }
    ?>

    <?php 

    echo '<dl class="list--inline">';

    slow_project_period( $post );

    /* Project Client */
    if ( $project_meta_client ) {
      $client_name = $project_meta_client['project_meta_client_name'];
      $client_url = $project_meta_client['project_meta_client_url'];

      if ( strlen( $client_name ) > 0 ) {
        echo '<dt>Auftraggeber</dt>';

        if ( strlen( $client_url ) > 0 ) {
          echo '<dd><a href="' . $client_url . '">' . $client_name . '</a></dd>';
        } else {
          echo '<dd>' . $client_name . '</dd>';
        }
      }
    }

    echo '</dl>';
    ?>
  </div>
</div>
