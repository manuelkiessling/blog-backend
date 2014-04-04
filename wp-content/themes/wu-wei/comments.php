<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>

		<div id="comment-wrapper">

			<h3 id="comments" id="comment-<?php comment_ID(); ?>">Enter the password to view comments.</h3>

		</div>

	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<div id="comment-wrapper">

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

</div> <!-- end of comment-wrapper -->
