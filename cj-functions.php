<?php
/****************************************************************************************************/	
/*	CJ-Datafeed																						*/
/*	Functions																						*/
/*																									*/
/*	cj_admin_message($cj_message);																	*/
/*	cj_admin_error($cj_message);																	*/
/*	cj_process_datafeed($cj_preview,$cj_time_interval,$cj_time_factor );							*/
/*	strToDate($outFormat = "Y-m-d H:i:s", $shift = "+2 hours", $now = "now");						*/
/*	cj_datafeed();																					*/
/*	cj_delete_select();																				*/
/*	cj_clean($adv_name);																			*/
/*																									*/
/****************************************************************************************************/

/****************************************************************************************************/
/* function cj_admin_message($cj_message);		Use WP Admin OK message								*/
/****************************************************************************************************/

// Good messages
function cj_admin_message($cj_message){
	echo "<div class='updated'><p>$cj_message</p></div>";
}

/****************************************************************************************************/
/*  cj_admin_error($cj_message);		Use WP Admin Bad message									*/
/****************************************************************************************************/

// Bad messages
function cj_admin_error($cj_message){
	echo "<div id='message' class='error'>$cj_message</div>";
}

/****************************************************************************************************/
/*	cj_process_datafeed($cj_preview,$cj_time_interval,$cj_time_factor )								*/
/****************************************************************************************************/

