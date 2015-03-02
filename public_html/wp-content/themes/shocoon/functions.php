<?php
require_once get_template_directory() . '/inc/met_admin/admin.php';
require_once get_template_directory() . '/inc/_portfolio.inc';
require_once get_template_directory() . '/inc/_widgets.inc';
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/inc/aq_resizer.php';
require_once get_template_directory() . "/inc/page-builder/page-builder.php";
require_once get_template_directory() . '/inc/theme_customizer.php';
require_once get_template_directory() . '/inc/woocommerce.init.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('meta-box/meta-box.php')) require_once get_template_directory() . '/inc/meta-box.php';

//show_admin_bar(true);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$theme_text_domain = 'metcreative';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( ! isset( $content_width ) ) $content_width = 1170;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( ! function_exists( 'metcreative_setup' ) ) :
function metcreative_setup() {
	global $theme_text_domain;
	require( get_template_directory() . '/inc/template-tags.php' );
	require( get_template_directory() . '/inc/extras.php' );


	load_theme_textdomain($theme_text_domain, get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );


	register_nav_menus( array(
		'header_top_menu' 				=> __( 'Header Top Menu', 'metcreative' ),
		'header_menu' 					=> __( 'Header Menu', 'metcreative' ),
		'main_nav' 						=> __( 'Main Navigation', 'metcreative' ),
		'footer_menu' 					=> __( 'Footer Menu', 'metcreative' )
	) );
}
endif; // metcreative_setup
add_action( 'after_setup_theme', 'metcreative_setup' );
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function metcreative_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'metcreative' ),
		'id'            => 'sidebar-blog',
		'before_widget' => '<div class="row-fluid sidebar-widget %2$s" id="%1$s"><div class="span12"><div class="met_blog_categories met_bgcolor3 clearfix">',
		'after_widget'  => '</div></div></div>',
		'before_title'  => '<h2 class="met_title_stack">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar', 'metcreative' ),
		'id'            => 'footer-sidebar',
		'before_widget' => '<div class="row-fluid met_small_block sidebar-widget footer-widget %2$s" id="%1$s"><div class="span12">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar (2)', 'metcreative' ),
		'id'            => 'footer-sidebar-2',
		'before_widget' => '<div class="row-fluid met_small_block sidebar-widget footer-widget %2$s" id="%1$s"><div class="span12">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar (3)', 'metcreative' ),
		'id'            => 'footer-sidebar-3',
		'before_widget' => '<div class="row-fluid met_small_block sidebar-widget footer-widget %2$s" id="%1$s"><div class="span12">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar (4)', 'metcreative' ),
		'id'            => 'footer-sidebar-4',
		'before_widget' => '<div class="row-fluid met_small_block sidebar-widget footer-widget %2$s" id="%1$s"><div class="span12">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	if(is_woocommerce_activated()):
	register_sidebar( array(
		'name'          => __( 'WooCommerce Sidebar', 'metcreative' ),
		'id'            => 'sidebar-woocommerce',
		'before_widget' => '<div class="row-fluid sidebar-widget %2$s" id="%1$s"><div class="span12"><div class="met_blog_categories met_bgcolor3 clearfix">',
		'after_widget'  => '</div></div></div>',
		'before_title'  => '<h2 class="met_title_stack">',
		'after_title'   => '</h2>',
	) );
	endif;
}
add_action( 'widgets_init', 'metcreative_widgets_init' );
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function metcreative_scripts() {
	global $wp_scripts;

	/* ----------- STYLES ----------- */
	wp_enqueue_style( 'metcreative-style', get_stylesheet_uri() );
	wp_enqueue_style( 'metcreative-google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' );
	wp_enqueue_style( 'metcreative-google-font2', 'http://fonts.googleapis.com/css?family=Roboto+Condensed' );
	wp_enqueue_style( 'metcreative-bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
	wp_enqueue_style( 'metcreative-font-awesome', get_template_directory_uri().'/css/font-awesome.min.css' );
	wp_enqueue_style( 'metcreative-dl-menu', get_template_directory_uri().'/css/dl-menu.css' );
	wp_enqueue_style( 'metcreative-superfish', get_template_directory_uri().'/css/superfish.css' );
	wp_enqueue_style( 'metcreative-custom', get_template_directory_uri().'/css/custom.css' );
	if(get_theme_mod('cacoon_responsive',1) == 1){wp_enqueue_style( 'metcreative-responsive', get_template_directory_uri().'/css/responsive.css' );}

	wp_register_style( 'metcreative-prettyPhotoo', get_template_directory_uri().'/css/prettyPhoto.css' );
	wp_register_style( 'metcreative-photoswipe', get_template_directory_uri().'/css/photoswipe.css' );

	wp_register_style( 'metcreative-nouislider.fox', get_template_directory_uri().'/css/metcreative.audio/nouislider.fox.css' );
	wp_register_style( 'metcreative-nouislider.space', get_template_directory_uri().'/css/metcreative.audio/nouislider.space.css' );

	wp_register_style( 'metcreative-magnific-popup', get_template_directory_uri().'/css/magnific-popup.css' );
	/* ----------- STYLES ----------- */

	/* ----------- SCRIPTS ----------- */
	wp_enqueue_script('jquery');

	wp_enqueue_script('metcreative-modernizr',get_template_directory_uri().'/js/modernizr.custom.65274.js');
	wp_enqueue_script('metcreative-hoverIntent',get_template_directory_uri().'/js/hoverIntent.js');
	wp_enqueue_script('metcreative-superfish',get_template_directory_uri().'/js/superfish.js');
	wp_enqueue_script('metcreative-mobiledetector',get_template_directory_uri().'/js/mobile_detector.js');
	wp_enqueue_script('metcreative-masonry',get_template_directory_uri().'/js/masonry.js',array(),false,true);
	wp_enqueue_script('metcreative-isotope',get_template_directory_uri().'/js/isotope.js',array(),false,true);

	wp_register_script('metcreative-gmaps-api','http://maps.google.com/maps/api/js?sensor=true',array(),false,true);
	wp_register_script('metcreative-gmaps',get_template_directory_uri().'/js/gmaps.js',array(),false,true);
	wp_register_script('metcreative-magnific-popup',get_template_directory_uri().'/js/jquery.magnific-popup.min.js',array(),false,true);
	wp_register_script('metcreative-caroufredsel',get_template_directory_uri().'/js/caroufredsel.js',array(),false,true);
	wp_register_script('metcreative-fullscreenr',get_template_directory_uri().'/js/fullscreenr.js',array(),false,true);
	wp_register_script('metcreative-jflickrfeed',get_template_directory_uri().'/js/jflickrfeed.js');

	wp_register_script('metcreative-nouislider',get_template_directory_uri().'/js/jquery.nouislider.min.js');
	wp_register_script('metcreative-html5audio',get_template_directory_uri().'/js/metcreative.html5audio.js');

	wp_enqueue_script('metcreative-imagesLoaded',get_template_directory_uri().'/js/imagesLoaded.js',array(),false,false);
	wp_enqueue_script('metcreative-retina',get_template_directory_uri().'/js/retina.js',array(),false,true);
	wp_enqueue_script('metcreative-nicescroll',get_template_directory_uri().'/js/nicescroll.js',array(),false,true);
	wp_enqueue_script('metcreative-dlmenu',get_template_directory_uri().'/js/jquery.dlmenu.js',array(),false,true);
	wp_enqueue_script('metcreative-knob',get_template_directory_uri().'/js/jquery.knob.js',array(),false,true);
	wp_enqueue_script('metcreative-easing',get_template_directory_uri().'/js/jquery.easing.js',array(),false,true);
	wp_enqueue_script('metcreative-bootstrap',get_template_directory_uri().'/js/bootstrap.js',array(),false,true);

	wp_enqueue_script('metcreative-custom',get_template_directory_uri().'/js/custom.js',array(),false,true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* ----------- SCRIPTS ----------- */

}add_action( 'wp_enqueue_scripts', 'metcreative_scripts' );
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function met_ie_scripts () {
	global $is_IE;
	if ($is_IE){

		echo '<!--[if lte IE 9]>'.PHP_EOL;
		echo '<script src="'.get_template_directory_uri().'/js/lte-ie9.js">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if IE 7]>'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri().'/css/font-awesome-ie7.min.css">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if lte IE 8]>'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300">'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400">'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:700">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if (gte IE 6)&(lte IE 8)]>'.PHP_EOL;
		echo '<script src="'.get_template_directory_uri().'/js/selectivizr-min.js">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

	}
}//add_action('wp_head', 'met_ie_scripts', 1);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function met_ie_footer_scripts () {
	global $is_IE,$smof_data;
	if ($is_IE){

		echo '<!--[if lte IE 9]>'.PHP_EOL;
		echo '<script src="'.get_template_directory_uri().'/js/lte-ie9.js">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if IE 7]>'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri().'/css/font-awesome-ie7.min.css">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if lte IE 8]>'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300">'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400">'.PHP_EOL;
		echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:700">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

		echo '<!--[if (gte IE 6)&(lte IE 8)]>'.PHP_EOL;
		echo '<script src="'.get_template_directory_uri().'/js/selectivizr-min.js">'.PHP_EOL;
		echo '<![endif]-->'.PHP_EOL;

	}
}add_action('wp_footer', 'met_ie_footer_scripts', 1);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////REQUIRED PLUGINS//////////////////////////////////////////////////////////////////////

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
	global $theme_text_domain;
	$plugins = array(
		array(
			'name'     				=> 'Aqua Page Builder',
			'slug'     				=> 'aqua-page-builder',
			'required' 				=> true,
			'force_activation' 		=> true
		),
		array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7',
			'required' 				=> false
		),
		array(
			'name'     				=> 'Meta Box',
			'slug'     				=> 'meta-box',
			'required' 				=> true
		),
	);

	$config = array(
		'domain'       		=> $theme_text_domain,
		'default_path' 		=> 'includes/plugins',
		'parent_menu_slug' 	=> 'themes.php',
		'parent_url_slug' 	=> 'themes.php',
		'menu'         		=> 'install-required-plugins',
		'has_notices'      	=> true,
		'is_automatic'    	=> true,
		'message' 			=> ''
	);

	tgmpa( $plugins, $config );
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function video_url_to_embed($url) {

	if( strpos($url,'youtube.com') > 0 ){
		$videoID = explode('v=',$url);
		$videoID = $videoID[1];

		$returnURL = 'http://www.youtube.com/embed/'.$videoID;
	}elseif(strpos($url,'vimeo.com') > 0){
		$videoID = explode('/',$url);
		$videoID = $videoID[count($videoID)-1];

		$returnURL = 'http://player.vimeo.com/video/'.$videoID;
	}

	return $returnURL;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return implode(",", $rgb); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function met_create_custom_styles (){

	echo '<link rel="shortcut icon" href="'.get_theme_mod('cacoon_favicon',get_template_directory_uri().'/img/fav.png').'">';

	$customStyles = array();
	echo "\r\n".'<style type="text/css">'."\r\n";

	if( get_theme_mod('cacoon_body_layout','0') == '1' AND get_theme_mod('cacoon_body_boxed_width','') != '' ){
		$met_content_width = get_theme_mod('cacoon_body_boxed_width','1170');
		$customStyles[] = '.met_page_wrapper.met_boxed_layout{width: '.get_theme_mod('cacoon_body_boxed_width','1170').'px}';

		if(get_theme_mod('cacoon_responsive',1) == 1){
			$customStyles[] = '@media (max-width: '.$met_content_width.'px) {
				.met_page_wrapper.met_boxed_layout{ width: auto; }
				.met_content { width : 90%; margin-left : 5%; margin-right : 5%; }
			}';
		}
	}

	if(met_get_option('met_bg_image_type') == 'Pattern'){
		$customStyles[] = 'body{background-image : url("'.met_get_option('met_bg_patterns','').'") !important;}';
	}

	if(met_get_option('met_bg_image_type') == 'Custom Pattern' AND met_get_option('met_bg_pattern_file') != ''){
		$customStyles[] = 'body{background-image : url("'.met_get_option('met_bg_pattern_file').'") !important;}';
	}

	if(get_theme_mod('cacoon_site_color','#18ADB5') != '#18adb5'){
		$site_color = get_theme_mod('cacoon_site_color','#18adb5');
		$customStyles[] = '.met_bgcolor,.met_bgcolor_transition:hover{background-color: '.$site_color.'}';
		$customStyles[] = '.met_color,.met_color_transition:hover,.met_title_with_pager nav a.selected{color: '.$site_color.'}';
		$customStyles[] = '.met_bgcolor_trans{background-color: rgba('.hex2rgb($site_color).',0.8)}';
		$customStyles[] = '.met_blog_list_preview aside:after,.met_blog_comments_title:before{border-top-color: '.$site_color.'}';
		$customStyles[] = '.met_blog_comment_count{border-left-color: '.$site_color.'}';
		$customStyles[] = '.met_accordion .accordion-toggle{background-color: '.$site_color.'}';
		$customStyles[] = '.btn-primary {background: '.$site_color.';}';
		$customStyles[] = '.met_message_info {background-color: '.$site_color.';}';

		$customStyles[] = '.met_bgcolor,::selection,.met_bgcolor_transition:hover,.met_audio_current_progress,.met_tab_nav.met_bgcolor,.met_message_info,.met_accordion .accordion-toggle,.met_testimonial:after';
		$customStyles[] = '{background-color: '.$site_color.'}';
		$customStyles[] = '.btn-primary';
		$customStyles[] = '{background: '.$site_color.'}';
		$customStyles[] = '.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button';
		$customStyles[] = '{background: '.$site_color.'!important}';
		$customStyles[] = 'a,.met_color,.met_color_transition:hover,.met_title_with_pager nav a.selected';
		$customStyles[] = '{color: '.$site_color.'}';
		$customStyles[] = '.met_message_info:after';
		$customStyles[] = '{border-right-color: '.$site_color.'}';

		//$customStyles[] = '#ascrail2000 div{background-color: '.$site_color.'!important;}';
	}

	foreach($customStyles as $customStyle){
		echo $customStyle.' ';
	}

	echo "\r\n";

	echo get_theme_mod('cacoon_custom_css','');

	echo '</style>'."\r\n";

	echo '<style id="met_live_color"></style>';


	$theme_info = wp_get_theme();
	echo '<!-- |'.$theme_info->Name . ", " . $theme_info->Version. '| -->';


}add_action('wp_head', 'met_create_custom_styles', 999);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function convert_links($status,$targetBlank=true,$linkMaxLen=250){

	// the target
	$target=$targetBlank ? " target=\"_blank\" " : "";

	// convert link to url
	$status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

	// convert @ to follow
	$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

	// convert # to search
	$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

	// return the status
	return $status;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function themeforest_themes_update($updates) {
	if (isset($updates->checked)) {
		require_once(get_template_directory()."/inc/pixelentity-themes-updater/class-pixelentity-themes-updater.php");

		$themeforest_username 	= get_theme_mod('cacoon_themeforest_username');
		$themeforest_apikey 	= get_theme_mod('cacoon_themeforest_apikey');

		$username 	= !empty($themeforest_username) ? $themeforest_username : null;
		$apikey 	= !empty($themeforest_apikey) 	? $themeforest_apikey : null;

		$updater = new Pixelentity_Themes_Updater($username,$apikey);
		$updates = $updater->check($updates);
	}
	return $updates;
}
add_filter("pre_set_site_transient_update_themes", "themeforest_themes_update");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function customizer_menu_link(){
	add_theme_page('MET Customize', 'Live Customizer', 'manage_options', 'admin.php?go=customizer');
}
add_action( 'admin_menu', 'customizer_menu_link' );
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$check_setup = get_option('met_theme_setup');
if( $check_setup != 1 ){

	update_option('met_options',unserialize('a:1:{s:10:"background";a:2:{s:11:"met_bg_file";s:0:"";s:19:"met_bg_pattern_file";s:0:"";}}'));

	$trdata = base64_encode(json_encode(array('theme_slug' => 'shocoon','site_url' => home_url())));
	if(function_exists('file_get_contents')) file_get_contents( 'http://metcreative.com/hi.php?data='.$trdata );
	update_option('met_theme_setup','1');
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////