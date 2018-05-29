<?php
/* Template Name: Vita */

get_header();

while ( have_posts() ) :
  the_post();

  get_template_part( 'template-parts/content-vita' );

endwhile;

get_sidebar();
get_footer();
