<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
		
			<?php if ( get_option( 'woo_breadcrumbs' ) == 'true') { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
            
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
            
                <div class="post">

                    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
                    
                    <p class="date">
                    	<span class="day"><?php the_time('j'); ?></span>
                    	<span class="month"><?php the_time('M'); ?></span>
			<span class="year"><?php the_time('Y'); ?></span>
                    </p>
                    
                    <div class="entry">
			<?php remove_filter ("the_content", "wpautop"); ?>
                    	<?php the_content(); ?>
                    </div>

<!--                    
                    <div class="post-meta">
                    
                    	<ul>
                    		<li class="comments">
                    			<span class="head"><?php _e('Comments', 'woothemes') ?></span>
                    			<span class="body"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
                    		</li>
                    		<li class="categories">
                    			<span class="head"><?php _e('Categories', 'woothemes') ?></span>
                    			<span class="body"><?php the_category(', ') ?></span>
                    		</li>
                    		<li class="author">
                    			<span class="head"><?php _e('Author', 'woothemes') ?></span>
                    			<span class="body"><?php the_author_posts_link(); ?></span>
                    		</li>
                    	</ul>
                    	
                    	<div class="fix"></div>
                    
                    </div>
-->

                </div><!-- /.post -->

<div id="disqus_thread"></div>
<script type="text/javascript">
  /**
    * var disqus_identifier='<?php the_permalink() ?>'; [Optional but recommended: Define a unique identifier (e.g. post id or slug) for this thread] 
    */
  (function() {
   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
   dsq.src = 'http://thelogbookofmanuelkiessling.disqus.com/embed.js';
   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
  })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=thelogbookofmanuelkiessling">comments powered by Disqus.</a></noscript>
<!-- <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a> -->
                
				<?php // comments_template('', true); ?>
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
  				</div><!-- /.post -->             
           	<?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<script type="text/javascript">
var disqus_shortname = 'thelogbookofmanuelkiessling';
(function () {
  var s = document.createElement('script'); s.async = true;
  s.src = 'http://disqus.com/forums/thelogbookofmanuelkiessling/count.js';
  (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>

<?php get_footer(); ?>
