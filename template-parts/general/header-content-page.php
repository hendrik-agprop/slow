<div class="article-header">
  <div class="container container--medium">
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
</div>
