<?php
/*
Plugin Name: CJ-Datafeed
Plugin URI: http://hytekk.com/
Description: Create post from CJ datafeed file the easy way
Author: Hytekk
Author URI: http://hytekk.com
Version: 1.5
*/

/*
Copyright (C) 2010-2011 Hytekk.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Include functions file

include("cj-functions.php");
include("cj-install.php");		// include all functions for cj_install_clean();

// Function to run when plugin is activated
register_activation_hook(__FILE__,'cj_install');

function cj_install () {
	cj_install_options();
}

// Hook for adding admin menus
add_action('admin_menu', 'cj_add_pages');


// action function for above hook
function cj_add_pages() {

	add_menu_page('-- CJ-Datafeed -- ', 'CJ-Datafeed', 'administrator', 'cj-admin', 'cj_admin_page',includes_url( '/images/wpmini-blue.png',__FILE__));
	add_submenu_page('cj-admin', '-- CJ-Datafeed -- Instructions --', 'CJ-HowTo', 'administrator', 'cj-howto', 'cj_howto_page');
	add_submenu_page('cj-admin', '-- CJ-Datafeed -- Create Post --', 'CJ-CreatePost', 'administrator', 'cj-createpost', 'cj_create_page');
	add_submenu_page('cj-admin', '-- CJ-Datafeed -- Delete Posts --', 'CJ-Delete', 'administrator', 'cj-delete', 'cj_delete_page');
	   		  
}

// Display admin page function
function cj_admin_page() {
    include"cj-admin.php";
}

function cj_howto_page() {
    include"cj-howto.php";
}

function cj_create_page() {
    include"cj-create-posts.php";
}

function cj_delete_page() {
    include"cj-delete.php";
}