function cj_process_datafeed($cj_preview,$cj_time_interval,$cj_time_factor ){

	global $wpdb;

	// Preview mode "ok" when done
	$cj_previewdone= "";
	
	if($cj_preview){
		cj_admin_message("Preview Post Template With Data");
	}
	if(!$cj_preview){
		cj_admin_message("Processing Datafeed File...");
	}
	
	// Read current template for use in next loop
	$cj_current_options	= get_option('cj_options');
	
	// Set template variables from options array
	$cj_template_title = $cj_current_options['cj_template_title'];
	$cj_template_post = $cj_current_options['cj_template_post'];
	$cj_template_category = $cj_current_options['cj_template_category'];
	$cj_template_tag = $cj_current_options['cj_template_tag'];
	
	// Start reading datafeed file 	
	$cj_file_location = $cj_current_options['cj_file_location'];
	$cj_data = $cj_current_options['$cj_file_location'];
	
	if( file_exists($cj_file_location)) {
		
		$cj_data = file_get_contents("$cj_file_location");
		$cj_data = str_replace("\r", "", $cj_data);
		$cj_data = explode("\n", $cj_data);
		$cj_i=0;
		
		// Init future post variable		
		$cj_time_from_start = 0;
		
		foreach($cj_data as $k=>$v) {
			
			// Code from kasper  !!thank you!!
			if ( $cj_previewdone == "ok" ) {
				break;
			}
			if(empty($v)) {
				unset($cj_data[$k]);
			}
			else if(!preg_match("/[0-9]/", $v)) {continue;}
			else {
			// End kasper 
			
				// Get template options value		
				$cj_opt_title = $cj_template_title;
				$cj_opt_post = $cj_template_post;
				$cj_opt_category = $cj_template_category;
				$cj_opt_tag = $cj_template_tag;
					
				$cj_row = explode("|", $v);
				$PROGRAMNAME 			= $cj_row[0];
				$PROGRAMURL				= $cj_row[1];	
				$CATALOGNAME			= $cj_row[2];
				$LASTUPDATED			= $cj_row[3];
				$NAME					= $cj_row[4];
				$KEYWORDS				= $cj_row[5];
				$DESCRIPTION			= $cj_row[6];
				$SKU					= $cj_row[7];
				$MANUFACTURER			= $cj_row[8];
				$MANUFACTURERID			= $cj_row[9];
				$UPC					= $cj_row[10];
				$ISBN					= $cj_row[11];
				$CURRENCY				= $cj_row[12];
				$SALEPRICE				= $cj_row[13];
				$PRICE					= $cj_row[14];
				$RETAILPRICE			= $cj_row[15];
				$FROMPRICE				= $cj_row[16];
				$BUYURL					= $cj_row[17];	
				$IMPRESSIONURL			= $cj_row[18];
				$IMAGEURL				= $cj_row[19];
				$ADVERTISERCATEGORY		= $cj_row[20];
				$THIRDPARTYID			= $cj_row[21];
				$THIRDPARTYCATEGORY		= $cj_row[22];
				$AUTHOR					= $cj_row[23];
				$ARTIST					= $cj_row[24];
				$TITLE					= $cj_row[25];
				$PUBLISHER				= $cj_row[26];
				$LABEL					= $cj_row[27];
				$FORMAT					= $cj_row[28];
				$SPECIAL				= $cj_row[29];
				$GIFT					= $cj_row[30];
				$PROMOTIONALTEXT		= $cj_row[31];
				$STARTDATE				= $cj_row[32];
				$ENDDATE				= $cj_row[33];
				$OFFLINE				= $cj_row[34];
				$ONLINE					= $cj_row[35];
				$INSTOCK				= $cj_row[36];
				$CONDITION				= $cj_row[37];
				$WARRANTY				= $cj_row[38];
				$STANDARDSHIPPINGCOST	= $cj_row[39];
				
				// Process title
				$cj_opt_title = str_replace("CJ_PROGRAMNAME", "$PROGRAMNAME", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_PROGRAMURL", "$PROGRAMURL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_CATALOGNAME", "$CATALOGNAME", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_LASTUPDATED", "$LASTUPDATED", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_NAME", "$NAME", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_KEYWORDS", "$KEYWORDS", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_DESCRIPTION", "$DESCRIPTION", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_SKU", "$SKU", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_MANUFACTURERNAME", "$MANUFACTURER", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_MANUFACTURERID", "$MANUFACTURERID", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_UPC", "$UPC", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_ISBN", "$ISBN", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_CURRENCY", "$CURRENCY", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_SALEPRICE", "$SALEPRICE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_PRICE", "$PRICE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_RETAILPRICE", "$RETAILPRICE", $cj_opt_title);				
				$cj_opt_title = str_replace("CJ_FROMPRICE", "$FROMPRICE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_BUYURL", "$BUYURL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_IMPRESSIONURL", "$IMPRESSIONURL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_IMAGEURL", "$IMAGEURL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_ADVERTISERCATEGORY", "$ADVERTISERCATEGORY", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_THIRDPARTYID", "$THIRDPARTYID", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_THIRDPARTYCATEGORY", "$THIRDPARTYCATEGORY", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_AUTHOR", "$AUTHOR", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_ARTIST", "$ARTIST", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_TITLE", "$TITLE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_PUBLISHER", "$PUBLISHER", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_LABEL", "$LABEL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_FORMAT", "$FORMAT", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_SPECIAL", "$SPECIAL", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_GIFT", "$GIFT", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_PROMOTIONALTEXT", "$PROMOTIONALTEXT", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_STARTDATE", "$STARTDATE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_ENDDATE", "$ENDDATE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_ONLINE", "$ONLINE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_OFFLINE", "$OFFLINE", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_INSTOCK", "$INSTOCK", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_CONDITION", "$CONDITION", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_WARRANTY", "$WARRANTY", $cj_opt_title);
				$cj_opt_title = str_replace("CJ_STANDARDSHIPPINGCOST", "$STANDARDSHIPPINGCOST", $cj_opt_title);

				// Process post
				$cj_opt_post = str_replace("CJ_PROGRAMNAME", "$PROGRAMNAME", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_PROGRAMURL", "$PROGRAMURL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_CATALOGNAME", "$CATALOGNAME", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_LASTUPDATED", "$LASTUPDATED", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_NAME", "$NAME", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_KEYWORDS", "$KEYWORDS", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_DESCRIPTION", "$DESCRIPTION", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_SKU", "$SKU", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_MANUFACTURERNAME", "$MANUFACTURER", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_MANUFACTURERID", "$MANUFACTURERID", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_UPC", "$UPC", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_ISBN", "$ISBN", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_CURRENCY", "$CURRENCY", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_SALEPRICE", "$SALEPRICE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_PRICE", "$PRICE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_RETAILPRICE", "$RETAILPRICE", $cj_opt_post);				
				$cj_opt_post = str_replace("CJ_FROMPRICE", "$FROMPRICE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_BUYURL", "$BUYURL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_IMPRESSIONURL", "$IMPRESSIONURL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_IMAGEURL", "$IMAGEURL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_ADVERTISERCATEGORY", "$ADVERTISERCATEGORY", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_THIRDPARTYID", "$THIRDPARTYID", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_THIRDPARTYCATEGORY", "$THIRDPARTYCATEGORY", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_AUTHOR", "$AUTHOR", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_ARTIST", "$ARTIST", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_TITLE", "$TITLE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_PUBLISHER", "$PUBLISHER", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_LABEL", "$LABEL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_FORMAT", "$FORMAT", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_SPECIAL", "$SPECIAL", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_GIFT", "$GIFT", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_PROMOTIONALTEXT", "$PROMOTIONALTEXT", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_STARTDATE", "$STARTDATE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_ENDDATE", "$ENDDATE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_ONLINE", "$ONLINE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_OFFLINE", "$OFFLINE", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_INSTOCK", "$INSTOCK", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_CONDITION", "$CONDITION", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_WARRANTY", "$WARRANTY", $cj_opt_post);
				$cj_opt_post = str_replace("CJ_STANDARDSHIPPINGCOST", "$STANDARDSHIPPINGCOST", $cj_opt_post);
												
				// Process category
				$cj_opt_category = str_replace("CJ_PROGRAMNAME", "$PROGRAMNAME", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_PROGRAMURL", "$PROGRAMURL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_CATALOGNAME", "$CATALOGNAME", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_LASTUPDATED", "$LASTUPDATED", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_NAME", "$NAME", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_KEYWORDS", "$KEYWORDS", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_DESCRIPTION", "$DESCRIPTION", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_SKU", "$SKU", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_MANUFACTURERNAME", "$MANUFACTURER", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_MANUFACTURERID", "$MANUFACTURERID", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_UPC", "$UPC", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_ISBN", "$ISBN", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_CURRENCY", "$CURRENCY", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_SALEPRICE", "$SALEPRICE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_PRICE", "$PRICE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_RETAILPRICE", "$RETAILPRICE", $cj_opt_category);				
				$cj_opt_category = str_replace("CJ_FROMPRICE", "$FROMPRICE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_BUYURL", "$BUYURL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_IMPRESSIONURL", "$IMPRESSIONURL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_IMAGEURL", "$IMAGEURL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_ADVERTISERCATEGORY", "$ADVERTISERCATEGORY", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_THIRDPARTYID", "$THIRDPARTYID", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_THIRDPARTYCATEGORY", "$THIRDPARTYCATEGORY", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_AUTHOR", "$AUTHOR", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_ARTIST", "$ARTIST", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_TITLE", "$TITLE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_PUBLISHER", "$PUBLISHER", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_LABEL", "$LABEL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_FORMAT", "$FORMAT", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_SPECIAL", "$SPECIAL", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_GIFT", "$GIFT", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_PROMOTIONALTEXT", "$PROMOTIONALTEXT", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_STARTDATE", "$STARTDATE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_ENDDATE", "$ENDDATE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_ONLINE", "$ONLINE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_OFFLINE", "$OFFLINE", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_INSTOCK", "$INSTOCK", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_CONDITION", "$CONDITION", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_WARRANTY", "$WARRANTY", $cj_opt_category);
				$cj_opt_category = str_replace("CJ_STANDARDSHIPPINGCOST", "$STANDARDSHIPPINGCOST", $cj_opt_category);
				
				// Process tag
				$cj_opt_tag = str_replace("CJ_PROGRAMNAME", "$PROGRAMNAME", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_PROGRAMURL", "$PROGRAMURL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_CATALOGNAME", "$CATALOGNAME", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_LASTUPDATED", "$LASTUPDATED", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_NAME", "$NAME", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_KEYWORDS", "$KEYWORDS", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_DESCRIPTION", "$DESCRIPTION", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_SKU", "$SKU", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_MANUFACTURER", "$MANUFACTURER", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_MANUFACTURERID", "$MANUFACTURERID", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_UPC", "$UPC", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_ISBN", "$ISBN", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_CURRENCY", "$CURRENCY", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_SALEPRICE", "$SALEPRICE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_PRICE", "$PRICE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_RETAILPRICE", "$RETAILPRICE", $cj_opt_tag);				
				$cj_opt_tag = str_replace("CJ_FROMPRICE", "$FROMPRICE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_BUYURL", "$BUYURL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_IMPRESSIONURL", "$IMPRESSIONURL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_IMAGEURL", "$IMAGEURL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_ADVERTISERCATEGORY", "$ADVERTISERCATEGORY", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_THIRDPARTYID", "$THIRDPARTYID", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_THIRDPARTYCATEGORY", "$THIRDPARTYCATEGORY", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_AUTHOR", "$AUTHOR", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_ARTIST", "$ARTIST", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_TITLE", "$TITLE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_PUBLISHER", "$PUBLISHER", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_LABEL", "$LABEL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_FORMAT", "$FORMAT", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_SPECIAL", "$SPECIAL", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_GIFT", "$GIFT", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_PROMOTIONALTEXT", "$PROMOTIONALTEXT", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_STARTDATE", "$STARTDATE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_ENDDATE", "$ENDDATE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_ONLINE", "$ONLINE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_OFFLINE", "$OFFLINE", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_INSTOCK", "$INSTOCK", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_CONDITION", "$CONDITION", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_WARRANTY", "$WARRANTY", $cj_opt_tag);
				$cj_opt_tag = str_replace("CJ_STANDARDSHIPPINGCOST", "$STANDARDSHIPPINGCOST", $cj_opt_tag);
				
										
				// IF preview mode-> display data 
				if($cj_preview == "1"){
				
					echo "<h2>Post Title:</h2><h3>$cj_opt_title</h3>";
					echo "<h2>Post Content:</h2>$cj_opt_post";
					echo "<h2>Post Categories:</h2>$cj_opt_category <h2>Tags:</h2>$cj_opt_tag";				
					$cj_previewdone = "ok";
										
				}
				//ELSE ->post datafeed to WP
				else {
				
					$cj_category_ids = array();	
					$cj_i_cat = 0;
					$cattoadd = explode (",",$cj_opt_category);
					foreach($cattoadd as $i => $v) {
						$v=trim($v);
						if(empty($v)) {
							unset($cattoadd[$i]);
						}	
						$cj_is_cat_id = get_cat_ID('$v');
						switch ($cj_is_cat_id) {
						
							case "0" :
							// create category and get cat_id
								$cj_new_cat = wp_create_category($v);
								$cj_category_ids = array_merge($cj_category_ids,array(0 =>$cj_new_cat));
							break;
				
							default :
								$cj_category_ids = array_merge($cj_category_ids,array(0 =>$cj_is_cat_id));
							break;		
						}
						$cj_i_cat = $cj_i_cat + 1;							
					}

					//Prepare post
					$cj_post = array(
	  					'post_title' => $cj_opt_title,
				    	'post_content' => $cj_opt_post,
 		    			'post_status' => 'publish',
					    'post_author' => 1,
		    			'post_category' => $cj_category_ids,
						'post_type' => 'post',
					 	'ping_status' => 'close', 
		    			'tags_input' => $cj_opt_tag,
						'comment_status' => 'close'
		    		);
										
					// Setting future post time format for WP
					$cj_blogtime = current_time('mysql,1'); //GMT time
					$cj_future_post = "+".$cj_time_from_start." $cj_time_factor";
					// check if future post...
					if ($cj_time_interval > 0 ) {
						$cj_post['post_status'] = 'future';
						$cj_post['post_date_gmt'] = strToDate( "Y-m-d H:i:s", $cj_future_post, current_time(mysql,1) );
					}								
					// Check if post exist via SKU number
					// $checkid = $wpdb->get_results ("SELECT * FROM {$wpdb->postmeta} WHERE meta_key='cj_datafeed' AND meta_value='$SKU'");
					$checkid = $wpdb->get_results ("SELECT * FROM {$wpdb->postmeta} WHERE meta_key='cj_buyurl' AND meta_value='$BUYURL'");
					$dummycount=count($checkid);
	
				if (count ($checkid) > 0) {
					// echo"Post already exist... $cj_opt_title... go to next post...<br>";
					$cj_message = "Post already exist... $cj_opt_title... go to next post...";
					cj_admin_error($cj_message);
				}
				// Post processed Datafeed to WP
				else {
				
					// Retrieve Post ID
					$cj_insert_id = wp_insert_post($cj_post);
					
					// Add meta_key for double post check
					add_post_meta($cj_insert_id, "cj_datafeed", $SKU);
					
					// Add raw data for future use like rebuild function
					add_post_meta($cj_insert_id, "cj_programname", $PROGRAMNAME);	
					add_post_meta($cj_insert_id, "cj_programurl", $PROGRAMURL);	
					add_post_meta($cj_insert_id, "cj_catalogname", $CATALOGNAME);	
					add_post_meta($cj_insert_id, "cj_lastupdated", $LASTUPDATED);	
					add_post_meta($cj_insert_id, "cj_name", $NAME);	
					add_post_meta($cj_insert_id, "cj_keywords", $KEYWORDS);	
					add_post_meta($cj_insert_id, "cj_description", $DESCRIPTION);
					add_post_meta($cj_insert_id, "cj_sku", $SKU);
					//before v1.5 need to know to support older version ... maybe ( was buggy with cj_manufacturer replace fct and cj_manufacturerid
					//add_post_meta($cj_insert_id, "cj_manufacturer", $MANUFACTURER);
					add_post_meta($cj_insert_id, "cj_manufacturername", $MANUFACTURER);
					add_post_meta($cj_insert_id, "cj_manufacturerid", $MANUFACTURERID);
					add_post_meta($cj_insert_id, "cj_upc", $UPC);
					add_post_meta($cj_insert_id, "cj_isbn", $ISBN);
					add_post_meta($cj_insert_id, "cj_currency", $CURRENCY);
					add_post_meta($cj_insert_id, "cj_saleprice", $SALEPRICE);
					add_post_meta($cj_insert_id, "cj_price", $PRICE);
					add_post_meta($cj_insert_id, "cj_retailprice", $RETAILPRICE);
					add_post_meta($cj_insert_id, "cj_fromprice", $FROMPRICE);
					add_post_meta($cj_insert_id, "cj_buyurl", $BUYURL);
					add_post_meta($cj_insert_id, "cj_impressionurl", $IMPRESSIONURL);
					add_post_meta($cj_insert_id, "cj_imageurl", $IMAGEURL);
					add_post_meta($cj_insert_id, "cj_advertisercategory", $ADVERTISERCATEGORY);
					add_post_meta($cj_insert_id, "cj_thirdpartyid", $THIRDPARTYID);
					add_post_meta($cj_insert_id, "cj_thirdpartycategory", $THIRDPARTYCATEGORY);
					add_post_meta($cj_insert_id, "cj_author", $AUTHOR);
					add_post_meta($cj_insert_id, "cj_artist", $ARTIST);
					add_post_meta($cj_insert_id, "cj_title", $TITLE);
					add_post_meta($cj_insert_id, "cj_publisher", $PUBLISHER);
					add_post_meta($cj_insert_id, "cj_label", $LABEL);
					add_post_meta($cj_insert_id, "cj_format", $FORMAT);
					add_post_meta($cj_insert_id, "cj_special", $SPECIAL);
					add_post_meta($cj_insert_id, "cj_gift", $GIFT);
					add_post_meta($cj_insert_id, "cj_promotionaltext", $PROMOTIONALTEXT);
					add_post_meta($cj_insert_id, "cj_enddate", $ENDDATE);
					add_post_meta($cj_insert_id, "cj_startdate", $STARTDATE);
					add_post_meta($cj_insert_id, "cj_offline",$OFFLINE);
					add_post_meta($cj_insert_id, "cj_online", $ONLINE);
					add_post_meta($cj_insert_id, "cj_instock", $INSTOCK);
					add_post_meta($cj_insert_id, "cj_condition", $CONDITION);
					add_post_meta($cj_insert_id, "cj_warranty", $WARRANTY);
					add_post_meta($cj_insert_id, "cj_standardshippingcost", $STANDARDSHIPPINGCOST);
										
					// Update time interval from start
					$cj_time_from_start =  $cj_time_from_start + $cj_time_interval;
					
					// Update post counter
					$cj_i =$cj_i+1;
					
					// Display something to the user
					echo"Added... $NAME... with post date $cj_future_post...<br> ";
					// $cj_message = "Added... $NAME... with post date $cj_future_post...<br> ";
					// cj_admin_message($cj_message);
				}
				}
			}//End else
		}//End foreach
	// echo "<h2>Total CJ-Datafeed Row Imported : $cj_i</h2>";
	cj_admin_message("Total CJ-Datafeed Row Imported : $cj_i");
	}//End if
}//end function


/********************************************************************************************************/
/* strToDate($outFormat = "Y-m-d H:i:s", $shift = "+2 hours", $now = "now")								*/
/********************************************************************************************************/

//For future post
function strToDate($outFormat = "Y-m-d H:i:s", $shift = "+2 hours", $now = "now") {
	return date($outFormat, strtotime($shift, strtotime($now)));
}
/********************************************************************************************************/
/* cj_datafeed()																						*/
/********************************************************************************************************/
function cj_datafeed(){

	//declare WP pointer
	global $wpdb;
		
	// Start reading datafeed file 
	$cj_current_options	= get_option('cj_options');
	$cj_file_location = $cj_current_options['cj_file_location'];
	$cj_data = file_get_contents("$cj_file_location");
	
	if( file_exists($cj_file_location)) {
		
		$cj_data = file_get_contents("$cj_file_location");
		$cj_data = str_replace("\r", "", $cj_data);
		$cj_data = explode("\n", $cj_data);
		$cj_i=0;
		
		foreach($cj_data as $k=>$v) {
			
			// Code from kasper  !!thank you!!
			if ( $cj_previewdone == "ok" ) {
				break;
			}
			if(empty($v)) {
				unset($cj_data[$k]);
			}
			else if(!preg_match("/[0-9]/", $v)) {continue;}
			else {
			// End kasper 
				// Read file row
				$cj_row = explode("|", $v);
				$PROGRAMNAME 			= $cj_row[0];
				$PROGRAMURL				= $cj_row[1];	
				$CATALOGNAME			= $cj_row[2];
				$LASTUPDATED			= $cj_row[3];
				$NAME					= $cj_row[4];
				$KEYWORDS				= $cj_row[5];
				$DESCRIPTION			= $cj_row[6];
				$SKU					= $cj_row[7];
				$MANUFACTURER			= $cj_row[8];
				$MANUFACTURERID			= $cj_row[9];
				$UPC					= $cj_row[10];
				$ISBN					= $cj_row[11];
				$CURRENCY				= $cj_row[12];
				$SALEPRICE				= $cj_row[13];
				$PRICE					= $cj_row[14];
				$RETAILPRICE			= $cj_row[15];
				$FROMPRICE				= $cj_row[16];
				$BUYURL					= $cj_row[17];	
				$IMPRESSIONURL			= $cj_row[18];
				$IMAGEURL				= $cj_row[19];
				$ADVERTISERCATEGORY		= $cj_row[20];
				$THIRDPARTYID			= $cj_row[21];
				$THIRDPARTYCATEGORY		= $cj_row[22];
				$AUTHOR					= $cj_row[23];
				$ARTIST					= $cj_row[24];
				$TITLE					= $cj_row[25];
				$PUBLISHER				= $cj_row[26];
				$LABEL					= $cj_row[27];
				$FORMAT					= $cj_row[28];
				$SPECIAL				= $cj_row[29];
				$GIFT					= $cj_row[30];
				$PROMOTIONALTEXT		= $cj_row[31];
				$STARTDATE				= $cj_row[32];
				$ENDDATE				= $cj_row[33];
				$OFFLINE				= $cj_row[34];
				$ONLINE					= $cj_row[35];
				$INSTOCK				= $cj_row[36];
				$CONDITION				= $cj_row[37];
				$WARRANTY				= $cj_row[38];
				$STANDARDSHIPPINGCOST	= $cj_row[39];

				echo "<p><table class='widefat'>
					
						<thead>
							<tr>
								<th>Tags Names</th>
								<th>Data From File</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Using datafeed file :</th>
								<th>$cj_file_location</th>
							</tr>
						</tfoot>
						<tbody>
					 	<tr><td valign='top'>CJ_PROGRAMNAME</td><td> $PROGRAMNAME</td></tr>
						<tr><td valign='top'>CJ_PROGRAMURL</td><td>$PROGRAMURL</td></tr>
						<tr><td valign='top'>CJ_CATALOGNAME</td><td>$CATALOGNAME</td></tr>			
						<tr><td valign='top'>CJ_LASTUPDATED</td><td>$LASTUPDATED</td></tr>
						<tr><td valign='top'>CJ_NAME</td><td>$NAME</td></tr>
						<tr><td valign='top'>CJ_KEYWORDS</td><td>$KEYWORDS</td></tr>
						<tr><td valign='top'>CJ_DESCRIPTION</td><td>$DESCRIPTION</td></tr>
						<tr><td valign='top'>CJ_SKU</td><td>$SKU</td></tr>
						<tr><td valign='top'>CJ_MANUFACTURERNAME</td><td>$MANUFACTURER</td></tr>
						<tr><td valign='top'>CJ_MANUFACTURERID</td><td>$MANUFACTURERID</td></tr>
						<tr><td valign='top'>CJ_UPC</td><td>$UPC</td></tr>
						<tr><td valign='top'>CJ_ISBN</td><td>$ISBN</td></tr>
						<tr><td valign='top'>CJ_CURRENCY</td><td>$CURRENCY</td></tr>
						<tr><td valign='top'>CJ_SALEPRICE</td><td>$SALEPRICE</td></tr>	
						<tr><td valign='top'>CJ_PRICE</td><td>$PRICE</td></tr>
						<tr><td valign='top'>CJ_RETAILPRICE</td><td>$RETAILPRICE</td></tr>
						<tr><td valign='top'>CJ_FROMPRICE</td><td>$FROMPRICE</td></tr>
						<tr><td valign='top'>CJ_BUYURL</td><td>$BUYURL</td></tr>
						<tr><td valign='top'>CJ_IMPRESSIONURL</td><td>$IMPRESSIONURL</td></tr>
						<tr><td valign='top'>CJ_IMAGEURL</td><td>$IMAGEURL</td></tr>
						<tr><td valign='top'>CJ_ADVERTISERCATEGORY</td><td>$ADVERTISERCATEGORY</td></tr>
						<tr><td valign='top'>CJ_THIRDPARTYID</td><td>$THIRDPARTYID</td></tr>
						<tr><td valign='top'>CJ_THIRDPARTYCATEGORY</td><td>$THIRDPARTYCATEGORY</td></tr>
						<tr><td valign='top'>CJ_AUTHOR</td><td>$AUTHOR</td></tr>
						<tr><td valign='top'>CJ_ARTIST</td><td>$ARTIST</td></tr>
						<tr><td valign='top'>CJ_TITLE</td><td>$TITLE</td></tr>
						<tr><td valign='top'>CJ_PUBLISHER</td><td>$PUBLISHER</td></tr>
						<tr><td valign='top'>CJ_LABEL</td><td>$LABEL</td></tr>
						<tr><td valign='top'>CJ_FORMAT</td><td>$FORMAT</td></tr>
						<tr><td valign='top'>CJ_SPECIAL</td><td>$SPECIAL</td></tr>
						<tr><td valign='top'>CJ_GIFT</td><td>$GIFT</td></tr>
						<tr><td valign='top'>CJ_PROMOTIONALTEXT</td><td>$PROMOTIONALTEXT</td></tr>
						<tr><td valign='top'>CJ_STARTDATE</td><td>$STARTDATE</td></tr>
						<tr><td valign='top'>CJ_ENDDATE</td><td>$ENDDATE</td></tr>
						<tr><td valign='top'>CJ_OFFLINE</td><td>$OFFLINE</td></tr>
						<tr><td valign='top'>CJ_ONLINE</td><td>$ONLINE</td></tr>
						<tr><td valign='top'>CJ_INSTOCK</td><td>$INSTOCK</td></tr>
						<tr><td valign='top'>CJ_CONDITION</td><td>$CONDITION</td></tr>
						<tr><td valign='top'>CJ_WARRANTY</td><td>$WARRANTY</td></tr>
						<tr><td valign='top'>CJ_STANDARDSHIPPINGCOST</td><td>$STANDARDSHIPPINGCOST</td></tr>
						</tbody>
						</table>
						</p>	
					 ";
					$cj_previewdone = "ok";
										
			}
		}
	}	
}



/********************************************************************************************************/
/* cj_delete_select()																					*/
/********************************************************************************************************/
function cj_delete_select() {

	global $wpdb;
	$table_name = $wpdb->postmeta;
	$col_name = "meta_value";
	$col_key = "meta_key";
	
	
	$cjapi_sql = $wpdb->get_results("SELECT DISTINCT $col_name,$col_key FROM $table_name WHERE $col_key = 'cj_programname' ORDER BY $col_name", ARRAY_A);
	$list = count($cjapi_sql);
	
	if ($list > 0 ){
	
		echo "<table class='widefat'>
			<thead><tr><th>Delete Only Posts CJ-Datafeed Created</th></tr></thead>
			<tfoot><tr><th>";
		echo "Don't forget to empty trash <a href='".home_url('/wp-admin/edit.php?post_status=trash&post_type=post')."'>here</a>";		
		echo"</th></tr></tfoot>
			<tbody><tr><td><form name='cj_preview' action='$PHP_SELF' enctype='multipart/form-data' method='post'>";
		wp_nonce_field('cj_delete_adv');
		echo "<input type='hidden' name='cj_action' value='cj_delete'/>
			  <table class='form-table'><tr><td>";
		echo "<select name='adv_name'>";
		echo "<option value='Delete All'>Delete All</option>";
		foreach($cjapi_sql as $row) {
				 echo"<option value='$row[meta_value]'>$row[meta_value]</option>";
		}
		echo "</select>";			
		echo "<input type='submit' name='delete_adv' value='Delete Posts' class='button-primary'>";
		echo "</td></tr></table></form></td></tr></tbody></table>";
		}
		else {
	 		echo "<h2>No CJ-Datafeed Posts To Delete...</h2>";
		}
}
	


/********************************************************************************************************/
/* cj_clean($adv_name);																					*/
/********************************************************************************************************/

function cj_clean($adv_name){
		 
	global $wpdb;
	global $post;	
		
	$cjapi_query = array (
		 	'showposts'			=> 100,
			'offset'			=> 0,
			'category'			=> 0,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC',
			'include'			=> '',
			'exclude'			=> '',
			'meta_key'			=> 'cj_programname',
			'meta_value'		=> $adv_name,
			'meta_type'			=> 'page',
			'suppress_filter'	=> TRUE,
			'post_status'		=> ''						
	);
		
	if ($adv_name == "Delete All"){
		
		$adv_name = "CJ-Datafeed"; // for delete process display
		$cjapi_query = array (
			'showposts'			=> 100,
			'offset'			=> 0,
			'category'			=> 0,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC',
			'include'			=> '',
			'exclude'			=> '',
			'meta_key'			=> 'cj_programname',
			'meta_value'		=> '',
			'meta_type'			=> 'page',
			'suppress_filter'	=> TRUE,
			'post_status'		=> ''						
			);
	}
	
	$blogclean="1";
	$deleted="0";
	$cjapi_pages = "";
	
	// echo"<h2>Starting process...</h2>";
	cj_admin_message("Starting cleaning process...");
	while($blogclean){
	 
	 // query_posts('meta_key=cjapi_post_id&post_type=post');		
	query_posts($cjapi_query); 
		 	
	if ( have_posts() ) : while ( have_posts() ) : the_post();
    	 echo "CJ-Datafeed post ID $post->ID $post->post_title deleted....<br>";
	     wp_delete_post( $post->ID ) ;
		 $deleted = $deleted + 1;
		
		endwhile; else:
	 		if 	( $deleted > 0 ) {
				// echo"<br> Cleaning process finish with $deleted posts trash<br><br>";	
			 	cj_admin_message("Cleaning process finish with $deleted posts sent to trash");
	 		}	
			// echo"<br>No More $adv_name Posts Detected<br><br>";
		 	cj_admin_message("No More $adv_name Posts Detected");
			$blogclean="0";
	endif;				
	//Reset Query
		wp_reset_query();
	}
}

?>