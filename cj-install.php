<?php


/****************************************************************************************************/
/* function cj_install_options(); 	Check if older options exist and create new options method		*/
/****************************************************************************************************/

function cj_install_options() {

//	add_action ('admin_notices','cj_admin_message');	
	$cj_current_options	= get_option('cj_options');
	
	// Create default values if new... 
	if (!$cj_current_options){
		
		$cj_default_title = "CJ_NAME";
		$cj_default_post = "<p><a href='CJ_BUYURL'><img src='CJ_IMAGEURL'></a></p><p>CJ_DESCRIPTION</p>";
		$cj_default_category = "CJ_PROGRAMNAME";
		$cj_default_tag = "CJ_KEYWORDS,CJ_PROGRAMNAME";
		
		$cj_options = array(
			'cj_version'	 		=> '1.5',
			'cj_file_location' 		=> '',
			'cj_template_title'		=> $cj_default_title,
			'cj_template_post' 		=> $cj_default_post,
			'cj_template_category' 	=> $cj_default_category,
			'cj_template_tag' 		=> $cj_default_tag
		);
		update_option( 'cj_options', $cj_options );
	}	
	else {		
		$cj_current_options['cj_version'] = '1.5';
		update_option( 'cj_options', $cj_current_options );
	}
	
	cj_set_wp_options();
		
}


/****************************************************************************************************/
/* function cj_set_wp_options(); 	Disable ping and comments in wp-admin->discutions				*/
/****************************************************************************************************/

function cj_set_wp_options() {

	global $wpdb;
	// Remove ping options to avoid CJ.com false click...
	$cj_sql = "UPDATE $wpdb->options SET option_value = 'close' WHERE option_name = 'default_ping_status'";
	$cj_ok = 0;
	$cj_ok = $wpdb->query($cj_sql);	
	switch ($cj_ok) {
		case "0" :
	//		 cj_admin_error("Error disabling ping...");
			break;
		
		case "1" :
	//		 cj_admin_messages("Ping disable succefully!");
			break;			
	}
	
	// Close post comments
	$cj_sql = "UPDATE $wpdb->options SET option_value = 'close' WHERE option_name = 'default_comment_status'";
	$cj_ok = 0;
	$cj_ok = $wpdb->query($cj_sql);	
	switch ($cj_ok) {
		case "0" :
	//		 cj_admin_error("Error disabling comments...");
			break;
		
		case "1" :
	//		 cj_admin_messages("Comments disabled succefully!");
			break;			
	}
	// Close pingback
	$cj_sql = "UPDATE $wpdb->options SET option_value = '0' WHERE option_name = 'default_pingback_flag'";
	$cj_ok = 0;
	$cj_ok = $wpdb->query($cj_sql);	
	switch ($cj_ok) {
		case "0" :
	//		 cj_admin_error("Error disabling pingback...");
			break;
		
		case "1" :
	//		 cj_admin_messages("Pingback disabled succefully!");
			break;			
	}


}


?>