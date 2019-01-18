<?php

add_action( 'wp_enqueue_scripts', 'enqueue_404_styles' );
function enqueue_404_styles() {
    wp_enqueue_style( '404.css', CHILD_URL . '/css/404.css', array(), CHILD_THEME_VERSION );
}

add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_before_content', 'custom_breadcrumbs', 9 );

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_404_cust' );

/**
 * This function outputs a 404 "Not Found" error message.
 *
 * @since 1.6
 */
function genesis_404_cust() {
    genesis_markup(
        array(
            'open'    => '<article class="entry">',
            'context' => 'entry-404',
        )
    );

    genesis_markup(
        array(
            'open'    => '<h1 %s><span>',
            'close'   => '</span></h1>',
            'content' => apply_filters( 'genesis_404_entry_title', __( '404', 'genesis' ) ),
            'context' => 'entry-title',
        )
    );

    echo '<div class="entry-content">';

    if ( genesis_html5() ) :
        /* translators: %s: URL for current website. */
        // This should maybe not be a blockquote, for semantic reasons?
        echo apply_filters( 'genesis_404_entry_content', '<blockquote>' . sprintf( __( 'It seems we can\'t find what you\'re looking for.  Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.' , 'genesis' ), trailingslashit( home_url() ) ) . '</blockquote>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        get_search_form();

    else :
        ?>

        <p><?php /* translators: %s: URL for current website. */ printf( wp_kses_post( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'genesis' ) ), esc_url( trailingslashit( home_url() ) ) ); ?></p>

        <?php
    endif;

    echo '</div>';

    genesis_markup(
        array(
            'close'   => '</article>',
            'context' => 'entry-404',
        )
    );

}

genesis();
