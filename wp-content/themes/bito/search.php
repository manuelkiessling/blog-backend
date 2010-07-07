<?php get_header(); ?>

            <div id="content" class="archivecolumn">

<?php if (have_posts()) : ?>

                <h2 class="archivetitle"><?php printf(__('Search results for &#8220;%s&#8221;'), $s); ?></h2>

    <?php while (have_posts()) : the_post(); ?>

                <h3 class="pagetitle"><a href="<?php the_permalink() ?>" title="Permalink"><?php the_title(); ?></a></h3>
           		<small><?php the_time('F jS, Y') ?> by <?php the_author() ?> </small>
                <div class="entry">
					<?php ($post->post_excerpt != '') ? the_excerpt() : the_content(); ?>
					<?php if ($post->post_excerpt != '') { ?><a href="<?php the_permalink() ?>" class="more"><?php _e('Read more...'); ?></a><?php } ?>
                </div>
		        <p class="info">
					<?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
		        </p>
    <?php endwhile; ?>

                <p>
                    <span class="next"><?php previous_posts_link(__('Next page')) ?></span>
                    <span class="previous"><?php next_posts_link(__('Previous page')) ?></span>
                </p>

<?php else : ?>

                <h2 class="archivetitle"><?php printf(__('Search results for &#8220;%s&#8221;'), $s); ?></em></h2>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
