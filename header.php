<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KTXJWJ5');</script>
	<!-- End Google Tag Manager -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KTXJWJ5"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php 
	$color_classes = '';
	if ( is_singular() ) {
		$color = get_field( 'header_menu_color' );
		$color_classes .= $color ? $color : '';
	}
	?>
	<div class="page <?php echo $color_classes; ?>">
	  <div class="page-header">
	    <div class="container">
	      <div class="page-header-logo">
	      	<a href="<?php echo get_home_url(); ?>">SLOW</a>
	      </div>
	      <div class="page-header-navigation container--full">
	        <?php slow_nav_menu( 'main-navigation', 'navigation--header' ); ?>
	        <?php slow_nav_menu( 'footer-navigation', 'navigation--sub' ); ?>
	      </div>
	    </div>
	  </div>
	  <div class="page-content">
	    <div class="page-content-wrapper">
