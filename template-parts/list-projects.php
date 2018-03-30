<?php

$projects = new WP_Query( array(
  "post_type" => "project",
  "order"     => "ASC"
) );
?>

<div class="article-list">
<div class="row">
<?php

if ( $projects->have_posts() ) : 
  /* Start the Loop */
  $i=0;
  while ( $projects->have_posts() ) :
    $projects->the_post();
    echo '<div class="article-list-item-wrapper ' . ( $i > 0 ? 'col-md-6' : 'article-list-item-wrapper--wide col-md-12' ) . '">';
    get_template_part( 'template-parts/list-item', 'projects' );
    echo '</div>';
    $i++;
  endwhile;
endif;
?>

<div class="container--small newsletter-box <?php echo $projects->post_count % 2 == 0 ? ' col-md-6 newsletter-box--small' : ' col-md-6 newsletter-box--small'; ?>">
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
</div>
