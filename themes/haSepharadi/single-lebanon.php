<?php
/**
 * Template Name: Lebanon
 *
 * @package haSepharadi
 * @since haSepharadi 1.1.0
 */
?>

<?php if ( have_rows( 'lebanon_content' ) ): ?>
	<?php while ( have_rows( 'lebanon_content' ) ) : the_row(); ?>
		<?php if ( get_row_layout() == 'full_width_text' ) : ?>
			<?php the_sub_field( 'text_row' ); ?>
		<?php elseif ( get_row_layout() == 'img_and_text' ) : ?>
			<?php $image_left = get_sub_field( 'image_left' ); ?>
			<?php if ( $image_left ) { ?>
				<img src="<?php echo $image_left['url']; ?>" alt="<?php echo $image_left['alt']; ?>" />
			<?php } ?>
			<?php the_sub_field( 'text_right' ); ?>
		<?php elseif ( get_row_layout() == 'img_col_2' ) : ?>
			<?php $img_one = get_sub_field( 'img_one' ); ?>
			<?php if ( $img_one ) { ?>
				<img src="<?php echo $img_one['url']; ?>" alt="<?php echo $img_one['alt']; ?>" />
			<?php } ?>
			<?php $img_2 = get_sub_field( 'img_2' ); ?>
			<?php if ( $img_2 ) { ?>
				<img src="<?php echo $img_2['url']; ?>" alt="<?php echo $img_2['alt']; ?>" />
			<?php } ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php else: ?>
	<?php // no layouts found ?>
<?php endif; ?>

<?php
genesis();
