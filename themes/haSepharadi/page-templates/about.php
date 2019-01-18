<?php
/**
 * Template Name: About Page
 *
 * @package haSepharadi
 * @since haSepharadi 1.1.0
 */

add_action( 'wp_enqueue_scripts', 'enqueue_about_styles' );
function enqueue_about_styles() {
    wp_enqueue_style( 'about.css', CHILD_URL . '/css/about.css', array(), CHILD_THEME_VERSION );
}

add_action( 'genesis_after_entry', 'display_about_widgets' );
function display_about_widgets() { ?>
    <div class="about-widgets">
    <?php if ( have_rows( 'about_widgets' ) ) : 
        remove_filter( 'acf_the_content', 'wpautop' );
        while ( have_rows( 'about_widgets' ) ) : the_row(); ?>

            <?php if (get_row_index() === 1) { ?>
                <div class="about-widget-row one-third first">
            <?php } else { 
                ?>
                <div class="about-widget-row one-third">
            <?php }
                
            // echo("<br>Row Index: " . get_row_index() . "<br>");
            $image = get_sub_field( 'widget_image' );
            $id = get_the_ID($image);
            // echo("<br><br><br>$id<br><br><br>"); 

            if ( $image ) {
                echo wp_get_attachment_image( $image['id'], 'thumbnail', $image['alt'], array("class" => "attachment-thumbnail size-thumbnail") ); 
            } 
            ?>

            <div class="about-widget-title"><?php the_sub_field( 'widget_title' ); ?></div>
            <p class="about-widget-text"><?php the_sub_field( 'widget_text' ); ?></p>
            </div> 
            
            <?php
        endwhile; 
    else : 
        // no rows found 
    endif; ?>
    </div>
    <?php 
}

genesis();