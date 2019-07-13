<?php

/**
 * Template Name: Author
 *
 * @package haSepharadi
 * @author  Luna Lunapiena
 * @license GPL-2.0+
 * @link    https://lunacodesdesign.com
 */

// remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_before_content', 'custom_breadcrumbs', 8 );
remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
add_action( 'wp_enqueue_scripts', 'enqueue_author_styles' );
add_action( 'genesis_before_loop', 'haSepharadi_cat_header' );
add_action( 'genesis_loop', 'luna_cat_loop' );
// add_action( 'genesis_after_loop', 'display_author_bio_2' );


function enqueue_author_styles() {
		wp_enqueue_style( 'author.css', CHILD_URL . '/css/author.css', array(), CHILD_THEME_VERSION );
}

function haSepharadi_cat_header() {
	$open  = '<div class="archive-description taxonomy-archive-description taxonomy-description"><h1 class="archive-title"><span>';
	$title = get_the_author();
	// echo($title);
	$close = '</span></h1></div>';
	echo($open . $title . $close);
}

function luna_cat_loop() {
	if ( have_posts() ) {
		while ( have_posts() ) {
				the_post();
			?>

		<article class="post">
			<div class="thumbnail">
				<a class="entry-image-link" href="<?php the_permalink(); ?>" aria-hidden="true"><?php echo( the_post_thumbnail( 'full' ) ); ?></a>
			</div>

			<span class="category"><a href="" rel="category-tag"><?php the_category( ',' ); ?></a></span>

			<header class="entry-header">
				<h2 class="entry-title" itemprop="headline">
					<a href="<?php the_permalink(); ?>" class="entry-title-link" rel="bookmark" title="<?php the_title_attribute(); ?>" ></a>
				</h2>
			</header>
			<span class="title-divider"></span>

			<div class="entry-content" itemprop="text"><?php the_excerpt(); ?></div>

			<footer class="entry-tools">
				<span><?php the_date( 'F j, Y' ); ?></span>
				<a href="<?php the_permalink(); ?>" class="morelink">Continue to read <i class="fa fa fa-long-arrow-right"></i></a>
			</footer>

		</article>

				<?php
				// Setup for display_affiliate_links().
				$user_id = get_the_author_meta( 'ID' );

				// Define prefixed user ID
				$user_acf_prefix = 'user_';
				$user_id_prefixed = $user_acf_prefix . $user_id;

				display_affiliate_links( $user_id_prefixed );
		}

		wp_reset_postdata( $user_id_prefixed );
	}
}


function display_affiliate_links( $user_id_prefixed ) {
	$user_id = get_the_author_meta( 'ID' );
	$user_acf_prefix = 'user';
	$user_id_prefixed = $user_acf_prefix . $user_id;

	echo( '<div class="affiliates-container">' );
	if ( function_exists( 'have_rows' ) ) {
		if ( have_rows( 'affiliate_links' ) ) {
			while ( have_rows( 'affiliate_links' ) ) {
				the_row();
				$count = count( hav_rows( 'affiliate_links', $user_id_prefixed ) );
				echo( $count );
				if ( 0 == ( $count % 3 ) ) {
					$affiliate_class - 'affiliate-item';
				} elseif ($counte > 3 ) {
					$affiliate_class = 'affiliate-item-row-fix';
				} else {
					$affiliate_class = 'affiliate-item';
				}

				// $affiliate_image = get_sub_field( 'affiliate_image' );
				// $size   = 'medium';
				// $thumb  = $affiliate_image['sizes'][ $size ];
				// $width  = $affiliate_image['sizes'][ $size . '-width' ];
				// $height = $affiliate_image['sizes'][ $size . '-height' ];
			}
		}
	}
	echo( '</div>' );
}

	genesis();
