	<div id="extended-footer" style="visibility: hidden;">
	
		<div class="col-full">
	
			<div class="block one">
				
				<?php dynamic_sidebar('footer-1'); ?>
				
			</div><!-- /.block -->
			
			<div class="block two">
			
				<?php dynamic_sidebar('footer-2'); ?>
			
			</div><!-- /.block -->
			
			<div class="block three">
				
				<?php dynamic_sidebar('footer-3'); ?>
			
			</div><!-- /.block -->
			
		</div><!-- /.col-full -->
		
	</div><!-- /#extended-footer -->
	
	<div id="footer">
	
		<div class="col-full">
	
			<div id="copyright" class="col-left">
				<p>&copy; <?php echo date('Y'); ?> Manuel Kiessling. <?php _e('All Rights Reserved.', 'woothemes') ?></p>
			</div>
		</div><!-- /.col-full -->
		
	</div><!-- /#footer -->
	
</div><!-- /#container -->
<?php wp_footer(); ?>

<script type="text/javascript">
var disqus_shortname = 'thelogbookofmanuelkiessling';
(function () {
  var s = document.createElement('script'); s.async = true;
  s.src = 'http://disqus.com/forums/thelogbookofmanuelkiessling/count.js';
  (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>

</body>
</html>
