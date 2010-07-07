<?php
/**
 * Woothemes Tumblog Functionality
 *
 * @version 1.2.0
 *
 * @package WooFramework
 * @subpackage Tumblog
 */
 
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Register Actions
-- woo_register_tumblog_dashboard_widget()
-- woo_load_tumblog_libraries()
-- woo_load_tinymce_libraries()
-- woo_load_tumblog_css()
- AJAX Callback Functions
-- woo_tumblog_ajax_post()
-- woo_tumblog_publish()
-- woo_tumblog_file_upload()
- Dashboard Widget
-- woo_tumblog_dashboard_widget_output()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Register Actions
/*-----------------------------------------------------------------------------------*/

//Register Actions
add_action('wp_ajax_woo_tumblog_media_upload', 'woo_tumblog_file_upload');
add_action('wp_ajax_woo_tumblog_post', 'woo_tumblog_ajax_post');
//Load scripts and libraries
//add_filter('admin_head','woo_load_tinymce_libraries');
add_action('init', 'woo_load_tumblog_libraries');
add_action('admin_enqueue_scripts', 'woo_load_tumblog_css',10,1);
// Hook into the 'wp_dashboard_setup' action to register Tumblog Dashboard Widget
add_action('wp_dashboard_setup', 'woo_register_tumblog_dashboard_widget' );

//Adds the Tumblog Dashboard Widget to the WP Dashboard
function woo_register_tumblog_dashboard_widget() {
	wp_add_dashboard_widget('woo_tumblog_dashboard_widget', 'Tumblog', 'woo_tumblog_dashboard_widget_output');	
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;
	// Get the regular dashboard widgets array 
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	// Backup and delete dashboard widget from the end of the array
	$woo_tumblog_widget_backup = array('woo_tumblog_dashboard_widget' => $normal_dashboard['woo_tumblog_dashboard_widget']);
	unset($normal_dashboard['woo_tumblog_dashboard_widget']);
	// Merge the two arrays together so tumblog widget is at the beginning
	$sorted_dashboard = array_merge($woo_tumblog_widget_backup, $normal_dashboard);
	// Save the sorted array back into the original metaboxes 
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 

//Loads Tumblog javascript and php js functions
function woo_load_tumblog_libraries() {
	wp_enqueue_script('newscript', get_bloginfo('template_directory').'/functions/js/tumblog-ajax.js', array('jquery', 'jquery-form'));
	wp_enqueue_script('nicedit', get_bloginfo('template_directory').'/functions/js/nicEdit.js');
 	wp_enqueue_script('phpjs', get_bloginfo('template_directory').'/functions/js/php.js');
}    

//TinyMCE scripts and libraries for Dashboard Widget Editor
function woo_load_tinymce_libraries() {
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');		
}

//Load Tumblog CSS
function woo_load_tumblog_css($hook) {
	if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page-new.php' OR $hook == 'page.php') {
	}
	else {
		echo "<link rel='stylesheet' id='colors-tabs' href='".get_bloginfo('template_directory')."/functions/css/tumblog.css' type='text/css' media='all' />";
	}   
    
}

/*-----------------------------------------------------------------------------------*/
/* AJAX Callback Functions
/*-----------------------------------------------------------------------------------*/

