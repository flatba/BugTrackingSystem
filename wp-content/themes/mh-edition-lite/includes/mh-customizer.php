<?php

function mh_edition_lite_customizer($wp_customize) {

	/***** Register Custom Controls *****/

    class MH_Edition_Lite_Upgrade extends WP_Customize_Control {
        public function render_content() {  ?>
        	<p class="mh-upgrade-thumb">
        		<img src="<?php echo get_template_directory_uri(); ?>/images/mh_edition.png" />
        	</p>
        	<p class="customize-control-title mh-upgrade-title">
        		<?php esc_html_e('MH Edition Pro', 'mh-edition-lite'); ?>
        	</p>
        	<p class="textfield mh-upgrade-text">
        		<?php esc_html_e('If you like the free version of this theme, you will LOVE the full version of MH Edition which includes unique custom widgets, additional features and more useful options to customize your website.', 'mh-edition-lite'); ?>
			</p>
			<p class="customize-control-title mh-upgrade-title">
        		<?php esc_html_e('Additional Features:', 'mh-edition-lite'); ?>
        	</p>
        	<ul class="mh-upgrade-features">
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Options to modify color scheme', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Typography options', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Several additional widget areas', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Additional custom widgets', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Extended layout options', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Additional custom menu slots', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('Social buttons, related articles, ...', 'mh-edition-lite'); ?>
	        	</li>
	        	<li class="mh-upgrade-feature-item">
	        		<?php esc_html_e('News ticker and many more...', 'mh-edition-lite'); ?>
	        	</li>
        	</ul>
			<p class="mh-button mh-upgrade-button">
				<a href="https://www.mhthemes.com/themes/mh/edition/" target="_blank" class="button button-secondary">
					<?php esc_html_e('Upgrade to MH Edition Pro', 'mh-edition-lite'); ?>
				</a>
			</p>
			<p class="mh-button">
				<a href="https://www.mhthemes.com/themes/showcase/" target="_blank" class="button button-secondary">
					<?php esc_html_e('MH Themes Showcase', 'mh-edition-lite'); ?>
				</a>
			</p>
			<p class="mh-button">
				<a href="https://www.mhthemes.com/support/documentation-mh-edition/" target="_blank" class="button button-secondary">
					<?php esc_html_e('Theme Documentation', 'mh-edition-lite'); ?>
				</a>
			</p>
			<p class="mh-button">
				<a href="https://wordpress.org/support/theme/mh-edition-lite" target="_blank" class="button button-secondary">
					<?php esc_html_e('Support Forum', 'mh-edition-lite'); ?>
				</a>
			</p><?php
        }
    }

	/***** Add Panels *****/

	$wp_customize->add_panel('mh_edition_lite_theme_options', array('title' => esc_html__('Theme Options', 'mh-edition-lite'), 'description' => '', 'capability' => 'edit_theme_options', 'theme_supports' => '', 'priority' => 1));

	/***** Add Sections *****/

	$wp_customize->add_section('mh_edition_lite_general', array('title' => esc_html__('General', 'mh-edition-lite'), 'priority' => 1, 'panel' => 'mh_edition_lite_theme_options'));
	$wp_customize->add_section('mh_edition_lite_layout', array('title' => esc_html__('Layout', 'mh-edition-lite'), 'priority' => 2, 'panel' => 'mh_edition_lite_theme_options'));
	$wp_customize->add_section('mh_edition_lite_upgrade', array('title' => esc_html__('More Features', 'mh-edition-lite'), 'priority' => 3, 'panel' => 'mh_edition_lite_theme_options'));

    /***** Add Settings *****/

    $wp_customize->add_setting('mh_edition_lite_options[excerpt_length]', array('default' => 25, 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_edition_lite_options[excerpt_more]', array('default' => esc_html__('Read More', 'mh-edition-lite'), 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_text'));
    $wp_customize->add_setting('mh_edition_lite_options[sidebar]', array('default' => 'right', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_edition_lite_options[premium_version_upgrade]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'esc_attr'));
    $wp_customize->add_setting('mh_edition_lite_options[full_bg]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));

    /***** Add Controls *****/

    $wp_customize->add_control('excerpt_length', array('label' => esc_html__('Custom Excerpt Length in Words', 'mh-edition-lite'), 'section' => 'mh_edition_lite_general', 'settings' => 'mh_edition_lite_options[excerpt_length]', 'priority' => 1, 'type' => 'text'));
    $wp_customize->add_control('excerpt_more', array('label' => esc_html__('Custom Excerpt More-Text', 'mh-edition-lite'), 'section' => 'mh_edition_lite_general', 'settings' => 'mh_edition_lite_options[excerpt_more]', 'priority' => 2, 'type' => 'text'));
    $wp_customize->add_control('sidebar', array('label' => esc_html__('Sidebar Position', 'mh-edition-lite'), 'section' => 'mh_edition_lite_layout', 'settings' => 'mh_edition_lite_options[sidebar]', 'priority' => 1, 'type' => 'select', 'choices' => array('left' => esc_html__('Left', 'mh-edition-lite'), 'right' => esc_html__('Right', 'mh-edition-lite'))));
	$wp_customize->add_control(new MH_Edition_Lite_Upgrade($wp_customize, 'premium_version_upgrade', array('section' => 'mh_edition_lite_upgrade', 'settings' => 'mh_edition_lite_options[premium_version_upgrade]', 'priority' => 1)));
	$wp_customize->add_control('full_bg', array('label' => esc_html__('Scale Background Image to Full Size', 'mh-edition-lite'), 'section' => 'background_image', 'settings' => 'mh_edition_lite_options[full_bg]', 'priority' => 99, 'type' => 'checkbox'));
}
add_action('customize_register', 'mh_edition_lite_customizer');

/***** Data Sanitization *****/

function mh_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}
function mh_sanitize_integer($input) {
    return strip_tags(intval($input));
}
function mh_sanitize_checkbox($input) {
    if ($input == 1) {
        return 1;
    } else {
        return '';
    }
}
function mh_sanitize_select($input) {
    $valid = array(
        'left' => esc_html__('Left', 'mh-edition-lite'),
        'right' => esc_html__('Right', 'mh-edition-lite')
    );
    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

/***** Return Theme Options / Set Default Options *****/

if (!function_exists('mh_edition_lite_theme_options')) {
	function mh_edition_lite_theme_options() {
		$theme_options = wp_parse_args(
			get_option('mh_edition_lite_options', array()),
			mh_edition_lite_default_options()
		);
		return $theme_options;
	}
}

if (!function_exists('mh_edition_lite_default_options')) {
	function mh_edition_lite_default_options() {
		$default_options = array(
			'excerpt_length' => 25,
			'excerpt_more' => esc_html__('Read More', 'mh-edition-lite'),
			'sidebar' => 'right',
			'full_bg' => ''
		);
		return $default_options;
	}
}

/***** Enqueue Customizer CSS *****/

function mh_edition_lite_customizer_css() {
	wp_enqueue_style('mh-customizer', get_template_directory_uri() . '/admin/customizer.css', array());
}
add_action('customize_controls_print_styles', 'mh_edition_lite_customizer_css');

?>