			<div id="footer">
				<p>
<?php
	$locale = get_locale();
	if (!$locale || $locale == 'en_US') {
?>
					<strong>&copy; Copyright <?php echo date('Y'), ' '; bloginfo('name'); ?>. All rights reserved.</strong><br />
<?php } ?>
					<a href="http://blogs.gaixie.org/tommy/"><strong>Bito</strong></a> theme.  <?php echo sprintf(__("Powered by <a href='http://wordpress.org/' title='%s'><strong>WordPress</strong></a>"), __('Powered by WordPress, state-of-the-art semantic personal publishing platform.')); ?> <?php bloginfo('version'); ?>, valid 

<a href="http://validator.w3.org/check?uri=referer">XHTML 1.1</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS 3</a>. <?php wp_loginout(); ?>
				</p>

<?php do_action('wp_footer'); ?>

			</div>
			<div class="clear"> </div>
		</div>
	</body>
</html>
