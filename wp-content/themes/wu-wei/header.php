<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('»', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<meta name="description" content="<?php bloginfo('description'); ?>" />

<link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
</head>

<body id="top" class="<?php echo setColourScheme(); ?>">

	<div class="full-column">

		<div class="center-column">

			<ul id="menu">
        <li><a href="<?php echo get_option('home'); ?>/" <?php if(is_home()) {echo 'class="selected"';} ?>><span></span><br />HOME</a></li>
        <li><a href="/wordpress/projects/"><span></span><br />PROJECTS</a></li>
				<li><a href="/wordpress/contact/"><span></span><br />CONTACT</a></li>
				<li><a href="http://photographs.manuel.kiessling.net/"><span></span><br />PHOTOGRAPHS</a></li>
				<li><a href="<?php bloginfo('rss2_url'); ?>"><span></span><br />RSS</a></li>
				<li class="last"><a href="#sidebar"><span></span><br />ABOUT</a></li>
			</ul>

			<div class="clearboth"><!-- --></div>

		</div>

	</div>

<div class="center-column">

	<div id="header">

		<div class="blog-name"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></div>

	</div>
