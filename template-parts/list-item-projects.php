<?php 
$color_classes = '';
if ( is_singular() ) {
	$color = get_field( 'header_menu_color' );
	$color_classes .= $color ? $color : '';
}
?>

<article id="post-<?php the_ID(); ?>" class="article-list-item article-list-item--project <?php echo $color_classes; ?>">
	
	<div class="article-list-item-background" 
	     style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, $size = 'slow-small' ); ?>)">
	</div>
	<div class="article-list-item-background article-list-item-background--hover" 
	     style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, $size = 'slow-small' ); ?>);">
	</div>

	<div class="article-list-item-content">
		<h2><?php the_title(); ?></h2>
		<dl class="list--inline">
			<?php slow_project_period( $post ); ?>
		</dl>
	</div>

	<a href="<?php the_permalink(); ?>" class="article-list-item-link"></a>
</article>
