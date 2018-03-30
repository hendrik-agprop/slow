<?php
get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content', get_post_type() );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile;

get_sidebar();
get_footer();
