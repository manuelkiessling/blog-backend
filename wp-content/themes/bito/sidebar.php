<?php
    global $bito_navigation_location;
?>

    <div id="subcontent" class="column">
    <ul>
<?php
     /**
       * Pages navigation. Disabled by default because all new pages are added
       * to the main navigation.
       * If enabled: Bito default pages are excluded by default.
       */
    if ($bito_navigation_location == 'Sidebar') {
?>
        <li><h2><?php _e('Pages'); ?></h2>
        <ul class="pages">
            <?php wp_list_pages('title_li=&sort_column=menu_order&exclude=' . BX_excluded_pages()); ?>
        </ul></li>
<?php
    }
       /**/
?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

        <li><h2><?php _e('Categories'); ?></h2>
        <ul class="categories">
            <?php wp_list_categories('title_li='); ?> 
        </ul></li>
        <!-- links -->
        <?php wp_list_bookmarks(); ?>
<!--

        <li><h2><?php _e('Pages'); ?></h2>
        <ul class="pages">
        <?php wp_list_pages('title_li=' ); ?>
        </ul></li>

        <li><h2><?php _e('Archives'); ?></h2>
        <ul class="months">
            <?php wp_get_archives('type=monthly'); ?>
        </ul></li>

        <li><h2><?php _e('Calendar'); ?></h2>
        <?php get_calendar() ?></li>

        <li><h2><?php _e('Recent Posts'); ?></h2>
        <ul class="posts">
            <?php wp_get_archives('type=postbypost&limit=10'); ?>
        </ul></li>
-->
        <li><h2><?php _e('Meta'); ?></h2>
        <ul class="feeds">
            <?php wp_register(); ?>
            <li><a title="Syndicate this site using RSS 2.0" href="<?php bloginfo_rss('rss2_url'); ?>"><?php _e('Entries'); ?> <abbr title="Really Simple Syndication"><?php _e('RSS'); ?></abbr></a></li>
            <li><a title="The latest comments to all posts in RSS" href="<?php bloginfo_rss('comments_rss2_url'); ?>"><?php _e('Comments'); ?> <abbr title="Really Simple Syndication"><?php _e('RSS'); ?></abbr></a></li>
        </ul></li>
<!--
        <li><h2><?php _e('Tags'); ?></h2>
        <ul class="tags">
            <?php wp_tag_cloud('smallest=8&largest=18'); ?>
        </ul></li>
-->
<?php endif; ?>
        </ul>
    </div>
