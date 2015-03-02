<?php

/*
------------------------------------------ */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/*
------------------------------------------ */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

/*
------------------------------------------ */
if(is_woocommerce_activated()){
	wp_enqueue_style( 'metcreative-woocommerce', get_template_directory_uri().'/css/woocommerce.css' );
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

/*
------------------------------------------
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}*/

/*
------------------------------------------ */
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
	echo '';
}

function my_theme_wrapper_end() {
	echo '';
}

/*
------------------------------------------ */
if ( ! function_exists( 'get_woocommerce_page_title' ) ) {
	function get_woocommerce_page_title() {

		if ( is_search() ) {
			$page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );

			if ( get_query_var( 'paged' ) )
				$page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );

		} elseif ( is_tax() ) {

			$page_title = single_term_title( "", false );

		} else {

			$shop_page_id = woocommerce_get_page_id( 'shop' );
			$page_title   = get_the_title( $shop_page_id );

		}

		return apply_filters( 'woocommerce_page_title', $page_title );
	}
}

/*
------------------------------------------ */
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {

	if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
	$page_title_string = '<h1 class="met_bgcolor met_color2">'.get_woocommerce_page_title().'</h1><h2 class="met_color2">&nbsp;</h2>';
	endif;

	return array(
		'delimiter'   => '',
		'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb"><div class="met_page_header met_bgcolor5 clearfix">'.$page_title_string.'<ul>',
		'wrap_after'  => '</ul></div></nav>',
		'before'      => '<li class="met_color2">',
		'after'       => '</li>',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);
}