<?php get_header(); ?>
<div class="mh-wrapper clearfix">
	<div id="main-content" class="mh-content">
		<?php mh_edition_lite_page_title(); ?>
		<div class="entry-content mh-widget">
			<div class="box">
				<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mh-edition-lite'); ?></p>
			</div>
			<h4 class="mh-widget-title">
				<?php _e('Search', 'mh-edition-lite'); ?>
			</h4>
			<?php get_search_form(); ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>