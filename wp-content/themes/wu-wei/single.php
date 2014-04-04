<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="post-info single">
            <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
            <div class="timestamp"><?php the_time('F j, Y'); ?></div>
            <div class="clearboth"><!-- --></div>
        </div>

        <div class="post-content single">
            <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
            <div id="twitterfollow">
                <span class="note">If you would like to be informed on updates to this post, just <a href="https://twitter.com/manuelkiessling">follow @manuelkiessling</a></span>
            </div>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        </div>
        <div class="clearboth"><!-- --></div>
    </div>

    <a name="comments" />
    <?php comments_template(); ?>

<?php endwhile; else: ?>

    <p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
