<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Custom fields for WP write panel - woothemes_metabox_create
- woothemes_uploader_custom_fields
- woothemes_metabox_handle
- woothemes_metabox_add
- woothemes_metabox_header

-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/
/*-----------------------------------------------------------------------------------*/

function woothemes_metabox_create() {
    global $post;
    $woo_metaboxes = get_option('woo_custom_template');
    
    $seo_metaboxes = get_option('woo_custom_seo_template');  
    
    if(!empty($seo_metaboxes)){
    	$woo_metaboxes = array_merge($woo_metaboxes,$seo_metaboxes);
    }

    $output = '';
    $output .= '<table class="woo_metaboxes_table">'."\n";
    foreach ($woo_metaboxes as $woo_metabox) {
    $woo_id = "woothemes_" . $woo_metabox["name"];
    $woo_name = $woo_metabox["name"];
    if(        
                $woo_metabox['type'] == 'text' 
		OR      $woo_metabox['type'] == 'select' 
		OR      $woo_metabox['type'] == 'checkbox' 
		OR      $woo_metabox['type'] == 'textarea'
		OR      $woo_metabox['type'] == 'calendar'
		OR      $woo_metabox['type'] == 'time'
		OR      $woo_metabox['type'] == 'radio'
		OR      $woo_metabox['type'] == 'images') {
            $woo_metaboxvalue = get_post_meta($post->ID,$woo_name,true);
			}
            
            if (empty($woo_metaboxvalue) && isset($woo_metabox['std'])) {
                $woo_metaboxvalue = $woo_metabox['std'];
            }

            if($woo_metabox['type'] == 'text'){
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="woo_input_text" type="'.$woo_metabox['type'].'" value="'.$woo_metaboxvalue.'" name="'.$woo_name.'" id="'.$woo_id.'"/>';
                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($woo_metabox['type'] == 'textarea'){
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_metabox.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><textarea class="woo_input_textarea" name="'.$woo_name.'" id="'.$woo_id.'">' . $woo_metaboxvalue . '</textarea>';
                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($woo_metabox['type'] == 'calendar'){
            	
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_metabox.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="woo_input_calendar" type="text" name="'.$woo_name.'" id="'.$woo_id.'" value="'.$woo_metaboxvalue.'">';
                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($woo_metabox['type'] == 'time'){
            	
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="woo_input_time" type="'.$woo_metabox['type'].'" value="'.$woo_metaboxvalue.'" name="'.$woo_name.'" id="'.$woo_id.'"/>';
                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n"; 
                              
            }

            elseif ($woo_metabox['type'] == 'select'){
                       
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><select class="woo_input_select" id="'.$woo_id.'" name="'. $woo_name .'">';
                $output .= '<option value="">Select to return to default</option>';
                
                $array = $woo_metabox['options'];
                
                if($array){
                
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                       
                        if(isset($woo_metabox['default']))  {                            
							if($woo_metabox['default'] == $option && empty($woo_metaboxvalue)){$selected = 'selected="selected"';} 
							else  {$selected = '';}
						}
                        
                        if($woo_metaboxvalue == $option){$selected = 'selected="selected"';}
                        else  {$selected = '';}  
                        
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                
                $output .= '</select><span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
                $output .= "\t".'</tr>'."\n";
            }
            
            elseif ($woo_metabox['type'] == 'checkbox'){
            
                if($woo_metaboxvalue == 'true') { $checked = ' checked="checked"';} else {$checked='';}

                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input type="checkbox" '.$checked.' class="woo_input_checkbox" value="true"  id="'.$woo_id.'" name="'. $woo_name .'" />';
                $output .= '<span class="woo_metabox_desc" style="display:inline">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
                $output .= "\t".'</tr>'."\n";
            }
            
            elseif ($woo_metabox['type'] == 'radio'){
            
            $array = $woo_metabox['options'];
            
            if($array){
            
            $output .= "\t".'<tr>';
            $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
            $output .= "\t\t".'<td>';
            
                foreach ( $array as $id => $option ) {

                    if($woo_metaboxvalue == $id) { $checked = ' checked';} else {$checked='';}

                        $output .= '<input type="radio" '.$checked.' value="' . $id . '" class="woo_input_radio"  name="'. $woo_name .'" />';
                        $output .= '<span class="woo_input_radio_desc" style="display:inline">'. $option .'</span><div class="woo_spacer"></div>';
                    }
                    $output .=  '</td></td><td></td>'."\n";
                    $output .= "\t".'</tr>'."\n";    
                 }
            }
			elseif ($woo_metabox['type'] == 'images')
			{
			
			$i = 0;
			$select_value = '';
			$layout = '';

			foreach ($woo_metabox['options'] as $key => $option) 
				 { 
				 $i++;
				 
				 $checked = '';
				 $selected = '';
				 if($woo_metaboxvalue != '') {
				 	if ($woo_metaboxvalue == $key) { $checked = ' checked'; $selected = 'woo-meta-radio-img-selected'; }
				 } 
				 else {
				 	if ($option['std'] == $key) { $checked = ' checked'; } 
					elseif ($i == 1) { $checked = ' checked'; $selected = 'woo-meta-radio-img-selected'; }
					else { $checked=''; }
					
				 }
					
					$layout .= '<div class="woo-meta-radio-img-label">';			
					$layout .= '<input type="radio" id="woo-meta-radio-img-' . $woo_name . $i . '" class="checkbox woo-meta-radio-img-radio" value="'.$key.'" name="'. $woo_name.'" '.$checked.' />';
					$layout .= '&nbsp;' . $key .'<div class="woo_spacer"></div></div>';
					$layout .= '<img src="'.$option.'" alt="" class="woo-meta-radio-img-img '. $selected .'" onClick="document.getElementById(\'woo-meta-radio-img-'. $woo_metabox["name"] . $i.'\').checked = true;" />';
				}
			
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td class="woo_metabox_fields">';
			$output .= $layout;
			$output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
			$output .= '</td>'."\n";
			$output .= "\t".'</tr>'."\n";
						
			}
            
            elseif($woo_metabox['type'] == 'upload')
            {
				if(isset($woo_metabox["default"])) $default = $woo_metabox["default"];
				else $default = '';
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td class="woo_metabox_fields">'. woothemes_uploader_custom_fields($post->ID,$woo_name,$default,$woo_metabox["desc"]);
                $output .= '</td>'."\n";
                $output .= "\t".'</tr>'."\n";
                
            }
        }
    
    $output .= '</table>'."\n\n";
    echo $output;
}



/*-----------------------------------------------------------------------------------*/
// woothemes_uploader_custom_fields
/*-----------------------------------------------------------------------------------*/

function woothemes_uploader_custom_fields($pID,$id,$std,$desc){

    // Start Uploader
    $upload = get_post_meta( $pID, $id, true);
	$href = cleanSource($upload);
	$uploader = '';
    $uploader .= '<input class="woo_input_text" name="'.$id.'" type="text" value="'.$upload.'" />';
    $uploader .= '<div class="clear"></div>'."\n";
    $uploader .= '<input type="file" name="attachement_'.$id.'" />';
    $uploader .= '<input type="submit" class="button button-highlighted" value="Save" name="save"/>';
    if ( $href ) 
		$uploader .= '<span class="woo_metabox_desc">'.$desc.'</span></td>'."\n".'<td class="woo_metabox_image"><a href="'. $upload .'"><img src="'.get_bloginfo('template_url').'/thumb.php?src='.$href.'&w=150&h=80&zc=1" alt="" /></a>';

return $uploader;
}



/*-----------------------------------------------------------------------------------*/
// woothemes_metabox_handle
/*-----------------------------------------------------------------------------------*/

function woothemes_metabox_handle(){   
    
    global $globals;
    $woo_metaboxes = get_option('woo_custom_template');  
    
    $seo_metaboxes = get_option('woo_custom_seo_template');  
    
    if(!empty($seo_metaboxes)){
    	$woo_metaboxes = array_merge($woo_metaboxes,$seo_metaboxes);
    }
       
    if(isset($_POST['post_ID']))
		$pID = $_POST['post_ID'];
    $upload_tracking = array();
	
    
    if (isset($_POST['action']) && $_POST['action'] == 'editpost'){                                   
        foreach ($woo_metaboxes as $woo_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
            if($woo_metabox['type'] == 'text' 
			OR $woo_metabox['type'] == 'calendar' 
			OR $woo_metabox['type'] == 'time'
			OR $woo_metabox['type'] == 'select' 
			OR $woo_metabox['type'] == 'radio'
			OR $woo_metabox['type'] == 'checkbox' 
			OR $woo_metabox['type'] == 'textarea' 
			OR $woo_metabox['type'] == 'images' ) // Normal Type Things...
                {
                    $var = $woo_metabox["name"];
                    if (isset($_POST[$var])) {            
                        if( get_post_meta( $pID, $var ) == "" )
                            add_post_meta($pID, $var, $_POST[$var], true );
                        elseif($_POST[$var] != get_post_meta($pID, $var, true))
                            update_post_meta($pID, $var, $_POST[$var]);
                        elseif($_POST[$var] == "") {
                           delete_post_meta($pID, $var, get_post_meta($pID, $var, true));
                        }
                    }
                    elseif(!isset($_POST[$var]) && $woo_metabox['type'] == 'checkbox') { 
                        update_post_meta($pID, $var, 'false'); 
                    }      
                    else {
                          delete_post_meta($pID, $var, get_post_meta($pID, $var, true)); // Deletes check boxes OR no $_POST
                    }    
                }
          
            elseif($woo_metabox['type'] == 'upload') // So, the upload inputs will do this rather
                {
                $id = $woo_metabox['name'];
                $override['action'] = 'editpost';
                
                    if(!empty($_FILES['attachement_'.$id]['name'])){ //New upload
                    $_FILES['attachement_'.$id]['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $_FILES['attachement_'.$id]['name']); 
                           $uploaded_file = wp_handle_upload($_FILES['attachement_' . $id ],$override); 
                           $uploaded_file['option_name']  = $woo_metabox['label'];
                           $upload_tracking[] = $uploaded_file;
                           update_post_meta($pID, $id, $uploaded_file['url']);
                    }
                    elseif(empty( $_FILES['attachement_'.$id]['name']) && isset($_POST[ $id ])){
                        update_post_meta($pID, $id, $_POST[ $id ]); 
                    }
                    elseif($_POST[ $id ] == '')  { delete_post_meta($pID, $id, get_post_meta($pID, $id, true));
                    }
                }
               // Error Tracking - File upload was not an Image
               update_option('woo_custom_upload_tracking', $upload_tracking);
            }
            
        }
}



/*-----------------------------------------------------------------------------------*/
// woothemes_metabox_add
/*-----------------------------------------------------------------------------------*/

function woothemes_metabox_add() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box('woothemes-settings',get_option('woo_themename').' Custom Settings','woothemes_metabox_create','post','normal');
        add_meta_box('woothemes-settings',get_option('woo_themename').' Custom Settings','woothemes_metabox_create','page','normal');
    }
}



/*-----------------------------------------------------------------------------------*/
// woothemes_metabox_header
/*-----------------------------------------------------------------------------------*/

function woothemes_metabox_header(){
?>
<script type="text/javascript">

    jQuery(document).ready(function(){
		
        jQuery('form#post').attr('enctype','multipart/form-data');
        jQuery('form#post').attr('encoding','multipart/form-data');
        
         //JQUERY DATEPICKER
		jQuery('.woo_input_calendar').each(function (){
			jQuery('#' + jQuery(this).attr('id')).datepicker({showOn: 'button', buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', buttonImageOnly: true});
		});
		
		//JQUERY TIME INPUT MASK
		jQuery('.woo_input_time').each(function (){
			jQuery('#' + jQuery(this).attr('id')).mask("99:99");
		});
		
        jQuery('.woo_metaboxes_table th:last, .woo_metaboxes_table td:last').css('border','0');
        var val = jQuery('input#title').attr('value');
        if(val == ''){ 
        jQuery('.woo_metabox_fields .button-highlighted').after("<em class='woo_red_note'>Please add a Title before uploading a file</em>");
        };
		jQuery('.woo-meta-radio-img-img').click(function(){
				jQuery(this).parent().find('.woo-meta-radio-img-img').removeClass('woo-meta-radio-img-selected');
				jQuery(this).addClass('woo-meta-radio-img-selected');
				
			});
			jQuery('.woo-meta-radio-img-label').hide();
			jQuery('.woo-meta-radio-img-img').show();
			jQuery('.woo-meta-radio-img-radio').hide();
        <?php //Errors
        $error_occurred = false;
        $upload_tracking = get_option('woo_custom_upload_tracking');
        if(!empty($upload_tracking)){
        $output = '<div style="clear:both;height:20px;"></div><div class="errors"><ul>' . "\n";
            $error_shown == false;
            foreach($upload_tracking as $array )
            {
                 if(array_key_exists('error', $array)){
                        $error_occurred = true;
                        ?>
                        jQuery('form#post').before('<div class="updated fade"><p>WooThemes Upload Error: <strong><?php echo $array['option_name'] ?></strong> - <?php echo $array['error'] ?></p></div>');
                        <?php
                }
            }
        }
		
        delete_option('woo_upload_custom_errors');
        ?>
    });

</script>
<style type="text/css">
.woo_input_text { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:80%; font-size:11px; padding: 5px;}
.woo_input_select { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:60%; font-size:11px; padding: 5px;}
.woo_input_checkbox { margin:0 10px 0 0; }
.woo_input_radio { margin:0 10px 0 0; }
.woo_input_radio_desc { font-size: 12px; color: #666 ; }
.woo_spacer { display: block; height:5px}
.woo_metabox_desc { font-size:10px; color:#aaa; display:block}
.woo_metaboxes_table{ border-collapse:collapse; width:100%}
.woo_metaboxes_table tr:hover th,
.woo_metaboxes_table tr:hover td { background:#f8f8f8}
.woo_metaboxes_table th,
.woo_metaboxes_table td{ border-bottom:1px solid #ddd; padding:10px 10px;text-align: left; vertical-align:top}
.woo_metabox_names { width:20%}
.woo_metabox_fields { width:70%}
.woo_metabox_image { text-align: right;}
.woo_red_note { margin-left: 5px; color: #c77; font-size: 10px;}
.woo_input_textarea { width:80%; height:120px;margin:0 0 10px 0; background:#f0f0f0; color:#444;font-size:11px;padding: 5px;}
.woo-meta-radio-img-img { border:3px solid #fff; margin:0 5px 10px 0; display:none; cursor:pointer;}
.woo-meta-radio-img-selected { border:3px solid #ccc}
.woo-meta-radio-img-label { font-size:12px}
.woo-meta-radio-img-img:hover {opacity:.8; }
</style>
<?php
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/functions/css/jquery-ui-datepicker.css" />';
}


function woo_custom_enqueue($hook) {
  	if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page-new.php' OR $hook == 'page.php') {
		add_action('admin_head', 'woothemes_metabox_header');
		wp_enqueue_script('jquery-ui-core');
		wp_register_script('jquery-ui-datepicker', get_bloginfo('template_directory').'/functions/js/ui.datepicker.js', array( 'jquery-ui-core' ));
		wp_enqueue_script('jquery-ui-datepicker');
		wp_register_script('jquery-input-mask', get_bloginfo('template_directory').'/functions/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
		wp_enqueue_script('jquery-input-mask');
  	}
}

add_action('admin_enqueue_scripts','woo_custom_enqueue',10,1);
add_action('edit_post', 'woothemes_metabox_handle');
add_action('admin_menu', 'woothemes_metabox_add'); // Triggers Woothemes_metabox_create

?>