<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
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
