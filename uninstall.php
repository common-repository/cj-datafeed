<?php
/****************************************************************************************************/	
/*	CJ-Datafeed																						*/
/*	Uninstall function																				*/
/****************************************************************************************************/	

if (!defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit();
}
	delete_option('cj_options');
?>