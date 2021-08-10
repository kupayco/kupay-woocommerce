<?php

$KUPAY_API_KEY = "123ABC";

function create_settings_menu(){

	$page_title = 'KuPay Settings';
	$menu_title = 'KuPay';
	$capability = 'manage_options';
	$menu_slug  = 'extra-post-info';
	$function   = 'create_settings_page';
	$icon_url   = 'dashicons-media-code';
	$position   = 4;

	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

}

function create_settings_page(){
	echo "KuPay Settings";
}
