<?php

/***** Add CSS classes to HTML tag *****/

if (!function_exists('mh_edition_lite_html_class')) {
	function mh_edition_lite_html_class() {
		$mh_edition_lite_options = mh_edition_lite_theme_options();
		$mh_edition_lite_options['full_bg'] == 1 ? $fullbg = ' fullbg' : $fullbg = '';
		echo $fullbg;
	}
}
add_action('mh_html_class', 'mh_edition_lite_html_class');

/***** Add CSS classes to body tag *****/

if (!function_exists('mh_edition_lite_body_class')) {
	function mh_edition_lite_body_class($classes) {
		$mh_edition_lite_options = mh_edition_lite_theme_options();
		$classes[] = 'mh-' . esc_attr($mh_edition_lite_options['sidebar']) . '-sb';
		return $classes;
	}
}
add_filter('body_class', 'mh_edition_lite_body_class');

/***** Add CSS3 Media Queries Support for older versions of IE *****/

if (!function_exists('mh_edition_lite_media_queries')) {
	function mh_edition_lite_media_queries() {
		echo '<!--[if lt IE 9]>' . "\n";
		echo '<script src="' . get_template_directory_uri() . '/js/css3-mediaqueries.js"></script>' . "\n";
		echo '<![endif]-->' . "\n";
	}
}
add_action('wp_head', 'mh_edition_lite_media_queries');

/***** Custom Header *****/

if (!function_exists('mh_edition_lite_custom_header')) {
	function mh_edition_lite_custom_header() {
		$header_image = get_header_image();
		$header_title = get_bloginfo('name');
		$header_tagline = get_bloginfo('description');
		is_active_sidebar('mh-header-2') ? $header_cols = 'mh-col-1-3' : $header_cols = 'mh-col-1-1';
		echo '<div class="' . $header_cols . ' mh-custom-header">' . "\n";
			echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr($header_title) . '" rel="home">' . "\n";
				echo '<div class="mh-site-logo" role="banner">' . "\n";
					if ($header_image) {
						echo '<img class="mh-header-image" src="' . esc_url($header_image) . '" height="' . get_custom_header()->height . '" width="' . get_custom_header()->width . '" alt="' . esc_attr($header_title) . '" />' . "\n";
					}
					if (display_header_text()) {
						$header_text_color = get_header_textcolor();
						if ($header_text_color != get_theme_support('custom-header', 'default-text-color')) {
							echo '<style type="text/css" id="mh-header-css">';
								echo '.mh-header-title, .mh-header-tagline { color: #' . esc_attr($header_text_color) . '; }';
							echo '</style>' . "\n";
						}
						echo '<div class="mh-header-text">' . "\n";
							if (is_front_page()) {
								$header_title_before = '<h1 class="mh-header-title">';
								$header_title_after = '</h1>' . "\n";
								$header_tagline_before = '<h2 class="mh-header-tagline">';
								$header_tagline_after = '</h2>' . "\n";
							} else {
								$header_title_before = '<h2 class="mh-header-title">';
								$header_title_after = '</h2>' . "\n";
								$header_tagline_before = '<h3 class="mh-header-tagline">';
								$header_tagline_after = '</h3>' . "\n";
							}
							if ($header_title) {
								echo $header_title_before . esc_attr($header_title) . $header_title_after;
							}
							if ($header_tagline) {
								echo $header_tagline_before . esc_attr($header_tagline) . $header_tagline_after;
							}
						echo '</div>' . "\n";
					}
				echo '</div>' . "\n";
			echo '</a>' . "\n";
		echo '</div>' . "\n";
		if (is_active_sidebar('mh-header-2')) {
			echo '<div class="mh-col-2-3 mh-header-widget-2">' . "\n";
				dynamic_sidebar('mh-header-2');
			echo '</div>' . "\n";
		}
	}
}

/***** Page Title Output *****/

