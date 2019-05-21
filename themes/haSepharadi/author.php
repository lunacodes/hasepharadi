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

add_action('wp_enqueue_scripts', 'enqueue_author_styles');
function enqueue_author_styles() {
		wp_enqueue_style('author.css', CHILD_URL . '/css/author.css', array(), CHILD_THEME_VERSION );
}

add_action( 'genesis_before_loop', 'haSepharadi_cat_header' );
function haSepharadi_cat_header() {
	$open = '<div class="archive-description taxonomy-archive-description taxonomy-description"><h1 class="archive-title"><span>';
	$title = get_the_author();
	// echo($title);
	$close = '</span></h1></div>';
	echo($open . $title . $close);
}

add_action( 'genesis_loop', 'luna_cat_loop' );
function luna_cat_loop() {
	if ( have_posts() ): while ( have_posts() ) : the_post();
		?>
	 <article class="post">
		<div class="thumbnail">
			<a class="entry-image-link" href="<?php the_permalink(); ?>" aria-hidden="true"><?php echo(the_post_thumbnail( 'full' ) ); ?></a>
		</div>

		<span class="category"><a rel="category-tag"><?php the_category( ', ' ); ?></a></span>

		 <!-- Display the Title as a link to the Post's permalink. -->
		 <header class="entry-header"><h2 class="entry-title" itemprop="headline"><a href="<?php the_permalink() ?>" class="entry-title-link" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></header>
		 <span class="title-divider"> </span>

		<div class="entry-content" itemprop="text"> <?php the_excerpt(); ?> </div>

		<footer class="entry-tools"> <span><?php the_date('F j, Y'); ?></span> <a href="https://hasepharadi.com/2018/03/23/peacefood-for-thought/" class="morelink">Continue to read <i class="fa fa-long-arrow-right"></i></a> </footer>
	 </article> <!-- closes the first div box -->


	 <?php
	 // Setup for display_affiliate_links().
	 $user_id = get_the_author_meta( 'ID' );

	 // Define prefixed user ID
	 $user_acf_prefix = 'user_';
	 $user_id_prefixed = $user_acf_prefix . $user_id;

		display_affiliate_links($user_id_prefixed);
		endwhile;

	 wp_reset_postdata($user_id_prefixed);
	 endif;
}

function display_affiliate_links($user_id_prefixed) {
	$user_id = get_the_author_meta( 'ID' );
	$user_acf_prefix = 'user_';
	$user_id_prefixed = $user_acf_prefix . $user_id;
	?>

	<div class="affiliates-container">
	<?php
	if ( function_exists( 'have_rows' ) ) {
		if ( have_rows( 'affiliate_links', $user_id_prefixed ) ) :
			while ( have_rows( 'affiliate_links', $user_id_prefixed ) ) : the_row();
				$count = count( have_rows( 'affiliate_links', $user_id_prefixed ) );
				echo( $count );
				if ( 0 == ($count % 3) ) {
					if ($count <= 3) {
						$affiliate_class - 'affiliate-item';
					} elseif ( $count > 3 ) {
						$affiliate_class = 'affiliate-item row-fix';
					}
				} else {
					$affiliate_class = 'affiliate-item';
				}

				$affiliate_image = get_sub_field( 'affiliate_image' );
				$size = 'medium';
				$thumb = $affiliate_image['sizes'][ $size ];
				$width = $affiliate_image['sizes'][ $size . '-width' ];
				$height = $affiliate_image['sizes'][ $size . '-height' ];
				?>
			<div class="<?php echo $affiliate_class; ?>">
				<img class="affiliate-img"src="<?php echo $affiliate_image['url']; ?>" alt="<?php echo $affiliate_image['alt']; ?>" width="<?php echo($width); ?>" height="<?php echo($height); ?>" />
				<a class="affiliate-link-text" href="<?php the_sub_field( 'affiliate_url' ); ?>"><?php
				the_sub_field( 'affiliate_link_text' ); ?></a>
			</div>

			<?php
			endwhile;
		endif;
		// display_author_bio();

	}

	?>
	</div>
	<?php
}

add_action( 'genesis_after_loop', 'display_author_bio_2' );
function display_author_bio_2() {

	?>
		<div class="author-box">
			<!-- <h2 class="author-box-title">About Author</h2> -->
			<div class="author-img"><a href="<?php echo( esc_url( get_author_posts_url( get_the_author_meta('ID') ) ) ) ?>" title="<?php esc_attr( get_the_author() ); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), '80'); // Display the author gravatar image with the size of 80 ?></a></div>
			<h3 class="author-name"><?php esc_html(the_author_meta('display_name')); // Displays the author name of the posts ?></h3>
			<p class="author-description"><?php esc_textarea(the_author_meta('description')); // Displays the author description added in Biographical Info ?></p>
		</div>
	<?php
}

genesis();
