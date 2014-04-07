<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">

            <div class="post-content single">
                    <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

                    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            </div>

            <div class="clearboth"><!-- --></div>

        </div>

        <?php endwhile; endif; ?>

<?php get_footer(); ?>
