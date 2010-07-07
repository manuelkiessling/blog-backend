<?php get_header(); ?>

	<div id="content" class="column">

		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h2 class="pagetitle"><a href="<?php the_permalink() ?>" title="Permalink"><?php the_title(); ?></a></h2>
					<div  class="titleinfo"><?php the_time('l, F jS, Y') ?> @ <?php the_time() ?><!-- by <?php the_author() ?>--></div>
					<div class="entry single">
						<?php the_content();?>
						<?php wp_link_pages('before=<p class="page-links">&after=</p>'); ?>
					</div>
					<p class="info">
						<?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
					</p>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<h2><?php _e('Page not found'); ?></h2>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

		<?php comments_template(); ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
