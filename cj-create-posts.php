<div class="wrap">
<?php
$cj_current_options	= get_option('cj_options');
$cj_version = $cj_current_options['cj_version'];
screen_icon('plugins');	
echo "<h2>CJ-Datafeed v$cj_version</h2>";
?>	
	
<?php

// Using form nounce ref.p123
$cj_action = $_REQUEST['cj_action'];

switch ($cj_action)  {
	
	case 'cj_upload' :
		// Check if nounce is valid ...
		check_admin_referer ('cj_upload_datafeed');
		if($_FILES['cj_datafeed_file']['error'] === 0) {

			$upload = wp_upload_bits($_FILES["cj_datafeed_file"]["name"], null, file_get_contents($_FILES["cj_datafeed_file"]["tmp_name"]));
			$file_location = $upload[file];
			$cj_current_options['cj_file_location'] = $file_location;	
			$cj_ok = 0;
	   	  	$cj_ok = update_option( 'cj_options',$cj_current_options );
		 	
			switch ($cj_ok){
			
				case "1" :
					cj_admin_message('File uploaded Successfully');
					$cj_file_location = $cj_current_options['cj_file_location'];
					break;
			
				default :
					// echo "Something got wrong... doh $@#!<br>";
					cj_admin_error('Something wrong with your upload'.$cj_ok);	
			}
		}
		break;

	case 'cj_template' :	
		// Check if nounce is valid ...
		check_admin_referer ('cj_update_template');		
		$cj_up_title = $_REQUEST['cj_template_title'];
		// $cj_up_post = $_REQUEST['cj_template_post'];
		// Remove added slash... ugly patch...
		$cj_up_post = str_replace("\\","",$_REQUEST['cj_template_post']);
		$cj_up_cat = $_REQUEST['cj_template_category'];
		$cj_up_tag = $_REQUEST['cj_template_tag'];	
		
			// need to sanitanize variable before ...
		$cj_current_options['cj_template_title']	=  $cj_up_title;
		$cj_current_options['cj_template_post']		=  $cj_up_post;
		$cj_current_options['cj_template_category']	=  $cj_up_cat;
		$cj_current_options['cj_template_tag']		=  $cj_up_tag;
		
		$cj_ok = 0;					
		$cj_ok = update_option( 'cj_options', $cj_current_options );
		if ($cj_ok) {
			cj_admin_message("Template Updated Successfully");
		}
		break;
		
	case 'cj_preview' :	
		// Check if nounce is valid ...
		check_admin_referer ('cj_preview_datafeed');
		// cj_admin_message("Preview template...");
		$cj_preview ="1";
		cj_process_datafeed($cj_preview,0,0); // Preview mode
		cj_admin_message("Ending template preview...");
		break;
		
	case 'cj_create_post' :	
		// Check if nounce is valid ...
		check_admin_referer ('cj_create_post');
		cj_admin_message("Disabling ping....");
		cj_set_wp_options();
		$cj_time_interval = $_REQUEST['cj_time_interval'];
		$cj_time_factor = $_REQUEST['cj_time_factor'];
		cj_process_datafeed(0,$cj_time_interval,$cj_time_factor);
		break;
		
}

	
if( $_POST['ready'] == 'Y' ) {

}

$cj_template_title = $cj_current_options['cj_template_title'];
$cj_template_post = $cj_current_options['cj_template_post'];
$cj_template_category = $cj_current_options['cj_template_category'];
$cj_template_tag = $cj_current_options['cj_template_tag'];
$cj_file_location = $cj_current_options['cj_file_location'];

?>
<p>
<table class="widefat">
<thead>
	<tr>
		<th>1- Upload datafeed</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<th></th>
	</tr>
</tfoot>
<tbody>
	<tr>
		<td>	
			Upload your datafeed.txt file here
			<form name="cj_upload_file" enctype="multipart/form-data" method="post">
			<?php wp_nonce_field('cj_upload_datafeed');?>
			<input type="hidden" name="cj_action" value="cj_upload"/>
			<table class='form-table'>
			<tr><th scope='row'><label for='cj_datafeed_file'>Select File To Upload</label></th>
				<td><input type="file" name="cj_datafeed_file"/></td>
			</tr><tr>
				<td><input type="hidden" name="ready" value="Y">
					<input type="submit" name="cj_upload" value="Upload" class='button-primary'/>
				</td>
			</tr>
			</table>
			</form>
		</td>
	</tr>
