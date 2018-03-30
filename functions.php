<?php
/**
 * slow functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package slow
 */

if ( ! function_exists( 'slow_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function slow_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on slow, use a find and replace
		 * to change 'slow' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'slow', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'slow-tiny', 80, null, false );
		add_image_size( 'slow-small', 1200, null, false );
		add_image_size( 'slow-large', 3200, 1600, false );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main-navigation' => esc_html__( 'Main Navigation', 'slow' ),
			'footer-navigation' => esc_html__( 'Footer Navigation', 'slow' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'slow_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function slow_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'slow_content_width', 1920 );
}
add_action( 'after_setup_theme', 'slow_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function slow_scripts() {
	// Boostrap
	wp_enqueue_style( 'boostrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
	// Montserrat Font
	wp_enqueue_style( 'montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700' );

	// Main css style
	wp_enqueue_style( 'slow-style', get_stylesheet_uri() );

	// jQuery
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), '3.3.1', true );

	// Swiper
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/vendor/swiper/swiper.min.css' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/vendor/swiper/swiper.min.js', array(), '4.1.6', true );

	// Theme scripts
	wp_enqueue_script( 'slow-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0.0', true );
	wp_enqueue_script( 'slow-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );
	wp_enqueue_script( 'slow-zoomable-image', get_template_directory_uri() . '/js/zoomable.js', array(), '1.0.0', true );
	wp_enqueue_script( 'slow-header-content-gallery', get_template_directory_uri() . '/js/header-content-gallery.js', array(), '1.0.0', true );

	wp_enqueue_script( 'slow-articles', get_template_directory_uri() . '/js/articles.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'slow_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*
 * Helpers
 */
function slow_generate_random_string( $length = 10 ) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen( $characters );
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
    }
    return $randomString;
}