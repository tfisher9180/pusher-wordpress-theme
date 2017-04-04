<?php
/**
 * Pusher functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pusher
 */

if ( ! function_exists( 'pusher_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pusher_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Pusher, use a find and replace
	 * to change 'pusher' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'pusher', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'pusher' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'pusher_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'pusher_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pusher_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pusher_content_width', 640 );
}
add_action( 'after_setup_theme', 'pusher_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pusher_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pusher' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'pusher' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pusher_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pusher_scripts() {

	if ( !is_admin() ) {

		// Materialize CSS requires newer version of jQuery than what is bundled with WordPress
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'materialize-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '1.0', false );
		wp_enqueue_style( 'materialize-style', get_template_directory_uri() . '/css/materialize.min.css' );
		wp_enqueue_script( 'materialize-script', get_template_directory_uri() . '/js/materialize.min.js', array(), '1.0', false );
		wp_enqueue_script( 'custom-materialize', get_template_directory_uri() . '/js/custom-materialize.js', array(), '1.0', false );

	}

	wp_enqueue_style( 'pusher-style', get_stylesheet_uri() );


	wp_enqueue_script( 'pusher-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$themecolors = get_theme_mod( 'pusher_colors', 'blue.css' );

	wp_enqueue_style( 'pusher_colors', get_template_directory_uri() . '/css/' . $themecolors);

}
add_action( 'wp_enqueue_scripts', 'pusher_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// Add theme customization options

function pusher_controls( $wp_customize ) {

	// Add a section to customizer.php
	$wp_customize->add_section( 'pusher_options', array(
		'title'			=> __( 'Pusher Options', 'pusher' ),
		'description'	=> 'The following theme options are available:',
		'priority'		=> 30,
		'capability'	=> 'edit_theme_options'
	) );

	// Add setting (the values of the control)
	// accessed through get_theme_mod()
	$wp_customize->add_setting(
		'pusher_colors',
		array(
			'default' 				=> 'blue.css',
			'sanitize_callback'		=> 'pusher_sanitize_select'
		)
	);

	// Add control
	$wp_customize->add_control(
		'pusher_color_selector',
		array(
			'label'			=> 'Color Scheme',
			'section'		=> 'pusher_options',
			'settings'		=> 'pusher_colors',
			'type'			=> 'select',
			'choices'		=> array(
				'blue.css'		=> 'Blue',
				'red.css'		=> 'Red',
				'green.css'		=> 'Green',
				'orange.css'	=> 'Orange'
			)
		)
	);

}
add_action( 'customize_register', 'pusher_controls' );

function pusher_sanitize_select( $input, $setting ) {
	return $input;
}
