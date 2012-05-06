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

          <br/>

          <?php
          $hn_title = get_the_title();
          if (strlen($hn_title) > 79) {
            $hn_title = substr($hn_title, 0, 76).'...';
          }   
          ?>  
          <a href="http://news.ycombinator.com/submit" class="hn-share-button" data-title="<?php echo $hn_title; ?>" data-url="http://manuel.kiessling.net<?php echo substr($_SERVER['REQUEST_URI'], 10); ?>">Vote on HN</a>
          <script>
            (function(d, t) {
              var g = d.createElement(t),
                  s = d.getElementsByTagName(t)[0];
              g.src = '//hnbutton.appspot.com/static/hn.js';
              s.parentNode.insertBefore(g, s);
            }(document, 'script'));
          </script>
       </div>

        <div class="clearboth"><!-- --></div>

			</div>


			<div class="post-content single">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

        <?php
          $showNodebundleAd = (bool)get_post_meta(get_the_ID(), "nodebundle_ad", $single);
          if ($showNodebundleAd) {
            ?>
            <div id="nodebundle-ad">
                <div class="buy-the-bundle">
                  <div class="headline">
                    Interested in getting started with Node.js?
                  </div>
                  <div class="cover">
                    <p>
                      The perfect introduction plus the perfect reference in one bundle!
                    </p>
                    <a href="http://www.nodebeginner.org/buy-bundle/index.html"><img src="http://www.nodebeginner.org/the_node_beginner_book_cover_small.png" height="86" width="57"></a>
                    <a href="http://www.nodebeginner.org/buy-bundle/index.html"><img src="http://www.nodebeginner.org/hands-on_node.js_cover.png" height="86" width="57"></a>
                  </div>
                  <div class="description">
                    <p>
                      LeanBundle currently offers my
                      <br>
                      <strong>Node Beginner Book</strong>
                      <br>
                      plus Pedro Teixeira's excellent
                      <br>
                      <strong>Hands-on Node.js</strong> for only
                      <br>
                      <br>
                      <strong class="price dollarsign">$</strong><strong class="price">14.99</strong>
                      <br>
                      (regular price <del>$21.98</del>)
                    </p>
                  </div>
                  <div class="buy">
                    <p>
                      226 pages in total
                      <br>
                      PDF, ePub &amp; MOBI
                      <br>
                      Direct download
                      <br>
                      Free updates
                    </p>
                    <a class="buttonlink" href="http://www.nodebeginner.org/buy-bundle/index.html">
                      <div class="button">Buy this<br>bundle now</div>
                    </a>
                  </div>
                </div>
                <div class="praise">
                  <em>"This is an amazing introduction to Node."</em> - Ryan Dahl, creator of Node.js, about
                  <em>The Node Beginner Book</em>
                </div>
              </div>
            <?php
          }
        ?>

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
