<?php 
defined( 'ABSPATH' ) || exit;
/**
*	@access CONFIG THEME
*/

$theme = wp_get_theme();

if ( ! empty( $theme['Template'] ) ) { $theme = wp_get_theme( $theme['Template'] ) ; }

define( 'THEME_NAME', $theme['Name'] );
define( 'THEME_UPLOADS', get_template_directory_uri() . '/uploads/' );
define( 'THEME_DIR',get_template_directory() );
define( 'THEME_URI',get_template_directory_uri() );
define( 'TEXTDOMAIN',$theme['TextDomain'] );
define( 'SHORTCODE_CATEGORY',sprintf(__('by %s',TEXTDOMAIN),THEME_NAME) );

// ADD HELPER INSIGHT
// require_once THEME_DIR . '/classes/class-insight-core-breadcrumbs.php';
require_once THEME_DIR . '/libs/class-setup-theme.php';
require_once THEME_DIR . '/libs/secure.php';
// require_once THEME_DIR . '/libs/post-type.php';
require_once THEME_DIR . '/libs/master_route.php';
require_once THEME_DIR . '/libs/ajax_center.php';

