<article id="post-<?php the_ID(); ?>" class="article-list-item article-list-item--post row">
	<div class="article-list-item-wrapper col-lg-6 col-md-12">
		<div class="article-list-item-background" 
		     style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, $size = 'slow-small' ); ?>)">
		     <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="article-list-item-content">
			<h2>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
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
<!-- 				<li>
					<?php //echo get_the_author(); ?>
				</li>
				<li>
					<?php //the_category( ', ' ); ?>
				</li> -->
			</ul>
			<?php slow_excerpt( $post = get_post(), $length = 500 ); ?>
		</div>
	</div>
</article>
