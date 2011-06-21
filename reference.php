<?php
	/*
	Plugin Name: Reference
	Plugin URI: https://github.com/nblue/Reference-Wordpress-Plugin
	Description: Add references from posts, urls, and books into your post.
	Author: Nice
	Version: 0.1
	Author URI: http://blog.u-blue.com
	*/
$x = WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
require_once($x.'inc/reference.class.php');
$reference = new Reference;

add_action( 'dbx_post_advanced', array( $reference, 'create_custom_fields' ) );
add_action( 'save_post', array( $reference, 'save_custom_fields' ),1,2 );
add_action( 'wp_print_styles', array( $reference, 'add_style' ) );
add_action( 'admin_menu',  array( $reference, 'plugin_menu' ) );
add_action( 'admin_init',  array( $reference, 'register_settings' ) );
add_filter( 'the_content', array( $reference, 'show' ) );
?>