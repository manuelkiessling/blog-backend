<?php
    require_once get_template_directory()."/BX_functions.php";

    if (!$bito_sidebar && is_page() && get_page_template() != get_template_directory() . '/archives.php') {
        $col_class = ' class="singlecol"';
    } else {
        $col_class = ' class="doublecol"';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=<?php bloginfo('charset'); ?>" http-equiv="Content-Type"/>
        <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
        <title><?php bloginfo('name'); wp_title(); ?></title>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, projection" />
        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
        <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php /*comments_popup_script(520, 550);*/ ?>
        <?php wp_head();?>
    </head>
    <body>
        <div id="container"<?php echo $col_class; ?>>
                        <div id="header">
                            <form id="searchform" action="<?php bloginfo('url'); ?>/" method="get">
                                    <div><input value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
                                    <input type="submit" value="Search" id="searchsubmit" /></div>
                            </form>
                            <div id="headerimg">
                                <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
                                <div class="description"><?php bloginfo('description'); ?></div>
                            </div>
                        </div>
                        <div id="navigation">
                            <ul>
                                <li<?php if (is_front_page()) echo ' id="current" class="selected"'; ?>><a href="<?php bloginfo('url'); ?>" title="Home"><?php _e('Home'); ?></a></li>
            <?php
                $param_parent = $bito_navigation_show_subpages ? '' : '&parent=0';
                if ($bito_navigation_location == 'Sidebar') {
                    $include_pages = array('about', 'archives');
                    $param_include = '&include=';
                    foreach ($include_pages as $page) {
                        $include_page = get_page_by_path($page);
                        if ($include_page != NULL) {
                            if ($include_page->ID != get_option('page_on_front')) {
                                $param_include .= $include_page->ID . ',';
                            }
                        }
                    }
                    $param_include = rtrim($param_include, ',');
                }
                if ($param_include != '&include=') {
                    $pages = get_pages('sort_column=menu_order' . $param_parent . $param_include . '&exclude=' . get_option('page_on_front'));
                    foreach ($pages as $page) {
                        switch ($page->post_name) {
                            case 'archives':
                                (is_page($page->ID) || is_archive() || is_search() || is_single())?$selected = ' id="current" class="selected"':$selected='';
                                echo '<li', $selected, '><a href="', get_page_link($page->ID), '">', __('Archives'), '</a></li>', "\n";
                                break;
                            case 'about':
                                (is_page($page->ID))?$selected = ' id="current" class="selected"':$selected='';
                                echo '<li', $selected, '><a href="', get_page_link($page->ID),'">', __('About'), '</a></li>', "\n";
                                break;
                            default:
                                (is_page($page->ID))?$selected = ' id="current" class="selected"':$selected='';
                                echo '<li', $selected, '><a href="', get_page_link($page->ID), '">', $page->post_title, '</a></li>', "\n";
                        }
                    }
                }

            ?>
                            </ul>

                        </div>
                    <div id="navigationline">&nbsp;</div>

