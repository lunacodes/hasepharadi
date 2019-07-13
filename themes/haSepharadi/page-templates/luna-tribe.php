<?php
/**
 * Template Name: Luna Tribe Events Page
 *
 * @package haSepharadi
 * @since haSepharadi 1.1.0
 */

// echo( 'Luna Tribe Events' );
remove_action( 'genesis_after_loop', 'display_author_bio', 11 );
remove_action( 'genesis_after_loop', 'display_fb_comments' );
remove_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
?>

<style>
	.author-box {
		display: none !important;
	}
</style>
<?php

genesis();
