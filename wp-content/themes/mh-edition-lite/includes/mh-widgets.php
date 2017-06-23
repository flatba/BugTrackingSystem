<?php

/***** Register Widgets *****/

function mh_edition_lite_register_widgets() {
	register_widget('mh_edition_lite_custom_posts');
	register_widget('mh_edition_lite_posts_list');
	register_widget('mh_edition_lite_slider');
	register_widget('mh_edition_lite_carousel');
}
add_action('widgets_init', 'mh_edition_lite_register_widgets');

/***** Include Widgets *****/

require_once('widgets/mh-custom-posts.php');
require_once('widgets/mh-posts-list.php');
require_once('widgets/mh-slider.php');
require_once('widgets/mh-carousel.php');

?>