//Handles AJAX Form Post from Woo QuickPress
function woo_tumblog_ajax_post() {
	//Publish Article							
	if ($_POST['tumblog-type'] == 'article') 
	{
		$data = $_POST;
		$type = 'note';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Video
	elseif ($_POST['tumblog-type'] == 'video') 
	{
		$data = $_POST;
		$type = 'video';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Image
	elseif ($_POST['tumblog-type'] == 'image') 
	{
		$data = $_POST;
		$type = 'image';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Link
	elseif ($_POST['tumblog-type'] == 'link') 
	{
		$data = $_POST;
		$type = 'link';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Quote
	elseif ($_POST['tumblog-type'] == 'quote') 
	{
		$data = $_POST;
		$type = 'quote';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Audio
	elseif ($_POST['tumblog-type'] == 'audio') 
	{
		$data = $_POST;	
		$type = 'audio';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Chat
	elseif ($_POST['tumblog-type'] == 'chat') 
	{
		$data = $_POST;
		$type = 'chat';	
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Default
	else {
		die ( 'OK' );
	}
}

//Publishes the Tumblog Item
function woo_tumblog_publish($type, $data) {
	global $current_user;
    //Gets the current user's info
    get_currentuserinfo();
    //Set custom fields
	$tumblog_custom_fields = array(	'video-embed' => 'video-embed',
								'quote-copy' => 'quote-copy',
								'quote-author' => 'quote-author',
								'quote-url' => 'quote-url',
								'link-url' => 'link-url',
								'image-url' => 'image',
								'audio-url' => 'audio'
								);
	//Handle Tumblog Types
	switch ($type) 
	{
    	case 'note':
        	//Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['note-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_articles_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
        	break;
    	case 'video':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['video-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_videos_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
  			//Add Custom Field Data to the Post
    	    add_post_meta($post_id, $tumblog_custom_fields['video-embed'], $data['video-embed'], true);
    	    break;
    	case 'image':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['image-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_images_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
			//Add Custom Field Data to the Post  	        	    
    	    if ($data['image-id'] > 0) {
    	    	$my_post = array();
    	    	$my_post['ID'] = $data['image-id'];
	 		 	$my_post['post_parent'] = $post_id;
				//Update the post into the database
  				wp_update_post( $my_post );
  				add_post_meta($post_id, $tumblog_custom_fields['image-url'], $data['image-upload'], true);
    	    }
    	    else {
    	    	add_post_meta($post_id, $tumblog_custom_fields['image-url'], $data['image-url'], true);
    	    }  	    
    	    break;
    	case 'link':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['link-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_links_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
  			//Add Custom Field Data to the Post
  			add_post_meta($post_id, $tumblog_custom_fields['link-url'], $data['link-url'], true);
    	    break;
    	case 'quote':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['quote-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_quotes_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
    	    //Add Custom Field Data to the Post
    	    add_post_meta($post_id, $tumblog_custom_fields['quote-copy'], $data['quote-copy'], true);
    	    add_post_meta($post_id, $tumblog_custom_fields['quote-author'], $data['quote-author'], true);
    	    add_post_meta($post_id, $tumblog_custom_fields['quote-url'], $data['quote-url'], true);
    	    break;
    	case 'audio':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['audio-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_audio_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
    	    //Add Custom Field Data to the Post
    	    if ($data['audio-id'] > 0) {
    	    	$my_post = array();
    	    	$my_post['ID'] = $data['audio-id'];
	 		 	$my_post['post_parent'] = $post_id;
				//Update the post into the database
  				wp_update_post( $my_post );
  				add_post_meta($post_id, $tumblog_custom_fields['audio-url'], $data['audio-upload'], true);
    	    }
    	    else {
    	    	add_post_meta($post_id, $tumblog_custom_fields['audio-url'], $data['audio-url'], true);
    	    }
    	    break;
    	case 'chat':
    	    //Create post object
  			$tumbl_note = array();
  			$tumbl_note['post_title'] = $data['chat-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			$tumbl_note['post_status'] = 'publish';
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			$category_id = get_cat_ID( get_option('woo_chat_category') );
  			$tumbl_note['post_category'] = array($category_id);
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
    	    break;
    	default:
    		break;
	}
}

//Handles AJAX Post
function woo_tumblog_file_upload() {
	global $wpdb; 
	//Upload overrides
	$filename = $_FILES['userfile']; // [name] [tmp_name]
	$override['test_form'] = false;
	$override['action'] = 'wp_handle_upload';    
	//Handle Uploaded File	
	$uploaded_file = wp_handle_upload($filename, $override); // [file] [url] [type]
	//Create Attachment Object	
	$attachment['post_title'] = $filename['name']; //post_title, post_content (the value for this key should be the empty string), post_status and post_mime_type
	$attachment['post_content'] = '';
	$attachment['post_status'] = 'inherit';
	$attachment['post_mime_type'] = $uploaded_file['type'];
	$attachment['guid'] = $uploaded_file['url'];
	//Prepare file attachment
	$wud = wp_upload_dir(); // [path] [url] [subdir] [basedir] [baseurl] [error] 
	$filename_attach = $wud['basedir'].$uploaded_file['file'];
	//Insert Attachment
	$attach_id = wp_insert_attachment( $attachment, $filename_attach, 0 );
  	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename_attach );
  	wp_update_attachment_metadata( $attach_id,  $attach_data );
	//Handle Errors and Response
	if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
	else { echo $uploaded_file['url'].'|'.$attach_id.'|'; } // Is the Response
}

/*-----------------------------------------------------------------------------------*/
/* Dashboard Widget
/*-----------------------------------------------------------------------------------*/

// Tumblog Dashboard Widget Output
function woo_tumblog_dashboard_widget_output() {
	?>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/ajaxupload.js"></script>
	<script type="text/javascript">
	//No Conflict Mode
	jQuery.noConflict();
	//AJAX Functions
	jQuery(document).ready(function(){
		
		//MENU BUTTON CLICK EVENTS
		jQuery('#articles-menu-button').click(function ()
		{
			jQuery('#article-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','article');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#note-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');		
		});
		jQuery('#images-menu-button').click(function ()
		{
			jQuery('#image-fields').removeAttr('class');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','image');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#image-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		jQuery('#links-menu-button').click(function ()
		{
			jQuery('#link-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','link');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#link-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		jQuery('#audio-menu-button').click(function ()
		{
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','audio');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#audio-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		jQuery('#videos-menu-button').click(function ()
		{
			jQuery('#video-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','video');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#video-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		jQuery('#quotes-menu-button').click(function ()
		{
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#chat-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','quote');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#quote-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		jQuery('#chat-menu-button').click(function ()
		{
			jQuery('#chat-fields').removeAttr('class');
			jQuery('#image-fields').removeAttr('class');
			jQuery('#image-fields').attr('class','hide-fields');
			jQuery('#link-fields').removeAttr('class');
			jQuery('#link-fields').attr('class','hide-fields');
			jQuery('#audio-fields').removeAttr('class');
			jQuery('#audio-fields').attr('class','hide-fields');
			jQuery('#video-fields').removeAttr('class');
			jQuery('#video-fields').attr('class','hide-fields');
			jQuery('#quote-fields').removeAttr('class');
			jQuery('#quote-fields').attr('class','hide-fields');
			jQuery('#article-fields').removeAttr('class');
			jQuery('#article-fields').attr('class','hide-fields');
			jQuery('#tumblog-submit-fields').removeAttr('class');
			jQuery('#tumblog-type').attr('value','chat');
			jQuery('#content-fields').removeAttr('class');
			jQuery('#tag-fields').removeAttr('class');
			
			if (nicEditors.findEditor('test-content') == undefined) {
				myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('template_directory'); ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
			} else {
				myNicEditor = nicEditors.findEditor('test-content');
			}	
			jQuery('#chat-title').focus();	
			nicEditors.findEditor('test-content').setContent('');
			jQuery('#content-fields > div').addClass('editorwidth');
		});
		
		//AJAX FORM POST
		jQuery('#tumblog-form').ajaxForm(
		{
  			name: 'formpost',
  			data: { // Additional data to send
						action: 'woo_tumblog_post',
						type: 'upload',
						data: 'formpost' },
			// handler function for success event 
			success: function(responseText, statusText) 
				{
					jQuery('#test-response').html('<span class="success">'+'Published!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#ajax-loader').hide();
					resetTumblogQuickPress();
				},
			// handler function for errors 
			error: function(request) 
			{
				// parse it for WordPress error 
				if (request.responseText.search(/<title>WordPress &rsaquo; Error<\/title>/) != -1) 
				{
					var data = request.responseText.match(/<p>(.*)<\/p>/); 
					jQuery('#test-response').html('<span class="error">'+ data[1] +'</span>');
				} 
				else 
				{
					jQuery('#test-response').html('<span class="error">An error occurred, please notify the administrator.</span>');
				} 
			},
			beforeSubmit: function(formData, jqForm, options) 
			{
				jQuery('#ajax-loader').show();
			} 
		});
		//AJAX IMAGE UPLOAD
		new AjaxUpload('#image_upload_button', {
  			action: '<?php echo admin_url("admin-ajax.php"); ?>',
  			name: 'userfile',
  			data: { // Additional data to send
						action: 'woo_tumblog_media_upload',
						type: 'upload',
						data: 'userfile' },
  			onSubmit : function(file , ext){
        	        if (! (ext && /^(jpg|png|jpeg|gif|bmp|tiff|tif|ico|jpe)$/.test(ext))){
           	             // extension is not allowed
           	             alert('Error: invalid file extension');
           	             // cancel upload
           	             return false;
           	     	}
           	     	else {
           	     		jQuery('#test-response').html('<span class="success">'+'Image Uploading...'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000);
           	     	}
        	},
			onComplete: function(file, response) {
				jQuery('#test-response').html('<span class="success">'+'Image Uploaded!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				var splitResults = response.split('|');
				jQuery('#image-upload').attr('value',splitResults[0]);		
				jQuery('#image-id').attr('value',splitResults[1]);
			}
		});
		//AJAX AUDIO UPLOAD
		new AjaxUpload('#audio_upload_button', {
  			action: '<?php echo admin_url("admin-ajax.php"); ?>',
  			name: 'userfile',
  			data: { // Additional data to send
						action: 'woo_tumblog_media_upload',
						type: 'upload',
						data: 'userfile' },
  			onSubmit : function(file , ext){
        	        if (! (ext && /^(mp3|mp4|ogg|wma|midi|mid|wav|wmx|wmv|avi|mov|qt|mpeg|mpg|asx|asf)$/.test(ext))){
           	             // extension is not allowed
           	             alert('Error: invalid file extension');
           	             // cancel upload
           	             return false;
           	     	}
           	     	else {
           	     		jQuery('#test-response').html('<span class="success">'+'Audio Uploading...'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000);
           	     	}
        	},
			onComplete: function(file, response) {
				jQuery('#test-response').html('<span class="success">'+'Audio Uploaded!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				var splitResults = response.split('|');
				jQuery('#audio-upload').attr('value',splitResults[0]);		
				jQuery('#audio-id').attr('value',splitResults[1]);
			}
		});
	});
	
	</script>
<div id="tumblog-post">

	<form name="tumblog-form" onsubmit="updateContent();" id="tumblog-form" method="post" action="<?php echo admin_url("admin-ajax.php"); ?>">

	<img id="ajax-loader" src="<?php echo get_bloginfo('template_directory'); ?>/functions/images/ajax-loader.gif" />

	<div id="test-response"></div>

	<div id="tumblog-menu">
		<a id="articles-menu-button" href="#" title="#">Article</a>
		<a id="images-menu-button" href="#" title="#">Image</a>
		<a id="links-menu-button" href="#" title="#">Link</a>
		<a id="audio-menu-button" href="#" title="#">Audio</a>
		<a id="videos-menu-button" href="#" title="#">Video</a>
		<a id="quotes-menu-button" href="#" title="#">Quote</a>
		<a id="chat-menu-button" href="#" title="#">Chat</a>
	</div>

	<div id="article-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="note-title">Title</label></h4>
		<div>
			<input name="note-title" id="note-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
	</div>

	<div id="video-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="video-title">Title</label></h4>
		<div>
			<input name="video-title" id="video-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<h4 id="quick-post-title"><label for="video-embed">Embed Video Code</label></h4>
		<textarea style="width:100%" id="video-embed" name="video-embed" tabindex="2"></textarea>
	</div>
	
	<div id="image-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="image-title">Title</label></h4>
		<div>
			<input name="image-title" id="image-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<div id="image-option-upload" style="display:none;">
			<h4 id="quick-post-title"><label for="image-upload">Upload Image</label> | <label id="image-url-button">Image URL instead</label></h4>
			<div>
				<input name="image-upload" id="image-upload" tabindex="2" autocomplete="off" value="" type="text">
			</div>
			<input name="image_upload_button" type="button" id="image_upload_button" class="button" value="Upload Image" />
		</div>
		<div id="image-option-url">
			<h4 id="quick-post-title"><label for="image-url">Image URL</label> | <label id="image-upload-button">Upload Image instead</label></h4>
			<div>
				<input name="image-url" id="image-url" tabindex="2" autocomplete="off" value="" type="text">
			</div>
		</div>
		<input type="hidden" id="image-id" name="image-id" value="" />
	</div>
	
	<div id="link-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="link-title">Title</label></h4>
		<div>
			<input name="link-title" id="link-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<h4 id="quick-post-title"><label for="link-url">Link URL</label></h4>
		<div>
			<input name="link-url" id="link-url" tabindex="2" autocomplete="off" value="" type="text">
		</div>
	</div>
	
	<div id="quote-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="quote-title">Title</label></h4>
		<div>
			<input name="quote-title" id="quote-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<h4 id="quick-post-title"><label for="quote-copy">Quote</label></h4>
		<textarea style="width:100%" id="quote-copy" name="quote-copy" tabindex="2"></textarea>
		<h4 id="quick-post-title"><label for="quote-url">Quote URL</label></h4>
		<div>
			<input name="quote-url" id="quote-url" tabindex="3" autocomplete="off" value="" type="text">
		</div>
		<h4 id="quick-post-title"><label for="quote-quote">Quote Author</label></h4>
		<div>
			<input name="quote-author" id="quote-author" tabindex="4" autocomplete="off" value="" type="text">
		</div>
	</div>
	
	<div id="audio-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="audio-title">Title</label></h4>
		<div>
			<input name="audio-title" id="audio-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<div id="audio-option-upload" style="display:none;">
			<h4 id="quick-post-title"><label for="audio-upload">Upload Audio</label> | <label id="audio-url-button">Audio URL instead</label></h4>
			<div>
				<input name="audio-upload" id="audio-upload" tabindex="2" autocomplete="off" value="" type="text">
			</div>
			<input name="audio_upload_button" type="button" id="audio_upload_button" class="button" value="Upload Audio" />
		</div>
		<div id="audio-option-url">
			<h4 id="quick-post-title"><label for="audio-url">Audio URL</label> | <label id="audio-upload-button">Upload Audio instead</label></h4>
			<div>
				<input name="audio-url" id="audio-url" tabindex="2" autocomplete="off" value="" type="text">
			</div>
		</div>
		<input type="hidden" id="audio-id" name="audio-id" value="" />
	</div>
	
	<div id="chat-fields" class="hide-fields">
		<h4 id="quick-post-title"><label for="chat-title">Title</label></h4>
		<div>
			<input name="chat-title" id="chat-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
		</div>
		<?php if ( current_user_can( 'upload_files' ) ) : ?>
			<h4 id="quick-post-title"><label for="chat-content">Dialogue</label></h4>
		<?php endif; ?>
	</div>	
	
	<div id="content-fields" class="hide-fields">
		<?php if ( current_user_can( 'upload_files' ) ) : ?>
			<?php //the_editor('', $id = 'content', $prev_id = 'title', $media_buttons = false, $tab_index = 5); ?>
			<textarea tabindex="5" id="test-content" style="width:100%;height:100px;"></textarea>
		<?php endif; ?>
		<input type="hidden" id="tumblog-content" name="tumblog-content" value="" />
		<input type="hidden" id="tumblog-type" name="tumblog-type" value="article" />
	</div>
	
	<div id="tag-fields" class="hide-fields">
		<h4 id="tumblog-tags-title"><label for="tumblog-tags">Tags</label></h4>
		<div>
			<input name="tumblog-tags" id="tumblog-tags" tabindex="6" autocomplete="off" value="" type="text">
		</div>
	</div>
	
	<div id="tumblog-submit-fields" class="hide-fields">
		<input name="tumblogsubmit" type="submit" id="tumblogsubmit" class="button-primary" tabindex="7" value="Submit" onclick="return validateInput();" />
		<input name="tumblogreset" type="reset" id="tumblogreset" class="button" tabindex="8" value="Reset" />
	</div>
	
	</form>
	
</div><div id="debug-tumblog"></div>
	
	<?php
} 

?>