<?php
/**
 * Template Name: Posts
 * The template for displaying all posts
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

get_template_part( 'template-parts/list', 'post' );

get_sidebar();
get_footer();
