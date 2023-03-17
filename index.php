<?php
/*
Plugin Name: MF Password Protected
Plugin URI: https://github.com/frostkom/mf_password_protected
Description: Wordpress plugin to change Password protected message
Version: 1.0.1
Licence: GPLv2 or later
Author: Martin Fors
Author URI: https://martinfors.se
Text Domain: lang_password_protected
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_password_protected
*/

if(!function_exists('is_plugin_active') || function_exists('is_plugin_active') && is_plugin_active("mf_base/index.php"))
{
	include_once("include/classes.php");

	load_plugin_textdomain('lang_password_protected', false, dirname(plugin_basename(__FILE__))."/lang/");

	$obj_password_protected = new mf_password_protected();

	if(is_admin())
	{
		register_uninstall_hook(__FILE__, 'uninstall_password_protected');

		add_action('admin_init', array($obj_password_protected, 'settings_password_protected'));

		add_action('rwmb_meta_boxes', array($obj_password_protected, 'rwmb_meta_boxes'));

	}

	else
	{
		add_filter('the_password_form', array($obj_password_protected, 'the_password_form'));
	}

	function uninstall_password_protected()
	{
		mf_uninstall_plugin(array(
			'options' => array('setting_password_protected_message'),
			'meta' => array('meta_password_protected_message'),
		));
	}
}