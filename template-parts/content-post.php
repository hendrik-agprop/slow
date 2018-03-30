<article id="post-<?php the_ID(); ?>" class="article article--post container">
	
	<div class="article-content-wrapper">
		
		<div class="article-content article-content--head">

			<?php get_template_part( 'template-parts/general/header-content', 'post' ); ?>

			<div class="container container--small">
				<?php get_template_part( 'template-parts/share/share' ); ?>
				<?php slow_custom_content( $post, $head = true, $tail = false ); ?>
			</div>
		</div>
		<div class="article-content article-content--tail">
			<?php slow_custom_content( $post, $head = false, $tail = true ); ?>
		</div>
	</div>
</article>
