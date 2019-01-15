<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/genesis/
 */

remove_action( 'genesis_before_content', 'custom_breadcrumbs' );

add_action( 'genesis_loop', 'luna_loop' );
function luna_loop() {

    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <style type="text/css" media="screen">.nav-primary ul li:first-of-type a {color: #c93; }</style>
    <article class="post">
        <div class="thumbnail"><a class="entry-image-link" href="<?php the_permalink(); ?>" aria-hidden="true"><?php echo(the_post_thumbnail( 'full' ) ); ?></a></div>

        <span class="category"><a rel="category-tag"><?php the_category( ', ' ); ?></a></span>

         <!-- Display the Title as a link to the Post's permalink. -->
         <header class="entry-header">
            <h2 class="entry-title" itemprop="headline"">
                <a href="<?php the_permalink() ?>" class="entry-title-link" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </h2>
        </header>
         <span class="title-divider"></span>

         <?php the_excerpt(); ?>

        </article> <!-- closes the first div box -->


     <?php endwhile;
     wp_reset_postdata();
     endif;
}
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Initialize Genesis.
genesis();
