<?php
/****************************************************************************************************/	
/*	CJ-Datafeed																						*/
/*	Admin Page																						*/
/****************************************************************************************************/	
?>

<div class="wrap">
<?php
$cj_current_options	= get_option('cj_options');
$cj_version = $cj_current_options['cj_version'];
screen_icon('plugins');	
echo "<h2>CJ-Datafeed v$cj_version</h2>";
?>	
<br /><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="L5DFAJ98WPMTY">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" 
							border="0" 
							name="submit" 
							alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<br />
<?php
// Using form nounce ref.p123
$cj_action = $_REQUEST['cj_action'];

switch ($cj_action)  {
	
	case 'cj_support' :
			
			// Check if nounce is valid ...
			// echo "Checking nouce...<br>";
			check_admin_referer ('cj_support_request');
			// echo "Nounce valid<br>";
			// Get admin data
			$cj_user = get_userdata(1);
			// Process from
			$cj_subject = "CJ-Datafeed Request -> ";
			$cj_subject .= wp_strip_all_tags($_REQUEST['cj_support_subject']);
			$cj_description = wp_strip_all_tags($_REQUEST['cj_support_description']);
			// Add email and website url to description
			$cj_description .=" Reply to : ".$cj_user->user_email." ";			
			$cj_description .= " From : ".home_url()." ";
			// echo"$cj_subject<br>";
			// echo"$cj_description<br>";
			$email_to = "contact@hytekk.com";
			wp_mail ($email_to, $cj_subject, $cj_description);
			cj_admin_message("Message send...");
			cj_admin_message("A donation is a great way to improve CJ-Datafeed!");
			break;	
}

?> 

<p>
<table class="widefat">
<thead>
	<tr>
		<th>Reports bugs, send ideas or just say hello ! </th>
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
		<form name="cj_template" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data" method="post">
			<?php wp_nonce_field('cj_support_request');?>
			<input type="hidden" name="cj_action" value="cj_support"/>
			<table class='form-table'>
				<tr><th scope='row'><label for='cj_support_subject'>Subject</label></th>
					<td><textarea name="cj_support_subject" id="cj_support_subject_id" cols="100" rows="1" tabindex="1"></textarea>			
					</td>
				</tr>
				<tr><th scope='row'><label for='cj_support_description'>Description</label></th>
					<td><textarea name="cj_support_description" id="cj_support_description_id" cols="100" rows="5" tabindex="1"></textarea>
					</td>
				</tr>
				<tr><td>
					<input type="submit" name="cj_submit_request" value="Send Message" class='button-primary'>
				</td></tr>
			</table>
			</form>	
		</td>
	</tr>
</tbody>
</table>
<br /><br />

<table class="widefat">
<thead>
	<tr>
		<th>Hytekk.com Latest News</th>
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
		
		</td>
	</tr>
	<tr>
		<td>
		<div class="rss-widget">
		<?php	
		wp_widget_rss_output( array(
			'url' => 'http://hytekk.com/feed/',
			'title' => 'RSS Feed News',
			'items' => 10,
			'show_summary' => 0,
			'show_author' => 0,
			'show_date' => 1 
		) );?>
		</div>
		</td>
	</tr>
</tbody>
</table>
<br />


<table class="widefat">
<thead>
	<tr>
		<th>Recommended</th>
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
		<a href="http://www.amazon.ca/gp/product/0470916222/ref=as_li_tf_tl?ie=UTF8&tag=cjdatafeed-20&linkCode=as2&camp=15121&creative=330641&creativeASIN=0470916222">Professional WordPress Plugin Development</a><img src="http://www.assoc-amazon.ca/e/ir?t=cjdatafeed-20&l=as2&o=15&a=0470916222" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
		</td>
	</tr>
	<tr>
		<td>
		<a  href="http://click.linksynergy.com/fs-bin/click?id=QqqXPXqmHuw&offerid=173675.10000002&type=3&subid=0" >#1 Wordpress Theme Generator. Instantly create great looking and professional Wordpress Themes.</a><IMG border=0 width=1 height=1 src="http://ad.linksynergy.com/fs-bin/show?id=QqqXPXqmHuw&bids=173675.10000002&type=3&subid=0" >
		</td>
	</tr>
	
	<tr>
		<td>
		Up to 5 free Domains for life with 1&1 Hosting Plans. Get yours!
		<form action="http://www.tkqlhce.com/interactive">
		  	<input name="domain"/>
				  <select name="tld">
				    <option>com</option>
				    <option>net</option>
				    <option>org</option>
				    <option>info</option>
				    <option>name</option>
				    <option>us</option>
				    <option>biz</option>
				    <option>tv</option>
				    <option>ws</option>
				    <option>cc</option>
				    <option>mobi</option>
				  </select>
			<input value="Check Domain" type="submit"/> 
			<input type="hidden" name="aid" value="10376103"/>
			<input type="hidden" name="pid" value="1449968"/>
			<input type="hidden" name="url" value="http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a"/>
		</form><img src="http://www.tqlkg.com/n6122jy1qwuFHKKPPMOFHGJNMHGJ" width="1" height="1" border="0"/>
		</td>
	</tr>
</tbody>
</table>

<br />

						
</div> 