if (!function_exists('mh_edition_lite_page_title')) {
	function mh_edition_lite_page_title() {
		if (!is_front_page()) {
			echo '<header class="page-header">' . "\n";
				echo '<h1 class="page-title">';
					if (is_archive()) {
						if (is_category() || is_tax()) {
							single_cat_title();
						} elseif (is_tag()) {
							single_tag_title();
						} elseif (is_author()) {
							global $author;
							$user_info = get_userdata($author);
							printf(_x('Articles by %s', 'post author', 'mh-edition-lite'), esc_attr($user_info->display_name));
						} elseif (is_day()) {
							echo get_the_date();
						} elseif (is_month()) {
							echo get_the_date('F Y');
						} elseif (is_year()) {
							echo get_the_date('Y');
						} elseif (is_post_type_archive()) {
							global $post;
							$post_type = get_post_type_object(get_post_type($post));
							echo esc_attr($post_type->labels->name);
						} else {
							_e('Archives', 'mh-edition-lite');
						}
					} else {
						if (is_home()) {
							echo esc_attr(get_the_title(get_option('page_for_posts', true)));
						} elseif (is_404()) {
							_e('Page not found (404)', 'mh-edition-lite');
						} elseif (is_search()) {
							printf(__('Search Results for %s', 'mh-edition-lite'), esc_attr(get_search_query()));
						} else {
							the_title();
						}
					}
				echo '</h1>' . "\n";
			echo '</header>' . "\n";
		}
	}
}

/***** Post Meta *****/

if (!function_exists('mh_edition_lite_post_meta')) {
	function mh_edition_lite_post_meta() {
		echo '<p class="mh-meta entry-meta">' . "\n";
			echo '<span class="entry-meta-date updated"><i class="fa fa-clock-o"></i><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_date() . '</a></span>' . "\n";
			echo '<span class="entry-meta-author vcard"><i class="fa fa-user"></i><a class="fn" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>' . "\n";
			echo '<span class="entry-meta-categories"><i class="fa fa-folder-open-o"></i>' . get_the_category_list(', ', '') . '</span>' . "\n";
			echo '<span class="entry-meta-comments"><i class="fa fa-comment-o"></i><a class="mh-comment-scroll" href="' . esc_url(get_permalink() . '#mh-comments') . '">' . get_comments_number() . '</a></span>' . "\n";
		echo '</p>' . "\n";
	}
}
add_action('mh_post_header', 'mh_edition_lite_post_meta');

/***** Post Meta (Loop) *****/

if (!function_exists('mh_edition_lite_loop_meta')) {
	function mh_edition_lite_loop_meta() {
		echo '<span class="mh-meta-date"><i class="fa fa-clock-o"></i>' . get_the_date() . '</span>' . "\n";
		echo '<span class="mh-meta-comments"><i class="fa fa-comment-o"></i>';
			mh_edition_lite_comment_count();
		echo '</span>' . "\n";
	}
}

/***** Featured Image on Posts *****/

if (!function_exists('mh_edition_lite_featured_image')) {
	function mh_edition_lite_featured_image() {
		global $page, $post;
		if (has_post_thumbnail() && $page == '1') {
			$caption_text = get_post(get_post_thumbnail_id())->post_excerpt;
			echo "\n" . '<figure class="entry-thumbnail">' . "\n";
				the_post_thumbnail('mh-edition-lite-content');
				if ($caption_text) {
					echo '<figcaption class="wp-caption-text">' . wp_kses_post($caption_text) . '</figcaption>' . "\n";
				}
			echo '</figure>' . "\n";
		}
	}
}
add_action('mh_post_content_top', 'mh_edition_lite_featured_image');

/***** Pagination for paginated Posts *****/

if (!function_exists('mh_edition_lite_paginated_posts')) {
	function mh_edition_lite_paginated_posts($content) {
		if (is_singular() && is_main_query()) {
			$content .= wp_link_pages(array('before' => '<div class="pagination clearfix">', 'after' => '</div>', 'link_before' => '<span class="pagelink">', 'link_after' => '</span>', 'nextpagelink' => __('&raquo;', 'mh-edition-lite'), 'previouspagelink' => __('&laquo;', 'mh-edition-lite'), 'pagelink' => '%', 'echo' => 0));
		}
		return $content;
	}
}
add_filter('the_content', 'mh_edition_lite_paginated_posts', 1);

