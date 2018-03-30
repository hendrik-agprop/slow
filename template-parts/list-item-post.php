<article id="post-<?php the_ID(); ?>" class="article-list-item article-list-item--post row">
	<div class="article-list-item-wrapper col-md-6">
		<div class="article-list-item-background" 
		     style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, $size = 'slow-small' ); ?>)">
		</div>
	</div>
	<div class="col-md-4">
		<div class="article-list-item-content">
			<h2>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<?php 
			$subtitle = get_field( 'subtitle' );
			if ( strlen( $subtitle ) > 0 ) {
			  echo '<h3>' . $subtitle . '</h3>';
			}
			?>
			<ul class="list list--unstyled">
				<li>
					<?php $post = get_post(); ?>
					<?php echo get_the_date('', $post); ?>
				</li>
				<li>
					<?php echo get_the_author(); ?>
				</li>
				<li>
					<?php the_category( ', ' ); ?>
				</li>
			</ul>
			<?php slow_excerpt( $post = get_post(), $length = 500 ); ?>
		</div>
	</div>
</article>
