<?php get_header(); ?>

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <div itemscope itemtype="http://schema.org/BlogPosting" <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                <div class="post-info">

                    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><span itemprop="name"><?php the_title(); ?></span></a></h1>

                    <div itemprop="datePublished" content="<?php the_time('Y-m-d'); ?>" class="timestamp"><?php the_time('F j, Y'); ?></div>
                    <div class="clearboth"><!-- --></div>


                </div>

                <div class="post-content">
                    <span itemProp="description"><?php the_excerpt('Read the rest of this entry &raquo;'); ?></span>
                    <a itemprop="url" class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">Read full post &raquo;</a>

                    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                </div>

                <div class="clearboth"><!-- --></div>

            </div>

        <?php endwhile; ?>

    <?php else : ?>

        <div class="post">

            <div class="post-info">

                <h1>Not Found</h1>

            </div>

            <div class="post-content">
                <p>Sorry, but you are looking for something that isn't here.</p>
            </div>

            <div class="clearboth"><!-- --></div>

        </div>

    <?php endif; ?>

<?php get_footer(); ?>
