<?php
/*
Template Name: archives
*/
?>

<?php get_header(); ?>

            <div id="content" class="archivecolumn">
                <h2 class="archivetitle"><?php _e('Archives'); ?></h2>
                <?php BX_archive(); ?>
            </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
