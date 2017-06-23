<?php

/***** MH Custom Posts *****/

class mh_edition_lite_custom_posts extends WP_Widget {
    function __construct() {
		parent::__construct(
			'mh_edition_lite_custom_posts', esc_html_x('MH Custom Posts', 'widget name', 'mh-edition-lite'),
			array(
				'classname' => 'mh_edition_lite_custom_posts',
				'description' => esc_html__('MH Custom Posts widget to display posts based on categories or tags.', 'mh-edition-lite'),
				'customize_selective_refresh' => true
			)
		);
	}
    function widget($args, $instance) {
  		$defaults = array('title' => '', 'category' => 0, 'postcount' => 5, 'offset' => 0, 'sticky' => 1);
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
		$counter = 1;
		$widget_loop = new WP_Query($query_args);
        echo $args['before_widget'];
        	if (!empty($instance['title'])) {
	        	echo $args['before_title'] . esc_html(apply_filters('widget_title', $instance['title'])) . $args['after_title'];
			} ?>
			<ul class="mh-custom-posts-widget clearfix"><?php
				while ($widget_loop->have_posts()) : $widget_loop->the_post();
					if ($counter == 1) : ?>
						<li class="mh-custom-posts-item mh-custom-posts-large clearfix">
							<div class="mh-custom-posts-large-inner clearfix">
								<div class="mh-custom-posts-thumb-xl">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
										if (has_post_thumbnail()) {
											the_post_thumbnail('mh-edition-lite-medium'); }
										else {
											echo '<img class="mh-image-placeholder" src="' . get_template_directory_uri() . '/images/placeholder-medium.png' . '" alt="' . esc_html__('No Picture', 'mh-edition-lite') . '" />';
										} ?>
									</a>
								</div>
								<div class="mh-custom-posts-content">
									<header class="mh-custom-posts-header">
										<h3 class="mh-custom-posts-xl-title">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
										<div class="mh-meta mh-custom-posts-meta">
											<?php mh_edition_lite_loop_meta(); ?>
										</div>
									</header>
									<?php the_excerpt(); ?>
								</div>
							</div>
						</li><?php
					else : ?>
						<li class="mh-custom-posts-item mh-custom-posts-small clearfix">
							<div class="mh-custom-posts-thumb">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
									if (has_post_thumbnail()) {
										the_post_thumbnail('mh-edition-lite-small');
									} else {
										echo '<img class="mh-image-placeholder" src="' . get_template_directory_uri() . '/images/placeholder-small.png' . '" alt="No Picture" />';
									} ?>
								</a>
							</div>
							<header class="mh-custom-posts-header">
								<p class="mh-custom-posts-small-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</p>
								<div class="mh-meta mh-custom-posts-meta">
									<?php mh_edition_lite_loop_meta(); ?>
								</div>
							</header>
						</li><?php
					endif;
					$counter++;
				endwhile;
				wp_reset_postdata(); ?>
			</ul><?php
        echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
   		$instance = array();
        if (!empty($new_instance['title'])) {
			$instance['title'] = sanitize_text_field($new_instance['title']);
		}
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
		$instance['sticky'] = (!empty($new_instance['sticky'])) ? 1 : 0;
        return $instance;
    }
    function form($instance) {
        $defaults = array('title' => '', 'category' => 0, 'postcount' => 5, 'offset' => 0, 'sticky' => 1);
        $instance = wp_parse_args($instance, $defaults); ?>
		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'mh-edition-lite'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
        </p>
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
			<input id="<?php echo esc_attr($this->get_field_id('sticky')); ?>" name="<?php echo esc_attr($this->get_field_name('sticky')); ?>" type="checkbox" value="1" <?php checked(1, $instance['sticky']); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('sticky')); ?>"><?php esc_html_e('Ignore Sticky Posts', 'mh-edition-lite'); ?></label>
		</p>
		<p>
    		<strong><?php _e('Info:', 'mh-edition-lite'); ?></strong> <?php _e('This is the lite version of this widget with basic features. If you need more advanced features and options, you can upgrade to the premium version of this theme.', 'mh-edition-lite'); ?>
    	</p><?php
    }
}

?>