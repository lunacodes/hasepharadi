<?php
/*
Plugin Name: Luna Affiliates Widget
Plugin URI: https://lunacodesdesign.com
Description: Display affiliate links in sidebar
Author URI: https://lunacodesdesign.com
Text Domain: luna_afl
Version 1.1
 */

if ( file_exists( dirname( __FILE__ ) . '/luna-affiliates-widget.php') ) {
    require_once dirname( __FILE__ ) . '/luna-affiliates-widget.php';
}

add_action( 'wp_enqueue_scripts', 'luna_afl_load_plugin_css' );
function luna_afl_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style', $plugin_url . 'assets/css/afl-style.css' );
    // wp_enqueue_script( 'afl-script', $plugin_url . 'assets/js/afl-script.js', array('jquery') );
    // wp_enqueue_style( 'icons', $plugin_url . 'assets/css/fontello.css' );
}
