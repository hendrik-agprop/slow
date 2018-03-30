<?php
/**
 * Template Name: Projects
 * The template for displaying all projects
 *
 * @package slow
 */

get_header();

if ( have_posts() ) :
	/* Start the Loop */
	while ( have_posts() ) :
		the_post();
	endwhile;
endif;

get_template_part( 'template-parts/list', 'projects' );

get_sidebar();
get_footer();
