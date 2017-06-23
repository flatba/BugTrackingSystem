<?php /* Template for displaying author box content */
$mh_author_box_ID = get_the_author_meta('ID');
$name = get_the_author_meta('display_name', $mh_author_box_ID); ?>
<div class="mh-author-box">
	<div class="mh-author-box-content clearfix">
		<figure class="mh-author-box-avatar">
			<?php echo get_avatar($mh_author_box_ID, 90); ?>
		</figure>
		<div class="mh-author-box-header">
			<span class="mh-author-box-name">
				<?php printf(__('About %s', 'mh-edition-lite'), esc_attr($name)); ?>
			</span>
		</div>
		<?php if (get_the_author_meta('description', $mh_author_box_ID)) { ?>
			<div class="mh-author-box-bio">
				<?php echo wp_kses_post(get_the_author_meta('description', $mh_author_box_ID)); ?>
			</div>
		<?php } else { ?>
			<div class="mh-author-box-bio">
				<?php _e('The author has not yet added any personal or biographical info to his author profile.', 'mh-edition-lite'); ?>
			</div>
		<?php } ?>
	</div>
</div>