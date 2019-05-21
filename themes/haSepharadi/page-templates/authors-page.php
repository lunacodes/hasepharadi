<?php
/**
 * Template Name: Authors Page
 *
 * @package haSepharadi
 * @since haSepharadi 1.1.8
 */

add_action( 'wp_enqueue_scripts', 'enqueue_authors_page_styles' );
function enqueue_authors_page_styles() {
    wp_enqueue_style( 'authors-page.css', CHILD_URL . '/css/authors-page.css', array(), CHILD_THEME_VERSION );
}

add_action( 'genesis_loop', 'display_site_authors' );
function display_site_authors() {
	$args = array(
		'role' => 'author',
	);

	$author_query = new WP_User_Query( $args );
	$authors = $author_query->get_results();

	if ( $authors ) {
		foreach ( $authors as $author ) {
			$name = $author->display_name;
			$author_id = $author->ID;
			$author_thumb = get_avatar( $author_id, 200 );
			$author_bio = get_the_author_meta( $author_id, 'description' );
			$author_posts = get_author_posts_url( $author->ID );
	?>
			<div class="authors-wrap">
				<div class="author-box">
					<a href="<?php echo( $author_posts ); ?>">
						<div class="avatar-box">
							<?php echo( $author_thumb ) ?>
						</div>
						<span class="author-name"><?php echo( $name ); ?></span>
						<div class="author-bio"><?php echo( the_author_meta( 'description', $author_id ) ) ?></div>
					</a>
				</div>
			</div>
<?php
		}
	}
}

genesis();

