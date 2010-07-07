<?php
    global $options;
    foreach ($options as $value) {
        if (get_settings( $value['id'] ) === FALSE) {
            global $$value['id'];
            $$value['id'] = $value['std'];
        } else {
            global $$value['id'];
            $$value['id'] = get_settings( $value['id'] );
        }
    }
?>

<?php
/**
 * Function BX_archive
 * ------------------------------------------------------
 * This function is based on WP's built-in get_archives()
 * It outputs the following:
 *
 * <table>
 * <tr>
 *     <th></th>
 *     <th>Jan</th>
 *     [..]
 * </tr>
 * <tr>
 *     <th><a href="link">year</a></td>
 *     <td><a href="link">month post count</a></td>
 *     [..]
 * </tr>
 * [..]
 * </table>
 */

function BX_archive()
{
    global $month, $wpdb;
    $arcresults = $wpdb->get_results('SELECT DISTINCT YEAR(post_date) AS year FROM ' 
        .$wpdb->posts 
        ." WHERE post_status='publish' AND post_type='post' AND post_password='' "
        ."ORDER BY post_date DESC ");

    if ($arcresults) {
        echo '<table width="100%">', "\n";
        echo '<tr>', "\n";
        echo '<td>&nbsp;</td>',"\n";
        echo '<th>Jan.</th>',"\n";
        echo '<th>Feb.</th>',"\n";
        echo '<th>Mar.</th>',"\n";
        echo '<th>Apr.</th>',"\n";
        echo '<th>May.</th>',"\n";
        echo '<th>Jun.</th>',"\n";
        echo '<th>Jul.</th>',"\n";
        echo '<th>Aug.</th>',"\n";
        echo '<th>Sep.</th>',"\n";
        echo '<th>Oct.</th>',"\n";
        echo '<th>Nov.</th>',"\n";
        echo '<th>Dec.</th>',"\n";
        echo '</tr>', "\n";
        foreach ($arcresults as $arcresult) {
            echo '<tr>', "\n";
            $yearurl  = get_year_link($arcresult->year);
            $tdArray = array ("<th>" . get_archives_link($yearurl, $arcresult->year, '') . "</th>") ;
            for ($n=1;$n<13;$n++) {
                $tdArray[]= '<td align="center">&nbsp;</td>';
            }
            $arcresults2 = $wpdb->get_results('SELECT DISTINCT MONTH(post_date) AS month, count(ID) as monthposts FROM ' 
                    .$wpdb->posts 
                    ." WHERE YEAR(post_date)='$arcresult->year' AND post_status='publish' AND post_type='post' AND post_password='' "
                    ."GROUP BY MONTH(post_date) ORDER BY post_date DESC");
            foreach ($arcresults2 as $arcresult2) {
                $monthurl  = get_month_link($arcresult->year, $arcresult2->month);
                $tdArray[$arcresult2->month]='<td align="center">'. get_archives_link($monthurl, $arcresult2->monthposts, '') . '</td>';

            }
            for ($n=0;$n<13;$n++) {
                echo $tdArray[$n],"\n";
            }
            echo '</tr>', "\n";
        }
        echo '</table>', "\n";
    }
}


/**
 * Function BX_excluded_pages()
 * ------------------------------------------------
 * Returns the Bito default pages that are excluded
 * from the navigation in the sidebar
 */

function BX_excluded_pages()
{
    $page_paths = array('archives', 'about');
    foreach ($page_paths as $page_path) {
        $page = get_page_by_path($page_path);
        if ($page) $exclude .= $page->ID . ',';
    }
    return rtrim($exclude, ',');
}


/**
 * Function BX_remove_p
 * ---------------------------------------------------
 * Removes the opening <p> and closing </p> from $text
 * Used for the short about text on the front page
 */

function BX_remove_p($text)
{
    $text = apply_filters('the_content', $text);
    $text = preg_replace("/^[\t|\n]?<p>(.*)/","\\1",$text); // opening <p>
    $text = preg_replace("/(.*)<\/p>[\t|\n]$/","\\1",$text); // closing </p>
    return $text;
}

?>