/***** Author box *****/

if (!function_exists('mh_edition_lite_author_box')) {
	function mh_edition_lite_author_box() {
		$mh_author_box_ID = get_the_author_meta('ID');
		if (get_the_author_meta('description', $mh_author_box_ID) && !is_attachment()) {
			get_template_part('content', 'author-box');
		}
	}
}
add_action('mh_after_post_content', 'mh_edition_lite_author_box');

/***** Post / Image Navigation *****/

if (!function_exists('mh_edition_lite_postnav')) {
	function mh_edition_lite_postnav() {
		global $post;
		$parent_post = get_post($post->post_parent);
		$attachment = is_attachment();
		$previous = ($attachment) ? $parent_post : get_adjacent_post(false, '', true);
		$next = get_adjacent_post(false, '', false);

		if (!$next && !$previous)
		return;

		if ($attachment) {
			$attachments = get_children(array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $parent_post->ID));
			$count = count($attachments);
		}
		echo '<nav class="mh-post-nav-wrap clearfix" role="navigation">' . "\n";
			if ($previous || $attachment) {
				echo '<div class="mh-post-nav-prev mh-post-nav">' . "\n";
					if ($attachment) {
						if (wp_attachment_is_image($post->id)) {
							if ($count == 1) {
								echo '<a href="' . esc_url(get_permalink($parent_post)) . '">' . __('Back to article', 'mh-edition-lite') . '</a>';
							} else {
								previous_image_link('%link', __('Previous image', 'mh-edition-lite'));
							}
						} else {
							echo '<a href="' . esc_url(get_permalink($parent_post)) . '">' . __('Back to article', 'mh-edition-lite') . '</a>';
						}
					} else {
						previous_post_link('%link', __('Previous article', 'mh-edition-lite'));
					}
				echo '</div>' . "\n";
			}
			if ($next || $attachment) {
				echo '<div class="mh-post-nav-next mh-post-nav">' . "\n";
					if ($attachment && wp_attachment_is_image($post->id)) {
						next_image_link('%link', __('Next image', 'mh-edition-lite'));
					} else {
						next_post_link('%link', __('Next article', 'mh-edition-lite'));
					}
				echo '</div>' . "\n";
			}
		echo '</nav>' . "\n";
	}
}
add_action('mh_after_post_content', 'mh_edition_lite_postnav');

/***** Custom Excerpts *****/

if (!function_exists('mh_edition_lite_excerpt_length')) {
	function mh_edition_lite_excerpt_length($length) {
		$mh_edition_lite_options = mh_edition_lite_theme_options();
		$excerpt_length = absint($mh_edition_lite_options['excerpt_length']);
		return $excerpt_length;
	}
}
add_filter('excerpt_length', 'mh_edition_lite_excerpt_length', 999);

if (!function_exists('mh_edition_lite_excerpt_more')) {
	function mh_edition_lite_excerpt_more($more) {
		global $post;
		$mh_edition_lite_options = mh_edition_lite_theme_options();
		if (!empty($mh_edition_lite_options['excerpt_more'])) {
			return ' <a class="mh-excerpt-more" href="' . esc_url(get_permalink($post->ID)) . '" title="' . the_title_attribute('echo=0') . '">' . esc_attr($mh_edition_lite_options['excerpt_more']) . '</a>';
		}
	}
}
add_filter('excerpt_more', 'mh_edition_lite_excerpt_more');

if (!function_exists('mh_edition_lite_excerpt_markup')) {
	function mh_edition_lite_excerpt_markup($excerpt) {
		$markup = '<div class="mh-excerpt">' . $excerpt . '</div>';
		return $markup;
	}
}
add_filter('the_excerpt', 'mh_edition_lite_excerpt_markup');

/***** Add More-Link to Manual Excerpts *****/

