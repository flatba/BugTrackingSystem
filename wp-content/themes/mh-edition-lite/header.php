<!DOCTYPE html>
<html class="no-js<?php mh_html_class(); ?>" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php if (is_singular() && pings_open(get_queried_object())) : ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body id="mh-mobile" <?php body_class(); ?>>
<div class="mh-container mh-container-outer">
<div class="mh-header-mobile-nav clearfix"></div>
<header class="mh-header">
	<div class="mh-container mh-container-inner mh-row clearfix">
		<?php mh_edition_lite_custom_header(); ?>
	</div>
	<nav class="mh-main-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'mh_main_nav')); ?>
	</nav>
</header>