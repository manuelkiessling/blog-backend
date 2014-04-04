<?php get_header(); ?>

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                <div class="post-info">

                    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

                    <div class="timestamp"><?php the_time('F j, Y'); ?></div>
                    <div class="clearboth"><!-- --></div>


                </div>

                <div class="post-content">
          <?php the_excerpt('Read the rest of this entry &raquo;'); ?>
          <a class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">Read full post &raquo;</a>

                    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                </div>

                <div class="clearboth"><!-- --></div>

            </div>

        <?php endwhile; ?>

            <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; OLDER ENTRIES') ?></div>
                <div class="alignright"><?php previous_posts_link('NEWER ENTRIES &raquo;') ?></div>
                <div class="clearboth"><!-- --></div>
            </div>

    <?php else : ?>

        <div class="post">

            <div class="post-info">

                <h1>Not Found</h1>

            </div>

            <div class="post-content">
                <p>Sorry, but you are looking for something that isn't here.</p>

                <?php get_search_form(); ?>
            </div>

            <div class="clearboth"><!-- --></div>

        </div>

    <?php endif; ?>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>
