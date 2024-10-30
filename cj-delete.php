<?php
/****************************************************************************************************/	
/*	CJ-Datafeed																						*/
/*	Delete Page																						*/
/****************************************************************************************************/	
?>

<div class="wrap">
<?php

$cj_current_options	= get_option('cj_options');
$cj_version = $cj_current_options['cj_version'];
screen_icon('plugins');	

echo "<h2>CJ-Datafeed v$cj_version</h2>";
$cj_action = $_REQUEST['cj_action'];
switch ($cj_action)  {
	
	case 'cj_delete' :
		// Check if nounce is valid ...
		check_admin_referer ('cj_delete_adv');
		$del_adv_name = $_REQUEST['adv_name'];
		// echo "<h2>$del_adv_name To be deleted</h2>";
		cj_admin_message("$del_adv_name To be deleted");
		cj_clean($del_adv_name);				
		break;
}
cj_delete_select();
?>

</div> 