if (!function_exists('mh_edition_lite_manual_excerpt')) {
	function mh_edition_lite_manual_excerpt($excerpt) {
		$excerpt_more = '';
		if (has_excerpt()) {
			$excerpt_more = apply_filters('excerpt_more', '');
		}
		return $excerpt . $excerpt_more;
	}
}
add_filter('get_the_excerpt', 'mh_edition_lite_manual_excerpt');

/***** Custom Commentlist *****/

if (!function_exists('mh_edition_lite_comments')) {
	function mh_edition_lite_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class('mh-comment-item'); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="mh-comment-body">
				<footer class="mh-meta mh-comment-meta">
					<span class="vcard mh-comment-author">
						<figure class="mh-comment-gravatar">
							<?php echo get_avatar($comment->comment_author_email, 60); ?>
						</figure>
						<span class="fn"><?php echo get_comment_author_link(); ?></span>
					</span>
					<span class="mh-comment-meta-data">
						<a class="mh-comment-meta-date" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>">
							<?php printf(__('%1$s at %2$s', 'mh-edition-lite'), get_comment_date(),  get_comment_time()) ?>
						</a>
					</span>
				</footer>
				<?php if ($comment->comment_approved == '0') { ?>
					<div class="mh-comment-info">
						<?php _e('Your comment is awaiting moderation.', 'mh-edition-lite') ?>
					</div>
				<?php } ?>
				<div class="mh-comment-content">
					<?php comment_text() ?>
				</div>
				<div class="mh-meta mh-comment-meta-links"><?php
					if (comments_open() && $args['max_depth']!=$depth) {
						comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
					}
					edit_comment_link(__('Edit', 'mh-edition-lite'),'  ',''); ?>
                </div>
			</article><?php
	}
}

/***** Custom Comment Fields *****/

if (!function_exists('mh_edition_lite_comment_fields')) {
	function mh_edition_lite_comment_fields($fields) {
		$commenter = wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true'" : '');
		$fields =  array(
			'author'	=>	'<p class="comment-form-author"><label for="author">' . __('Name ', 'mh-edition-lite') . '</label>' . ($req ? '<span class="required">*</span>' : '') . '<br/><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
			'email' 	=>	'<p class="comment-form-email"><label for="email">' . __('Email ', 'mh-edition-lite') . '</label>' . ($req ? '<span class="required">*</span>' : '' ) . '<br/><input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
			'url' 		=>	'<p class="comment-form-url"><label for="url">' . __('Website', 'mh-edition-lite') . '</label><br/><input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>'
		);
		return $fields;
	}
}
add_filter('comment_form_default_fields', 'mh_edition_lite_comment_fields');

/***** Comment Count Output *****/

if (!function_exists('mh_edition_lite_comment_count')) {
	function mh_edition_lite_comment_count() {
		echo '<a class="mh-comment-count-link" href="' . esc_url(get_permalink() . '#mh-comments') . '">' . get_comments_number() . '</a>';
	}
}

/***** Pagination *****/

if (!function_exists('mh_edition_lite_pagination')) {
	function mh_edition_lite_pagination() {
		global $wp_query;
	    $big = 9999;
	    $paginate_links = paginate_links(array(
	    	'base' 		=> str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
	    	'format' 	=> '?paged=%#%',
	    	'current' 	=> max(1, get_query_var('paged')),
	    	'prev_next' => true,
	    	'prev_text' => __('&laquo;', 'mh-edition-lite'),
	    	'next_text' => __('&raquo;', 'mh-edition-lite'),
	    	'total' 	=> $wp_query->max_num_pages)
	    );
		if ($paginate_links) {
	    	echo '<div class="mh-loop-pagination clearfix">';
				echo $paginate_links;
			echo '</div>';
		}
	}
}

/***** Fix links of carousel widget to work on mobile devices *****/

if (!function_exists('mh_edition_lite_carousel_fix')) {
	function mh_edition_lite_carousel_fix() {
		if (wp_is_mobile() && is_active_widget('', '', 'mh_edition_lite_carousel')) {
			echo '<style type="text/css">.flex-direction-nav { display: none; }</style>';
		}
	}
}
add_action('wp_head', 'mh_edition_lite_carousel_fix');

?>