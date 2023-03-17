<?php

class mf_password_protected
{
	function __construct()
	{
		$this->meta_prefix = 'mf_password_protected_';
	}

	function settings_password_protected()
	{
		$options_area = __FUNCTION__;

		add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

		$arr_settings = array();
		$arr_settings['setting_password_protected_message'] = __("Password Protected Message", 'lang_password_protected');

		show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
	}

	function settings_password_protected_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);

		echo settings_header($setting_key, __("Password Protected", 'lang_password_protected'));
	}

		function setting_password_protected_message_callback()
		{
			$setting_key = get_setting_key(__FUNCTION__);
			$option = get_option($setting_key);

			echo show_wp_editor(array('name' => $setting_key, 'value' => $option, 'editor_height' => 200));
		}

	function rwmb_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = array(
			'id' => $this->meta_prefix.'settings',
			'title' => __("Settings", 'lang_password_protected'),
			'post_types' => array('page'),
			'context' => 'normal',
			'priority' => 'low',
			'fields' => array(
				array(
					'name' => __("Custom Message", 'lang_password_protected'),
					'id' => $this->meta_prefix.'message',
					'type' => 'wysiwyg',
				),
			)
		);

		return $meta_boxes;
	}

	function the_password_form($html)
	{
		global $post;

		$setting_password_protected_message = get_option('setting_password_protected_message');

		if($post->ID > 0)
		{
			$post_password_protected_message = get_post_meta($post->ID, $this->meta_prefix.'message', true);

			if($post_password_protected_message != '')
			{
				$setting_password_protected_message = $post_password_protected_message;
			}
		}

		if($setting_password_protected_message != '')
		{
			$html = str_replace(__("This content is password protected. To view it please enter your password below:"), $setting_password_protected_message, $html);
		}

		return $html;
	}

	/*add_filter('the_content', 'wpfilter_password_protected_message');

	function wpfilter_password_protected_message($content)
	{
		global $post;

		if(!empty($post->post_password))
		{
			$content = str_replace('This content is password protected. To view it please enter your password below:', get_post_meta($post->ID, 'mao_custom_password_text', true) ,$content);
		}

		return $content;
	}*/
}