<?php /* Template for displaying a "No posts found" message */ ?>
<div class="entry-content mh-widget">
<?php if (is_search()) { ?>
	<div class="box">
		<p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'mh-edition-lite'); ?></p>
	</div>
<?php } else { ?>
	<div class="box">
		<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mh-edition-lite'); ?></p>
	</div>
<?php } ?>
<h4 class="mh-widget-title"><?php _e('Search', 'mh-edition-lite'); ?></h4>
<?php get_search_form(); ?>
</div>