<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
		
			<?php if ( get_option( 'woo_breadcrumbs' ) == 'true') { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
            
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
            
                <div class="post">

                    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
                    
                    <div id="socialsharing">
                        <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
                        <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>

                        <g:plusone size="medium" annotation="inline"></g:plusone>
                        <script type="text/javascript">
                            (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/plusone.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                            })();
                        </script>
                    </div>

                    <p class="date">
                    	<span class="day"><?php the_time('j'); ?></span>
                    	<span class="month"><?php the_time('M'); ?></span>
			<span class="year"><?php the_time('Y'); ?></span>
                    </p>
                    
                    <div class="entry">
			<?php remove_filter ("the_content", "wpautop"); ?>
                    	<?php the_content(); ?>
                    </div>

                    <div id="comments">
                     <div id="disqus_thread"></div>
                     <script type="text/javascript">
                      var disqus_shortname = 'thelogbookofmanuelkiessling';
                      var disqus_identifier = '<?php the_id() ?>';
                      var disqus_url = 'http://manuel.kiessling.net<?php the_permalink() ?>';
                      (function() {
                       var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                       dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                       (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                      })();
                     </script>
                     <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                     <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
                    </div>

                </div><!-- /.post -->

				<?php // comments_template('', true); ?>
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
  				</div><!-- /.post -->             
           	<?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>
