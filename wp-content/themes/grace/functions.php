<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function grace_theme_setup() {

	remove_action( 'omega_before_header', 'omega_get_primary_menu' );	
	add_action( 'omega_header', 'omega_get_primary_menu' );

	add_theme_support( 'custom-background', 
		array(
			'default-color' => '000000',
			'default-repeat'         => 'no-repeat',
			'default-position-x'     => 'center',
			'default-attachment'     => 'fixed',
			'default-image' => get_stylesheet_directory_uri() . '/images/background.jpg',
		));

	add_action( 'omega_after_header', 'grace_intro' );

	add_filter( 'omega_site_description', 'grace_site_description' );

	add_action( 'wp_enqueue_scripts', 'grace_scripts_styles' );

	load_child_theme_textdomain( 'grace', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'grace_theme_setup', 11 );

/**
 * Loads the intro.php template.
 */
function grace_intro() {
	$id = get_option('page_for_posts');
	// get title		
	if (is_front_page() || (is_home() && ($id=='0'))) {
		$the_title = "<h1 class='intro-title site-description'>" . get_bloginfo ( 'description' ) . "</h1>";
	} elseif ( is_day() || is_month() || is_year() || is_tag() || is_category() || is_home() ) {
		$id = get_option('page_for_posts');
		if ( 'posts' == get_option( 'show_on_front' ) ) {
			$the_title = get_bloginfo ( 'description' );
		} else {
			$the_title = get_the_title($id);
		}
		$the_title = "<h2 class='intro-title'>$the_title</h2>";
	} elseif (is_singular('post' )) {
		$the_title = "<h3 class='intro-title'>" . get_the_title($id) . "</h3>"; 
	} else {
		$the_title = "<h1 class='intro-title'>" . get_the_title() . "</h1>"; 
	}

	echo '<div class="site-intro">'.$the_title.'</div>';
}

function grace_site_description($desc) {
	$desc = "";
	return $desc;
}

function grace_scripts_styles() {
	$query_args = array(
	 'family' => 'Open+Sans:300,400|Raleway'
	);
 	wp_enqueue_style('google-fonts', esc_url( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) ), array(), null  );
}