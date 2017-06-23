<?php

/***** Fetch Theme Data & Options *****/

$mh_edition_lite_data = wp_get_theme('mh-edition-lite');
$mh_edition_lite_version = $mh_edition_lite_data['Version'];
$mh_edition_lite_options = get_option('mh_edition_lite_options');

/***** Custom Hooks *****/

function mh_html_class() {
    do_action('mh_html_class');
}
function mh_post_header() {
    do_action('mh_post_header');
}
function mh_post_content_top() {
    do_action('mh_post_content_top');
}
function mh_after_post_content() {
    do_action('mh_after_post_content');
}

/***** Theme Setup *****/

if (!function_exists('mh_edition_lite_theme_setup')) {
	function mh_edition_lite_theme_setup() {
		load_theme_textdomain('mh-edition-lite', get_template_directory() . '/languages');
		add_filter('use_default_gallery_style', '__return_false');
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
		add_theme_support('post-thumbnails');
		add_theme_support('custom-background', array('default-color' => 'f7f7f7'));
		add_theme_support('custom-header', array('default-image' => '', 'default-text-color' => '2a2a2a', 'width' => 300, 'height' => 90, 'flex-width' => true, 'flex-height' => true));
		add_theme_support('customize-selective-refresh-widgets');
	}
}
add_action('after_setup_theme', 'mh_edition_lite_theme_setup');

/***** Add Custom Menus *****/

if (!function_exists('mh_edition_lite_custom_menus')) {
	function mh_edition_lite_custom_menus() {
		register_nav_menus(array('mh_main_nav' => __('Main Navigation', 'mh-edition-lite')));
	}
}
add_action('after_setup_theme', 'mh_edition_lite_custom_menus');

/***** Add Custom Image Sizes *****/

if (!function_exists('mh_edition_lite_image_sizes')) {
	function mh_edition_lite_image_sizes() {
		add_image_size('mh-edition-lite-slider', 1120, 476, true);
		add_image_size('mh-edition-lite-content', 737, 415, true);
		add_image_size('mh-edition-lite-medium', 355, 200, true);
		add_image_size('mh-edition-lite-small', 97, 73, true);
	}
}
add_action('after_setup_theme', 'mh_edition_lite_image_sizes');

/***** Set Content Width *****/

if (!function_exists('mh_edition_lite_content_width')) {
	function mh_edition_lite_content_width() {
		global $content_width;
		if (!isset($content_width)) {
			if (is_page_template('template-full.php')) {
				$content_width = 1120;
			} else {
				$content_width = 737;
			}
		}
	}
}
add_action('template_redirect', 'mh_edition_lite_content_width');

/***** Load CSS & JavaScript *****/

if (!function_exists('mh_edition_lite_scripts')) {
	function mh_edition_lite_scripts() {
		global $mh_edition_lite_version;
		wp_enqueue_style('mh-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,700', array(), null);
		wp_enqueue_style('mh-edition-lite', get_stylesheet_uri(), false, $mh_edition_lite_version);
		wp_enqueue_style('mh-font-awesome', get_template_directory_uri() . '/includes/font-awesome.min.css', array(), null);
		wp_enqueue_script('mh-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), $mh_edition_lite_version);
		if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'mh_edition_lite_scripts');

if (!function_exists('mh_edition_lite_admin_scripts')) {
	function mh_edition_lite_admin_scripts($hook) {
		if ('appearance_page_edition' === $hook || 'widgets.php' === $hook) {
			wp_enqueue_style('mh-admin', get_template_directory_uri() . '/admin/admin.css');
		}
	}
}
add_action('admin_enqueue_scripts', 'mh_edition_lite_admin_scripts');

/***** Register Widget Areas / Sidebars	*****/

if (!function_exists('mh_edition_lite_widgets_init')) {
	function mh_edition_lite_widgets_init() {
		$mh_edition_lite_options = mh_edition_lite_theme_options();
		register_sidebar(array('name' => _x('Sidebar', 'widget area name', 'mh-edition-lite'), 'id' => 'mh-sidebar', 'description' => __('Widget area (sidebar left/right) on single posts, pages and archives.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => _x('Header - Advertisement', 'widget area name', 'mh-edition-lite'), 'id' => 'mh-header-2', 'description' => __('Widget area on top of the site.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-header-2 %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - Full Width', 'widget area name', 'mh-edition-lite'), 1), 'id' => 'mh-home-1', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-1 mh-home-wide %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - 2/3 Width', 'widget area name', 'mh-edition-lite'), 2), 'id' => 'mh-home-2', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-2 mh-home-wide %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - 1/3 Width', 'widget area name', 'mh-edition-lite'), 3), 'id' => 'mh-home-3', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-3 %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - 1/3 Width', 'widget area name', 'mh-edition-lite'), 4), 'id' => 'mh-home-4', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-4 %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - 2/3 Width', 'widget area name', 'mh-edition-lite'), 5), 'id' => 'mh-home-5', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-5 mh-home-wide %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => sprintf(_x('Home %d - 1/3 Width', 'widget area name', 'mh-edition-lite'), 6), 'id' => 'mh-home-6', 'description' => __('Widget area on homepage.', 'mh-edition-lite'), 'before_widget' => '<div id="%1$s" class="mh-widget mh-home-6 %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="mh-widget-title">', 'after_title' => '</h4>'));
	}
}
add_action('widgets_init', 'mh_edition_lite_widgets_init');

/***** Include Several Functions *****/

if (is_admin()) {
	require_once('admin/admin.php');
}

require_once('includes/mh-customizer.php');
require_once('includes/mh-widgets.php');
require_once('includes/mh-custom-functions.php');

//2017/06/23 投稿用ファイルを読み込む
get_template_part('functions/create-thread');

?>
