<?php
defined( 'ABSPATH' ) || exit;

/** Tell WordPress to run developerThemeConstruct() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'developerThemeConstruct' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentytwelve_setup() in a child theme, add your own twentytwelve_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @access THEME DEVELOPER CONTRUCTOR SETUP
 * @version 1.1
 * @author CJ88
 */
 
function developerThemeConstruct() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'standard', 'gallery' ,'audio' , 'video' ,'quote') );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Support Html5
	// add_theme_support('html5');

   add_image_size( 'extra-medium', 768, 768, true );
   add_image_size( 'medium', 200, 200, true );
   

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', TEXTDOMAIN ),
		'secondary' => __( 'Secondary Navigation', TEXTDOMAIN),
		'thirdly'	=> __( 'Third Navigation', TEXTDOMAIN ),
	) );

	// Register sidebar
	register_sidebar(array(
		'name'	=> __('Primary Sidebar',TEXTDOMAIN),
		'id'		=> 'sidebar-primary',
		'description'	=> __('Widgets in this area will be shown on all posts and pages.',TEXTDOMAIN),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="sidebar-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'	=> __('Secondary Sidebar',TEXTDOMAIN),
		'id'		=> 'secondary-primary',
		'description'	=> __('Widgets in this area will be shown on all posts and pages.',TEXTDOMAIN),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="sidebar-title">',
		'after_title'   => '</h2>',
	));

	// REWRITE PERMALINK TO %POSTNAME%
	if( get_option('permalink_structure') != "/%postname%/"){
		update_option('permalink_structure', '/%postname%/');
	}


   // CLEAN HEAD - CODE FROM BONE
   // category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
   add_filter( 'style_loader_src', function ( $src ) {
	   if ( strpos( $src, 'ver=' ) )
		   $src = remove_query_arg( 'ver', $src );
	   return $src; }
   , 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', function ( $src ) {
	   if ( strpos( $src, 'ver=' ) )
		   $src = remove_query_arg( 'ver', $src );
	   return $src; }
   , 9999 );

   // A better title
   add_filter( 'wp_title', 'rw_title', 10, 3 );
   // remove WP version from RSS
   add_filter( 'the_generator', function(){ return ''; } );


}


// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title


/**
 * @access Disable the emoji's
 */
function disable_emoji_feature() {
	
	// Prevent Emoji from loading on the front-end
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	// Remove from admin area also
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	// Remove from RSS feeds also
	remove_filter( 'the_content_feed', 'wp_staticize_emoji');
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
	// Remove from Embeds
	remove_filter( 'embed_head', 'print_emoji_detection_script' );
	// Remove from emails
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	// Disable from TinyMCE editor. Currently disabled in block editor by default
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	/** Finally, prevent character conversion too
         ** without this, emojis still work 
         ** if it is available on the user's device
	 */
	add_filter( 'option_use_smilies', '__return_false' );
}

function disable_emojis_tinymce( $plugins ) {
	if( is_array($plugins) ) {
		$plugins = array_diff( $plugins, array( 'wpemoji' ) );
	}
	return $plugins;
}
add_action('init', 'disable_emoji_feature');