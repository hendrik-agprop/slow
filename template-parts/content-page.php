<article id="post-<?php the_ID(); ?>" class="article article--page container">
  <div class="article-content-wrapper">
    <div class="row" style="margin-top: 10em;">
      <div class="col-lg-5" style="margin-bottom: 2em;">
        <?php the_post_thumbnail( 'slow-large' ); ?>
      </div>
      <div class="col-lg-7 article-content">
        <h1><?php the_title(); ?></h1>
        <?php
        $subtitle = get_field( 'subtitle' );
        if ( strlen( $subtitle ) > 0 ) {
          echo '<h2 class="article-headline-second">' . $subtitle . '</h2>';
        }
        ?>
        <?php slow_custom_content( $post, $head = true, $tail = true ); ?>
      </div>
    </div>
  </div>
</article>
