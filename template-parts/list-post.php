<?php

$posts = new WP_Query( array(
  "post_type" => "post",
  "order"     => "DESC"
) );
?>

<div class="article-list article-list--post">
  <?php
  if ( $posts->have_posts() ) :
    /* Start the Loop */
    $i=0;
    while ( $posts->have_posts() ) :
      $posts->the_post();
      get_template_part( 'template-parts/list-item', 'post' );

      if ( $i == 4 ) :
        ?>
        <div class="container--medium">
          <div class="newsletter-box newsletter-box--large">
            <h2>Newsletter</h2>
            <p>
              Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt 
            </p>
            <form>
              <input type="text" placeholder="E-Mail-Adresse">
              <input type="submit" class="button" value="Anmelden">
            </form>
          </div>
        </div>
        <?php
      endif;

      $i++;
    endwhile;
  endif;
  ?>
</div>