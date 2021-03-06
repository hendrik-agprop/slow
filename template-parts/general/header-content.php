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
  </div>
</div>