</tbody>
</table>	
</p>
<p>	
<table class="widefat">
<thead>
	<tr>
		<th>2- Edit template</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<th></th>
	</tr>
</tfoot>
<tbody>	
	<tr>
		<td>CJ-Datafeed Template System
			<form name="cj_template" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data" method="post">
			<?php wp_nonce_field('cj_update_template');?>
			<input type="hidden" name="cj_action" value="cj_template"/>
			<table class='form-table'>
				<tr><th scope='row'><label for='cj_template_title'>Title</label></th>
					<td><textarea name="cj_template_title" id="cj_template_title_id" cols="100" rows="1" tabindex="1"><?php echo esc_attr($cj_template_title); ?></textarea>			
					</td>
				</tr>
				<tr><th scope='row'><label for='cj_template_post'>Post</label></th>
					<td><textarea name="cj_template_post" id="cj_template_post_id" cols="100" rows="5" tabindex="1"><?php echo "$cj_template_post"; ?></textarea>
					</td>
				</tr>
				<tr><th scope='row'><label for='cj_template_category'>Categories</label></th>
					<td>
					<textarea name="cj_template_category" id="cj_template_category_id" cols="100" rows="1" tabindex="0"><?php echo esc_attr($cj_template_category); ?></textarea>			</td>
				</tr>
				<tr><th scope='row'><label for='cj_template_tag'>Tags</label></th>
					<td>
					<textarea name="cj_template_tag" id="cj_template_tag_id" cols="100" rows="1" tabindex="0"><?php echo esc_attr($cj_template_tag); ?></textarea>
					</td>
				</tr>
				<tr><td>
					<input type="submit" name="cj_submit_template" value="Update" class='button-primary'>
				</td></tr>
			</table>
			</form>	
		</td>
	</tr>
</tbody>
</table>
</p>
<p>

<?php

if ($cj_file_location !='') { 

	// do no display preview button if no datafeed file			
	echo "<table class='widefat'>
			<thead><tr><th>3- Preview template with datafeed</th></tr></thead>
			<tfoot><tr><th></th></tr></tfoot>
			<tbody><tr><td><form name='cj_preview' action='$PHP_SELF' enctype='multipart/form-data' method='post'>";
	wp_nonce_field('cj_preview_datafeed');
	echo "	<input type='hidden' name='cj_action' value='cj_preview'/>
			<table class='form-table'>
			<tr>
				<td><input type='submit' name='cj_preview_template' value='Preview' class='button-primary'></td>
			</tr>				
			</table>
			</form>
			</td>
			</tr>
			</tbody>
			</table>";
			
	// do no display post button if no datafeed file		
	echo "</p><p>";
	echo "<table class='widefat'>
			<thead><tr><th>4- Create post from datafeed</th></tr></thead>
			<tfoot><tr><th></th></tr></tfoot>
			<tbody><tr><td><form name='cj_post' action='$PHP_SELF' enctype='multipart/form-data' method='post'>";
	wp_nonce_field('cj_create_post');
	echo "<input type='hidden' name='cj_action' value='cj_create_post'/>
			<table class='form-table'>
			<tr><th scope='row'><label for='cj_time_interval'>Time interval</label></th>
				<td>
				<select name='cj_time_interval'>";
				$i = 0; 
				while($i < 60){
				echo"<option value=\"$i\">$i</option>";
				$i = $i + 1;
				}
	echo "		</select>
				</td>
			</tr>
			<tr><th scope ='row'><label for='cj_time_factor'>Time Factor</label></th>
				<td> <select name='cj_time_factor'>
						<option value='minutes'>minutes</option>
						<option value='hours'>hours</option>
						<option value='days'>days</option>
						<option value='weeks'>weeks</option>
					</select>
				</td>
			</tr>	
			<tr>
				<td><input type='submit' name='cj_create_post' value='Create' class='button-primary'></td>
			</tr>				
			</table>
			</form>
			</td>
			</tr>
			</tbody>
			</table>";	
}
?>

</p>

<p>
	
<?php
if ($cj_file_location !='') {
	//	echo "<h2>Using file: $cj_file_location</h2>";
 	cj_datafeed();
}?>
</p>
	
</div> 