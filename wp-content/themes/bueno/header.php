<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>

<link href="http://fonts.googleapis.com/css?family=Cantarell" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('woo_feedburner_url') <> "" ) { echo get_option('woo_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
   
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie6.css" />
    <![endif]-->	
	
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie7.css" />
	<![endif]-->
   
<?php // wp_head(); ?>

<link href="/wordpress/wp-content/themes/bueno/styles/grey.css" rel="stylesheet" type="text/css" />
<link href="/wordpress/wp-content/themes/bueno/custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#logo img { display:none; }
#logo .site-title, #logo .site-description { display:block; } 
</style>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2127388-5']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body>

<div id="container">

	<div id="navigation">
	
		<div class="col-full">
			<?php
			if ( function_exists('has_nav_menu') && has_nav_menu('secondary-menu') ) {
				wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'catnav', 'menu_class' => 'nav fl', 'theme_location' => 'secondary-menu' ) );
			} else {
			?>
	        <ul id="catnav" class="nav fl">
	        	<?php 
                if ( get_option('woo_custom_nav_menu') == 'true' ) {
                    if ( function_exists('woo_custom_navigation_output') )
                        woo_custom_navigation_output('name=Woo Menu 2');
    
                } else { ?>
			<li><div style="height: 42px;">&nbsp;</div></li>
	            <?php // wp_list_categories('sort_column=menu_order&depth=3&title_li=&exclude='.get_option('woo_nav_exclude')); ?>
	            <?php } ?>
	        </ul><!-- /#nav -->
	        <?php } ?> <!--
	        <div id="topsearch" class="fr">
	   			<form method="get" id="searchform_top" action="<?php bloginfo('url'); ?>">
        			<input type="text" class="field" name="s" value="<?php _e('Search...', 'woothemes') ?>" onfocus="if (this.value == '<?php _e('Search...', 'woothemes') ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...', 'woothemes') ?>';}" />
       				<input type="submit" class="submit" name="submit" value="<?php _e('Search', 'woothemes'); ?>" />
 		  		</form>
 		  	</div>-->
        </div><!-- /.col-full -->
        
	</div><!-- /#navigation -->
        
	<div id="header" class="col-full">
   
		<div id="logo" class="fl">
	       
	      	<?php if(is_single() || is_page()) : ?>
	      		<span class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span>
	      	<?php else: ?>
	      		<h1 class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	      	<?php endif; ?>
	      	
	      		<span class="site-description"><?php bloginfo('description'); ?></span>
	      	
		</div><!-- /#logo -->
	       
	   	<div id="pagenav" class="nav fr">
			<?php
			if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
				wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => 'ul', 'theme_location' => 'primary-menu' ) );
			} else {
			?>
	   		<ul>
	   			<?php 
                if ( get_option('woo_custom_nav_menu') == 'true' ) {
                    if ( function_exists('woo_custom_navigation_output') )
                        woo_custom_navigation_output('name=Woo Menu 1');
    
                } else { ?>
	   			<?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
	            <li class="b <?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>"><?php _e('Home', 'woothemes') ?></a></li>
		    	<?php wp_list_pages('sort_column=menu_order&depth=3&title_li=&exclude='.get_option('woo_nav_exclude')); ?>
		    	<?php } ?>
		    	<li class="rss"><a href="<?php if ( get_option('woo_feedburner_url') <> "" ) { echo get_option('woo_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>"><?php _e('RSS', 'woothemes') ?></a></li>
	    	</ul>
	    	<?php } ?>
	    </div><!-- /#pagenav -->
       
	</div><!-- /#header -->
