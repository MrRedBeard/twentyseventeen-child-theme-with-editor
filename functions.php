<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

//Server Path
define('svr_path', dirname( __FILE__ ).'/');
define('url_path', get_stylesheet_directory_uri().'/');

include( get_stylesheet_directory() . '/inc/options.php');

// Child Theme Common
function my_theme_enqueue_styles() 
{
    $parent_style = 'twentyseventeen-style'; 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Flex Width Header
function childtheme_custom_header_args( $args ) 
{
    $args['flex-width'] = true;
    return $args;
}
add_filter( 'twentyseventeen_custom_header_args', 'childtheme_custom_header_args' );

// Add Javascript file - Enqueue child them js file
function child_theme_js() 
{
	//wp_register_script
	wp_enqueue_script( 'x2common', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'));
	wp_enqueue_script( 'spectrum', get_stylesheet_directory_uri() . '/scripts/spectrum.js', array('jquery'));
	
	wp_enqueue_script( 'x2common' );
	wp_enqueue_script( 'spectrum' );
}
add_action( 'wp_enqueue_scripts', 'child_theme_js' );
add_action( 'admin_enqueue_scripts', 'child_theme_js' );

// Add style sheets
function child_theme_css()
{
	wp_register_style( 'spectrumstyle', get_stylesheet_directory_uri() . '/style/spectrum.css', array(), null, 'all' );
	wp_enqueue_style( 'spectrumstyle' );
	
	wp_register_style( 'x2dynamicstyle', get_stylesheet_directory_uri() . '/dynamic.css.php', array(), null, 'all' );
	wp_enqueue_style( 'x2dynamicstyle' );
}
add_action( 'wp_enqueue_scripts', 'child_theme_css' );

function child_admin_theme_css()
{
	wp_register_style( 'spectrumstyle', get_stylesheet_directory_uri() . '/style/spectrum.css', array(), null, 'all' );
	wp_enqueue_style( 'spectrumstyle' );
	
	wp_register_style( 'x2Adminstyle', get_stylesheet_directory_uri() . '/style/adminScreen.css', array(), null, 'all' );
	wp_enqueue_style( 'x2Adminstyle' );
}
add_action( 'admin_enqueue_scripts', 'child_admin_theme_css' );

function change_howdy($translated, $text, $domain) {

    if (!is_admin() || 'default' != $domain)
        return $translated;

    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);

    return $translated;
}
add_filter('gettext', 'change_howdy', 10, 3);

// Change the number of Twenty Seventeen Theme Front Page Sections
function wpc_custom_front_sections( $num_sections )
{
	return X2_get_theme_option( 'num_front_panels' ); //Change this number to change the number of the sections.
}
add_filter( 'twentyseventeen_front_page_sections', 'wpc_custom_front_sections' );

// Custom Tile Widgets
function x2_fptw_widgets_init() 
{
	register_sidebar( array(
		'name'          => 'Front Page Tile Widgets',
		'id'            => 'x2-fptw',
		'description'	=> 'Only use the Text & Image Widgets. To add text with image use image caption and title',
		'before_widget' => '<div class="fptw-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="fptw-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'x2_fptw_widgets_init');

// Custom Tile Widgets
function x2_footer_widgets_init() 
{
	register_sidebar( array(
		'name'          => 'Full Width Page Footer Widgets',
		'id'            => 'x2-ftrw',
		'description'	=> 'Only use the Text Widgets',
		'before_widget' => '<div class="ftrw-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'x2_footer_widgets_init');

?>