<?php
/**
 * Plugin Name: walker-section
 * Plugin URI: https://firmwaree.com/
 * Description: An eCommerce toolkit that helps you sell anything. Beautifully.
 * Version: 3.3.5
 * Author: goniusman
 * Author URI: https://firmwaree.com
 *
 * Text Domain: firmwaree
 *
 * @package walker-section
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
	}


define('connect_plugin_file', WP_PLUGIN_URL. '/' . plugin_basename(dirname(__FILE__)).'/');


function connect_all_walker_file(){
	wp_enqueue_style('walker-css', connect_plugin_file.'/assets/css/walker.css');

	wp_enqueue_script('jquery');
	wp_enqueue_media();
	wp_enqueue_script('walker-js', connect_plugin_file.'/assets/js/walker.js', array('jquery'), 'v1.1', false);
}
add_action('wp_enqueue_scripts', 'connect_all_walker_file');


include_once('inc/wallker.php');
include_once('inc/menufields.php');