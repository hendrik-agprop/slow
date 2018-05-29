<article id="post-<?php the_ID(); ?>" class="article article--page article--vita container">
  <div class="article-content-wrapper">
    <div class="row" style="margin-top: 10em;">
      <div class="col-lg-5" style="margin-bottom: 2em;">
        <?php the_post_thumbnail( 'slow-large' ); ?>
      </div>
      <div class="col-lg-7 article-content">
        <h1><?php the_title(); ?></h1>
        <?php vita( $post); ?>
      </div>
    </div>
  </div>
</article>

<?php vita_projects( $post ); ?>