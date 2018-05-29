<div class="article-header">
  <?php
  $id = slow_generate_random_string();
  $image_zoom_url = get_the_post_thumbnail_url( $post, 'slow-large' );
  ?>
  <div class="container container--medium">
    <div id="<?php echo $id; ?>" 
         class="article-featured-image zoomable-image <?php echo $id; ?>" 
         data-zoomable-image="<?php echo $image_zoom_url; ?>">
      <img src="<?php echo get_the_post_thumbnail_url( $post, 'slow-small' ); ?>">
    </div>
  </div>
  <div class="container container--small">
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
    <div class="row">
      <div class="col-md-12">
        <a href="http://www.slow.cc/aktuelles" class="back"> zu allen News</a>
        <?php get_template_part( 'template-parts/share/share' ); ?>
      </div>
    </div>
  </div>
</div>
