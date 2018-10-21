<?php
/**
 * @package  GoodsDonationPlugin
 */
/*
Plugin Name: Goods Donation Plugin
Plugin URI: http://alecaddd.com/plugin
Description: This is my first attempt on writing a custom Plugin for this amazing tutorial series.
Version: 1.0.0
Author: Alessandro "Alecaddd" Castellani
Author URI: http://alecaddd.com
License: GPLv2 or later
Text Domain: alecaddd-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

//defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );
//if (!function_exists('wp_get_current_user')) { 
//	include(ABSPATH . "wp-includes/pluggable.php"); 
//}



class GoodsDonationPlugin
{

	public $plugin_path;

	public $plugin_url;

	public $plugin;


	public function __construct() {
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->plugin_url = plugin_dir_url( __FILE__);
		$this->plugin = plugin_basename( __FILE__ ) . '/goods-donation-plugin.php';

		// add the donee_role
		add_action('init', array($this, 'add_donee_role'));

		// add gds24_donee_role capabilities, priority must be after the initial role definition
		add_action('init', array($this, 'add_donee_role_caps'), 11);

		//if (current_user_can('show_donations_in_my_account')) {
		
			add_action( 'init', array($this, 'my_custom_endpoints'));
			add_action( 'wp_enqueue_scripts', array($this, 'my_enqueue') );
			add_action( 'wp_ajax_my_action', array($this, 'my_action') );
	
			add_filter( 'query_vars', array($this, 'my_custom_query_vars'), 0 );
			add_filter( 'woocommerce_account_menu_items', array($this, 'my_custom_my_account_menu_items') );

			add_action( 'woocommerce_account_my-custom-endpoint_endpoint', array($this, 'my_custom_endpoint_content') );


			add_filter( 'the_title', array($this, 'my_custom_endpoint_title') );
	
		//}
		

		


    }
    function activate() {

		flush_rewrite_rules();
    }
    function deactivate() {
		flush_rewrite_rules();
	
	}
	
	function my_enqueue() {

		wp_enqueue_script( 'ajax-script', $this->plugin_url . '/js/my-ajax-script.js', array('jquery') );
	
		wp_localize_script( 'ajax-script', 'my_ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}


	function my_action() {
		global $wpdb; // this is how you get access to the database

		$id = $_POST['id'] ; 
		$donee =  $_POST['value'];
		$checked = $_POST['checked'] ; 
		
		if ($checked=="true") {
			$result = wp_set_object_terms($id, $donee, 'Donees');
		}
		else {
			$result = wp_remove_object_terms($id, $donee, 'Donees');
		}
			
	
		if ($result==TRUE) {
			echo '{result:true}';
		}
		else {
			echo '{result:false}';
		}

	
		wp_die(); // this is required to terminate immediately and return a proper response
	}

	/**
	 * Register new endpoint to use inside My Account page.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
	 */
	function my_custom_endpoints() {
		add_rewrite_endpoint( 'my-custom-endpoint', EP_ROOT | EP_PAGES );
		
	}



	/**
	 * Add new query var.
	 *
	 * @param array $vars
	 * @return array
	 */
	function my_custom_query_vars( $vars ) {
		$vars[] = 'my-custom-endpoint';

		return $vars;
	}




	/**
	 * Custom help to add new items into an array after a selected item.
	 *
	 * @param array $items
	 * @param array $new_items
	 * @param string $after
	 * @return array
	 */
	function my_custom_insert_after_helper( $items, $new_items, $after ) {
		// Search for the item position and +1 since is after the selected item key.
		$position = array_search( $after, array_keys( $items ) ) + 1;

		// Insert the new item.
		$array = array_slice( $items, 0, $position, true );
		$array += $new_items;
		$array += array_slice( $items, $position, count( $items ) - $position, true );

		return $array;
	}

	/**
	 * Insert the new endpoint into the My Account menu.
	 *
	 * @param array $items
	 * @return array
	 */
	function my_custom_my_account_menu_items( $items ) {
		$new_items = array();
		$new_items['my-custom-endpoint'] = __( 'Donations', 'woocommerce' );

		// Add the new item after `orders`.
		return $this->my_custom_insert_after_helper( $items, $new_items, 'orders' );
	}

	/*
	function my_custom_endpoint_content() {
		echo '<p>Plugin Donations</p>';
	}
	*/
	/**
	 * Endpoint HTML content.
	 */
	function my_custom_endpoint_content() {
		// echo '<p>Plugin Donations</p>';
		if ( file_exists( dirname( __FILE__ ) . '/templates/my_account_donations.php' ) ) {
			require_once dirname( __FILE__ ) . '/templates/my_account_donations.php';
		}
	}



	/*
	* Change endpoint title.
	*
	* @param string $title
	* @return string
	*/
	function my_custom_endpoint_title( $title ) {
		global $wp_query;

		$is_endpoint = isset( $wp_query->query_vars['my-custom-endpoint'] );

		if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
			// New page title.
			$title = __( 'Donations', 'woocommerce' );

			remove_filter( 'the_title', array($this, 'my_custom_endpoint_title') );
		}

		return $title;
	}

	function add_donee_role()
	{
		$customer_cap_set = get_role( 'customer' )->capabilities;
		add_role(
			'gds24_donee_role',
			'Donee Role',
			$customer_cap_set
		);
	}
	
	function add_donee_role_caps()
	{
		// gets the donee_role role object
		$role = get_role('gds24_donee_role');
	 
		// add a new capability
		$role->add_cap('show_donations_in_my_account', true);
	}
	 




}

if ( class_exists( 'GoodsDonationPlugin' ) ) {
	$goodsDonationPlugin = new GoodsDonationPlugin();
}
// activation
register_activation_hook( __FILE__, array( $goodsDonationPlugin, 'activate' ) );

// deactivation
register_deactivation_hook( __FILE__, array( $goodsDonationPlugin, 'deactivate' ) );


