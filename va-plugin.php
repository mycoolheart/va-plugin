<?php 
/*
 * Plugin Name: va plugin
 * Description: va plugin description
 * Author: Viktor Androshuck
 * Author URI: https://androshuck.ru/
 * Version: 1.0
 * Requires at least: 6.3
 * Requires PHP: 7.4
 */

if(!defined('ABSPATH')){
	die;
}

define("SETTING_STRING", 'sample');

class vaPlugin{

	function register(){

		add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue'] );
		add_action( 'wp_enqueue_scripts', [$this, 'front_enqueue'] );

		add_action( 'admin_menu', [$this, 'add_setting_page'] );
		add_filter('plugin_action_links_'.plugin_basename(__FILE__), [$this, 'add_plugin_settings_link']);

		add_action( 'init', [$this, 'register_custom_posts'] );

		require_once plugin_dir_path( __FILE__ ).'inc/acf-fields.php';
	}

	public function admin_enqueue(){
		wp_enqueue_style('va-admin_style', plugins_url( 'assets/css/style.css', __FILE__ ), false, true);
		wp_enqueue_script('va-admin_script', plugins_url( 'assets/js/script.js', __FILE__ ), array('jquery'), false, true);
	}

	public function front_enqueue(){
		//wp_enqueue_style('bootstrap', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ));

		wp_enqueue_style('va_style', plugins_url( 'assets/css/front-style.css', __FILE__ ), false, true);
		wp_enqueue_script('va_script', plugins_url( 'assets/js/front-script.js', __FILE__ ), array('jquery'), false, true);		
	}

	public function add_setting_page(){
		
		add_menu_page(
			esc_html__('va plugin', 'vaplugin'),
			esc_html__('va plugin', 'vaplugin'),
			'manage_options',
			'va-plugin-settings',
			[$this, 'main_admin_page'],
			'dashicons-dashboard',
			15
		);

		add_submenu_page(
			'va-plugin-settings',
			esc_html__('va plugin sub page', 'vaplugin'),
			esc_html__('va plugin sub page', 'vaplugin'),
			'manage_options',
			'va-plugin-settings-adds',
			[$this, 'main_admin_page_sub'],
			15
		);

	}


	public function add_plugin_settings_link($link){
		$va_link = '<a href="admin.php?page=acf-options-settings">Settings</a>';
		array_push($link, $va_link);

		return $link;
	}

	public function main_admin_page(){
		require_once plugin_dir_path( __FILE__ ).'admin/page-settings.php';
	}
	public function main_admin_page_sub(){
		require_once plugin_dir_path( __FILE__ ).'admin/page-settings-additional.php';
	}

	public function register_custom_posts(){
		register_post_type( 'va_plugin_post_type', [
		  'label'  => null,
		  'labels' => [
		    'name'               => 'va plugin',
		    'singular_name'      => 'va plugin',
		    'parent_item_colon'  => '',
		    'menu_name'          => 'va plugin',
		  ],
		  'public'                 => true,
		  'show_in_menu'           => 'va-plugin-settings',
		  'hierarchical'        => false,
		  'supports'            => [ 'title', 'custom-fields', 'editor', 'thumbnail', 'page-attributes' ],
		  'has_archive'         => false,
		  'rewrite'             => true,
		  'query_var'           => true,
		] );
	}

	static function activation(){
		//global $wpdb;
	}

	static function deactivation(){

	}

	static function unistall(){

	}
}

if( class_exists('vaPlugin') ){
	$vaPlugin = new vaPlugin();
	$vaPlugin->register();
}

register_activation_hook( __FILE__, array($vaPlugin, 'activation') );

register_deactivation_hook( __FILE__, array($vaPlugin, 'deactivation') );

register_uninstall_hook( __FILE__, array($vaPlugin, 'unistall') );