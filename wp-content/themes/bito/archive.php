<?php get_header(); ?>

            <div id="content" class="archivecolumn">

<?php if (have_posts()) : ?>

                <?php /* If this is a category archive */ if (is_category()) { ?>
                <h2 class="archivetitle"><?php _e('Filed under:'); echo ' ', single_cat_title(); ?></h2>

                <?php /* If this is a tag archive */ } elseif (function_exists('is_tag') && is_tag()) { ?>
                <h2 class="archivetitle"><?php _e('Tag'); echo ': ', single_tag_title(); ?></h2>

                <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                <h2 class="archivetitle"><?php _e('Archives'); ?> &ndash; <?php the_time(__('F j, Y')); ?></h2>

                <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                <h2 class="archivetitle"><?php _e('Archives'); ?> &ndash; <?php the_time('F, Y'); ?></h2>

                <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                <h2 class="archivetitle"><?php _e('Archives'); ?> &ndash <?php the_time('Y'); ?></h2>

                <?php /* If this is a search */ } elseif (is_search()) { ?>
                <h2 class="archivetitle"><?php _e('Search Results'); ?></h2>

                <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                <h2 class="archivetitle"><?php _e('Archives'); ?> &ndash; <?php _e('Author'); ?></h2>

                <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <h2 class="archivetitle"><?php _e('Archives'); ?></h2>

                <?php } ?>

    <?php while (have_posts()) : the_post(); ?>

                <h2 class="pagetitle"><a href="<?php the_permalink() ?>" title="Permalink"><?php the_title(); ?></a></h2>
                <small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
                <div class="entry">
                    <?php ($post->post_excerpt != '') ? the_excerpt() : the_content(); ?>
                    <?php if ($post->post_excerpt != '') { ?><a href="<?php the_permalink() ?>" class="more"><?php _e('Read more...'); ?></a><?php } ?>
                    <?php wp_link_pages('before=<p class="page-links">&after=</p>'); ?>
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

                <h2><?php _e('Page not found'); ?></h2>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>

            </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
