<?php

/***** MH Slider *****/

class mh_edition_lite_slider extends WP_Widget {
    function __construct() {
		parent::__construct(
			'mh_edition_lite_slider', esc_html_x('MH Slider', 'widget name', 'mh-edition-lite'),
			array(
				'classname' => 'mh_edition_lite_slider',
				'description' => esc_html__('MH Slider widget for use on homepage template.', 'mh-edition-lite')
			)
		);
	}
    function widget($args, $instance) {
    	$defaults = array('category' => 0, 'postcount' => 5, 'offset' => 0, 'width' => 'large_slider', 'sticky' => 1);
		$instance = wp_parse_args($instance, $defaults);
		$query_args = array();
		if (0 !== $instance['category']) {
			$query_args['category__in'] = $instance['category'];
		}
		if (!empty($instance['postcount'])) {
			$query_args['posts_per_page'] = $instance['postcount'];
		}
		if (0 !== $instance['offset']) {
			$query_args['offset'] = $instance['offset'];
		}
		if (1 === $instance['sticky']) {
			$query_args['ignore_sticky_posts'] = true;
		}
		$slider_loop = new WP_Query($query_args);
		echo $args['before_widget']; ?>
        	<div id="<?php echo esc_attr($args['widget_id']); ?>" class="flexslider mh-slider-widget <?php echo 'mh-slider-' . esc_attr($instance['width']); ?>">
				<ul class="slides"><?php
					while ($slider_loop->have_posts()) : $slider_loop->the_post(); ?>
						<li class="mh-slider-item">
							<article>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
									if (has_post_thumbnail()) {
										if ($instance['width'] == 'large_slider') {
											the_post_thumbnail('mh-edition-lite-slider');
										} else {
											the_post_thumbnail('mh-edition-lite-content');
										}
									} else {
										if ($instance['width'] == 'large_slider') {
											echo '<img class="mh-image-placeholder" src="' . esc_url(get_template_directory_uri() . '/images/placeholder-slider.png') . '" alt="' . esc_html__('No Picture', 'mh-edition-lite') . '" />';
										} else {
											echo '<img class="mh-image-placeholder" src="' . esc_url(get_template_directory_uri() . '/images/placeholder-content.png') . '" alt="' . esc_html__('No Picture', 'mh-edition-lite') . '" />';
										}
									} ?>
								</a>
								<div class="mh-slider-caption">
									<div class="mh-slider-content">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<h2 class="mh-slider-title">
												<?php the_title(); ?>
											</h2>
										</a>
										<?php the_excerpt(); ?>
									</div>
								</div>
							</article>
						</li><?php
					endwhile;
					wp_reset_postdata(); ?>
				</ul>
			</div><?php
        echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
    	$instance = array();
        if (0 !== absint($new_instance['category'])) {
			$instance['category'] = absint($new_instance['category']);
		}
		if (0 !== absint($new_instance['postcount'])) {
			if (absint($new_instance['postcount']) > 50) {
				$instance['postcount'] = 50;
			} else {
				$instance['postcount'] = absint($new_instance['postcount']);
			}
		}
		if (0 !== absint($new_instance['offset'])) {
			if (absint($new_instance['offset']) > 50) {
				$instance['offset'] = 50;
			} else {
				$instance['offset'] = absint($new_instance['offset']);
			}
		}
		if ('large_slider' !== $new_instance['width']) {
			if (in_array($new_instance['width'], array('normal_slider'))) {
				$instance['width'] = $new_instance['width'];
			}
		}
		$instance['sticky'] = (!empty($new_instance['sticky'])) ? 1 : 0;
        return $instance;
    }
    function form($instance) {
    	$defaults = array('category' => 0, 'postcount' => 5, 'offset' => 0, 'width' => 'large_slider', 'sticky' => 1);
        $instance = wp_parse_args($instance, $defaults); ?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Select a Category:', 'mh-edition-lite'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('category')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
            	<option value="0" <?php selected(0, $instance['category']); ?>><?php esc_html_e('All', 'mh-edition-lite'); ?></option><?php
            		$categories = get_categories();
            		foreach ($categories as $cat) { ?>
            			<option value="<?php echo absint($cat->cat_ID); ?>" <?php selected($cat->cat_ID, $instance['category']); ?>><?php echo esc_html($cat->cat_name) . ' (' . absint($cat->category_count) . ')'; ?></option><?php
            		} ?>
            </select>
            <small><?php _e('Select a category to display posts from.', 'mh-edition-lite'); ?></small>
		</p>
	    <p>
        	<label for="<?php echo esc_attr($this->get_field_id('postcount')); ?>"><?php esc_html_e('Post Count (max. 50):', 'mh-edition-lite'); ?></label>
			<input class="widefat" type="text" value="<?php echo absint($instance['postcount']); ?>" name="<?php echo esc_attr($this->get_field_name('postcount')); ?>" id="<?php echo esc_attr($this->get_field_id('postcount')); ?>" />
	    </p>
	    <p>
        	<label for="<?php echo esc_attr($this->get_field_id('offset')); ?>"><?php esc_html_e('Skip Posts (max. 50):', 'mh-edition-lite'); ?></label>
			<input class="widefat" type="text" value="<?php echo absint($instance['offset']); ?>" name="<?php echo esc_attr($this->get_field_name('offset')); ?>" id="<?php echo esc_attr($this->get_field_id('offset')); ?>" />
	    </p>
        <p>
	    	<label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php esc_html_e('Image size:', 'mh-edition-lite'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('width')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('width')); ?>">
				<option value="normal_slider" <?php selected('normal_slider', $instance['width']); ?>><?php esc_html_e('Normal', 'mh-edition-lite'); ?></option>
				<option value="large_slider" <?php selected('large_slider', $instance['width']); ?>><?php esc_html_e('Large', 'mh-edition-lite'); ?></option>
			</select>
        </p>
		<p>
			<input id="<?php echo esc_attr($this->get_field_id('sticky')); ?>" name="<?php echo esc_attr($this->get_field_name('sticky')); ?>" type="checkbox" value="1" <?php checked(1, $instance['sticky']); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('sticky')); ?>"><?php esc_html_e('Ignore Sticky Posts', 'mh-edition-lite'); ?></label>
		</p>
		<p>
    		<strong><?php _e('Info:', 'mh-edition-lite'); ?></strong> <?php _e('This is the lite version of this widget with basic features. If you need more advanced features and options, you can upgrade to the premium version of this theme.', 'mh-edition-lite'); ?>
    	</p><?php
    }
}

?>