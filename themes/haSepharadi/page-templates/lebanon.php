<?php
/**
 * Template Name: Lebanon
 * Template Post Type: post
 *
 * @package haSepharadi
 * @since haSepharadi 1.1.0
 */
?>

<?php

add_action( 'wp_enqueue_scripts', 'load_single_post_styles' );
function load_single_post_styles() {
		wp_enqueue_style( 'single-posts', CHILD_URL . '/css/single-post.css', array(), CHILD_THEME_VERSION );
		wp_enqueue_style( 'lebanon.css', CHILD_URL . '/css/lebanon.css', array(), CHILD_THEME_VERSION );
}

// add_action('wp_enqueue_scripts', 'load_single_post_styles');
// function load_single_post_styles() {
//     wp_enqueue_script('single-post', CHILD_URL . '/css/single-post.css', array(), CHILD_THEME_VERSION );
// }

add_action( 'genesis_loop', 'luna_loop' );
function luna_loop() {

		$post_url = urlencode( get_permalink() );
		// $post_url = get_permalink();
		$post_title = htmlspecialchars( urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8') ), ENT_COMPAT, 'UTF-8' );
		$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		// $post_url = get_permalink();

		 if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		 <style type="text/css" media="screen">.nav-primary ul li:first-of-type a {color: #c93; }</style>
		 <article class="post">
				<div class="thumbnail">
						<a class="entry-image-link" href="<?php the_permalink(); ?>" aria-hidden="true"><?php echo(the_post_thumbnail( 'full' ) ); ?></a>
				</div>

				<span class="category entry-categories">
						<a rel="category-tag"><?php the_category( ', ' ); ?></a>
				</span>
				<header class="entry-header"><h2 class="entry-title" itemprop="headline"><a href="<?php the_permalink() ?>" class="entry-title-link" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></header>
				<span class="entry-author" itemprop="author" itemscope="" itemtype="https://schema.org/Person">
						<?php
								$author_link = get_the_author_posts_link();
								echo($author_link);
								?>
				</span>
				<span class="title-divider"></span>

				<div class="entry-content" itemprop="text">
					<?php if ( have_rows( 'lebanon_content' ) ): ?>
						<?php while ( have_rows( 'lebanon_content' ) ) : the_row(); ?>
							<?php if ( get_row_layout() == 'full_width_text' ) : ?>
								<?php the_sub_field( 'text_row' ); ?>
							<?php elseif ( get_row_layout() == 'img_and_text' ) : ?>
								<div class="img-and-txt">
									<?php $image_left = get_sub_field( 'image_left' ); ?>
									<?php if ( $image_left ) { ?>
										<figure id="attachment_<?php echo $image_left['id']; ?>" aria-describedby="caption-attachment-<?php echo $image_left['id']; ?>" class="wp-caption alignleft">
										<img class="img-one-third lazy wp-image-<?php echo $image_left['id']; ?> lazy-loaded" src="<?php echo $image_left['url']; ?>" alt="<?php echo $image_left['alt']; ?>" />
									<?php } ?>
									<figcaption id="caption-attachment-<?php echo($image_left['id']); ?>" class="wp-caption-text"><span style="font-family: 'times new roman', times; font-size: 10pt;"><?php echo $image_left['caption'] ?></span></figcaption></figure>
									<div class="text-two-thirds">
										<?php the_sub_field( 'text_right' ); ?>
									</div>
								</div>

							<?php elseif ( get_row_layout() == 'img_col_2' ) : ?>
								<div class="img-and-img">
									<?php $img_one = get_sub_field( 'img_one' ); ?>
									<?php if ( $img_one ) { ?>
										<div class="img-one-half">
											<figure id="attachment_<?php echo $img_one['id']; ?>" aria-describedby="caption-attachment-<?php echo $img_one['id']; ?>" class="wp-caption">
												<img src="<?php echo $img_one['url']; ?>" class="" alt="<?php echo $img_one['alt']; ?>" />
									<?php } ?>
									<figcaption id="caption-attachment-<?php echo($img_one['id']); ?>" class="wp-caption-text"><span style="font-family: 'times new roman', times; font-size: 10pt;"><?php echo $img_one['caption'] ?></span></figcaption>
								</figure>
								</div>

									<?php $img_2 = get_sub_field( 'img_2' ); ?>
									<?php if ( $img_2 ) { ?>
									<div class="img-one-half">
										<figure id="attachment_<?php echo $img_2['id']; ?>" aria-describedby="caption-attachment-<?php echo $img_2['id']; ?>" class="wp-caption">
										<img src="<?php echo $img_2['url']; ?>" class="" alt="<?php echo $img_2['alt']; ?>" />
									<?php } ?>
									<figcaption id="caption-attachment-<?php echo $img_2['id']; ?>" img="<?php echo($img_2['id']); ?>" class="wp-caption-text"><span style="font-family: 'times new roman', times; font-size: 10pt;"><?php echo $img_2['caption'] ?></span></figcaption>
								</figure>
									</div>
								</div>

							<?php endif; ?>
						<?php endwhile; ?>
					<?php else: ?>
						<?php // no layouts found ?>
					<?php endif; ?>

				<?php echo( do_shortcode( '[jetpack-related-posts]' ) ); ?>

				<footer class="entry-tools">
				<?php
				the_date( 'F j, Y', '<span>', '</span>', true );
				luna_social_sharing_buttons();
				?>
				</footer>
		</article> <!-- closes the first div box -->

		 <?php endwhile;
		 wp_reset_postdata();
		 endif;
}
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Initialize Genesis.
genesis();
