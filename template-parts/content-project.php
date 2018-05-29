<article id="project-<?php the_ID(); ?>" class="article article--project container">
	
	<?php get_template_part( 'template-parts/general/header-content', get_post_type() ); ?>

	<div class="article-content-wrapper">
		<div class="row">
		  <div class="col-lg-3">
		  	<div class="article-aside article-aside--left">
		    	<?php get_template_part( 'template-parts/project/project-meta' ); ?>
		    </div>
		  </div>
		  <div class="col-lg-6">
		    <div class="article-content article-content--head">
		      <?php slow_custom_content( $post, $head = true, $tail = false ); ?>
		    </div>
		  </div>
		  <div class="col-lg-3">
		    <div class="article-aside article-aside--right">
		    	<?php get_template_part( 'template-parts/share/share' ); ?>
		    	<a href="http://www.slow.cc" class="back"> alle Projekte</a>
		    </div>
		  </div>
		</div>
		<div class="article-content article-content--tail">
			<?php slow_custom_content( $post, $head = false, $tail = true ); ?>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
			  <a href="http://www.slow.cc" class="back">alle Projekte</a>
			</div>
		</div>
	</div>
</article>
