<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<div class="post-info single">

				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

        <div class="timestamp"><?php the_time('F j, Y'); ?></div>

        <div class="clearboth"><!-- --></div>

        <div id="sharing">
        <?php
          $twitter_title = get_the_title();
          if (strlen($twitter_title) > 98) {
            $twitter_title = substr($twitter_title, 0, 95).'...';
          }
          ?>
          <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://manuel.kiessling.net<?php echo substr($_SERVER['REQUEST_URI'], 10); ?>" data-text="<?php echo $twitter_title; ?>" data-via="manuelkiessling">Tweet</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

          <br />

          <g:plusone size="medium" annotation="inline" width="300"></g:plusone>
          <script type="text/javascript">
            (function() {
              var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
              po.src = 'https://apis.google.com/js/plusone.js';
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
          </script>
       </div>

        <div class="clearboth"><!-- --></div>

			</div>


			<div class="post-content single">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
        <div id="twitterfollow">
          <span class="note">If you would like to be informed on updates to this post, just</span>
          <a href="https://twitter.com/manuelkiessling" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @manuelkiessling</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>

			<div class="clearboth"><!-- --></div>

		</div>

	<?php comments_template(); ?>

	<!-- <?php trackback_rdf(); ?> -->

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
