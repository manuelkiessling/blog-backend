<?php get_header(); ?>

    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
			<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("post_type=post&paged=$paged"); ?>
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div class="post">

                    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    
                    <p class="date">
                    	<span class="day"><?php the_time('j'); ?></span>
                    	<span class="month"><?php the_time('M'); ?></span>
			<span class="year"><?php the_time('Y'); ?></span>
                    </p>
                    
                    <?php woo_get_image('image',490,200); ?>

                    <div class="entry">
			<?php the_excerpt(); ?>
			<a class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">Read full post &raquo;</a>
                    </div>

                </div><!-- /.post -->
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            <?php endif; ?>  
                
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

    <div class="more_entries">
      <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
        <div class="fl"><?php next_posts_link(__('&laquo; Previous entries', 'woothemes')) ?></div>
        <div class="fr"><?php previous_posts_link(__('Newer entries &raquo;', 'woothemes')) ?></div>
        <br class="fix" />
      <?php } ?>
    </div>


<?php get_footer(); ?>
