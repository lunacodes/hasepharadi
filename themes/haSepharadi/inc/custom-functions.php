<?php

/* ----------------------------------------------------
[custom-functions.php]

1. Setup & Assets
   - 1.1 Font Awesome
   - 1.2 Custom Image Sizes
   - 1.3 Google Fonts
   - 1.4 Genesis Thumbnail Cache Fix
2. Topbar & Header
   - 2.1 Topbar Scripts
   - 2.2 Create Topbar
   - 2.3 WP Admin Bar - Topbar Positioning Fix (Inactive)
   - 2.4 Mobile Menu Pretty Load
   - 2.5 Mobile Menu Disable Superfish
3. Breadcrumbs
4. Posts
   - 4.1 Posts - Featured Image
   - 4.2 Single Pages
   - 4.3 Category Pages
   - 4.4 Entry Meta
   - 4.5 Entry Footer
   - 4.6 Next & Previous Posts Link
   - 4.7 Author Bios
   - 4.8 wpDiscuz Comments Hack
   - 4.9 Author Page Affiliate Linkes
   - 4.10 Add Link Text on User Copy
5. Footer
   - 5.1 Back to Top Button
   - 5.2 Custom Footer Credits
6. Widgets
   - 6.1 Author Avatars
   - 6.2 Hide Widgets
   - 6.3 Affiliate Links Test
   - 6.4 Mailchimp Subscribe
7. Custom User Meta
    - 7.1 Social Media
8. Social Media Sharing Buttons

------------------------------------------------------*/


/* 1. Setup & Assets
=================================================*/

/* 1.1 - Font Awesome
============================*/

add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
    wp_enqueue_style( 'luna-font-awesome', CHILD_URL . '/fonts/fontawesome-pro-5.6.3-web/css/all.min.css', array(), CHILD_THEME_VERSION );
}

/* 1.2 - Custom Image Sizes
============================*/

add_action( 'after_setup_theme', 'add_custom_image_sizes' );
function add_custom_image_sizes() {
    add_image_size( 'recent-posts-thumb', 100, 100, array('left', 'top') );
}

/* 1.3 - Google Fonts
============================*/

// add_action( 'wp_enqueue_scripts', 'enqueue_google_fonts' );
// function enqueue_google_fonts() {
//     wp_enqueue_script( 'google-fonts', 'https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto+Slab:400,700|Source+Sans+Pro:400,400i,600,600i,700,700i', array(), CHILD_THEME_VERSION );
// }

/* 1.4 - Genesis Thumbnail Cache Fix
============================*/

function blazersix_prime_post_thumbnails_cache( $posts, $wp_query ) {
    // Prime the cache for the main front page and archive loops by default.
    $is_main_archive_loop = $wp_query->is_main_query() && ! is_singular();
    $do_prime_cache = apply_filters( 'blazersix_cache_post_thumbnails', $is_main_archive_loop );
    if ( ! $do_prime_cache && ! $wp_query->get( 'blazersix_cache_post_thumbnails' ) ) {
        return $posts;
    }
    update_post_thumbnail_cache( $wp_query );
    return $posts;
}
add_action( 'the_posts', 'blazersix_prime_post_thumbnails_cache', 10, 2 );

/* 2. Top Bar & Header
=================================================*/

/* 2.1 - Topbar Scripts
============================*/

remove_action( 'genesis_header', 'genesis_do_header' );

//* Enqueue Topbar scripts
add_action('wp_enqueue_scripts', 'enqueue_topbar_scripts');
function enqueue_topbar_scripts() {
    // wp_enqueue_style( 'topbar.css', CHILD_URL . '/css/topbar.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'topbar.js', CHILD_URL . '/js/topbar.js', array('jquery'), CHILD_THEME_VERSION );
}

/* 2.2 - Create Topbar
============================*/

add_action( 'genesis_before_header', 'add_topbar' );
function add_topbar() {
    $topbar = <<<EOL
<div id="topbar" class="topbar">
  <div class="social-icons">
    <div class="clearfix"> <a href="http://www.facebook.com/HaSepharadi-164068007554007" title="Facebook" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a> <a href="http://twitter.com/HaSepharadi" title="Twitter" class="twitter" target="_blank"><i class="fab fa-twitter"></i></a></div>
  </div>
   <!--  <button class="menu-toggle dashicons-before dashicons-menu" aria-expanded="false" aria-pressed="false" id="genesis-mobile-nav-primary">Menu</button> -->
  <div id="tools" class="tools">
    <form id="top-search" action="https://hasepharadi.com/" method="get" name="searchform" class="search-form">
      <input type="text" name="s" class="search-text" placeholder="Keyword">
      <button form="top-search" type="submit" class="search-button"></button>
    </form>
  </div>
</div>
EOL;

    echo($topbar);
}

remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

add_action( 'genesis_header', 'haSepharadi_custom_header_markup_open', 5 );
add_action( 'genesis_header', 'haSepharadi_custom_header' );
add_action( 'genesis_header', 'haSepharadi_custom_header_markup_close', 15 );

function haSepharadi_custom_header_markup_open() {
    $open = '<header id="top" class="site-header">';
    echo($open);
}

function haSepharadi_custom_header() {

    $site_url = get_site_url();
    $todays_date = date_i18n( 'l F j, Y' );
    // the_date();
    // echo($todays_date);
    $custom_header = <<<EOL
  <div class="logo"> <a href="$site_url" title="haSepharadi"> <span><img src="$site_url/wp-content/uploads/2018/08/cropped-logo-1.png" scale="0"></span> </a>
    <div id="header-date" class="local-info"> <span class="local-date">$todays_date</span></div>
  </div>
EOL;
    echo($custom_header);

}

function haSepharadi_custom_header_markup_close() {
    $close = '</header>';
    echo($close);
}
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );


/* 2.3 - WP Admin Bar - Tablet & Mobile Fix
============================*/
add_action( 'genesis_after_header', 'fix_wp_admin_bar_mobile' );
function fix_wp_admin_bar_mobile() {
    if (! is_user_logged_in() ) {
        return;
    }

    $margin_fix = <<<EOL
    <style>
    /* 960px */
    @media only screen and (max-width: 60em) {
        .menu-toggle {
            top: 18.5px;
        }
    }

    /* 782px */
    @media only screen and (max-width: 48.875em) {
        .menu-toggle {
            top: 18.5px;
            left: 20px;
            position: fixed;
            top: 34.5px;
        }

        .nav-shrinked {
          top: 96px !important;
        }

        #topbar.shrinked {
          top: 44px;
        }

        #topbar.shrinked #tools {
          margin: 14px 20px 0 0;
        }
    }

    /* 600px */
    @media only screen and (max-width: 37.5em) {
      #topbar.shrinked {
        top: 0;
      }

      .header-shrinked .logo a {
        top: 0;
      }

      .header-shrinked .logo a span img {
        position: fixed;
        /* top: 18px; */
        /* left: 80px; */
        left: 60px;
        top: 10px;
      }

      /* .menu-toggle, */
      .mobile-menu-shrinked {
        /* top: 22.5px; */
        top: -10px;
      }

      .nav-shrinked {
        top: -53px !important;
      }
    }

     </style>
EOL;

    if ( is_user_logged_in() && ( ! is_admin() ) ) {
        echo($margin_fix);
    }
}

/* 2.7 - Mobile Menu Pretty Load
============================*/

add_filter( 'body_class', function ( $classes ) {
    $classes[] = 'no-js';
    return $classes;
} );
add_action( 'genesis_before', 'mobile_menu_pretty_load', 1 );
function mobile_menu_pretty_load(){
    ?>
    <script>
        //<![CDATA[
        (function () {
            var c = document.body.classList;
            c.remove('no-js');
            c.add('js');
        })();
        //]]>
    </script>
    <?php
}

/* 2.5 - Mobile Menu Disable Superfish
============================*/

//* Disable the superfish script
// add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
    wp_deregister_script( 'superfish' );
    wp_deregister_script( 'superfish-args' );
}

/* 3. Breadcrumbs
=================================================*/


add_action( 'genesis_before_content', 'custom_breadcrumbs', 8 );
function custom_breadcrumbs() {
    if ( ! is_singular( 'page' ) && (! is_home() ) && (! is_404() ) ) { ?>
        <div class="bc-container">
            <div class="breadcrumbs">
              <div class="navi">
                <i class="fa fa-home"></i>
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                <a href="<?php get_site_url(); ?>" itemprop="item">
                <span itemprop="name">Home</span></a>
                </span> <span class="sep">»</span> <?php the_title(); ?>
              </div>
            </div>
        <?php
        luna_social_sharing_buttons()
        ?>
    </div>
    <?php }

}


/* 4. - Posts
=================================================*/


/* 4.1 Posts - Featured Image
============================*/

add_theme_support( 'post-thumbnails' );
add_action( 'genesis_before_entry', 'display_featured_post_image', 8 );
function display_featured_post_image() {
    if ( is_singular( 'page' ) && ( ! is_category() ) ) {

    } elseif ( is_category() ) {
        // echo("We're a category");
    } else {
        the_post_thumbnail('post-image');
    }
}

/* 4.2 - Single Pages
============================*/

add_action( 'genesis_pre_get_option_site_layout', 'luna_remove_sidebar' );
function luna_remove_sidebar() {
    if ( is_singular( 'page' ) || is_category() ) {
        $opt = 'full-width-content';
        return $opt;
    }
}

/* 4.3 - Category Pages
============================*/

add_action('wp_enqueue_scripts', 'enqueue_category_scripts');
function enqueue_category_scripts() {
    if ( is_category() ) {

        wp_enqueue_style('category.css', CHILD_URL . '/css/category.css', array(), CHILD_THEME_VERSION );
        remove_action( 'genesis_before_entry', 'display_featured_post_image' );
    }
}

/* 4.4 - Entry Meta
============================*/

add_action( 'wp_enqueue_scripts', 'enqueue_entry_meta_assets' );
function enqueue_entry_meta_assets() {
    wp_enqueue_style( 'roboto-slab', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese' );
}

/* 4.5 - Entry Footer
============================*/

// add_action( 'genesis_entry_content', 'haSepharadi_disclaimer' );
function haSepharadi_disclaimer() {
    echo("Due to the variable nature of our posts and the wide spectrum of ideas exchanged, we feel it is important to clarify that the thoughts and opinions shared in posts and articles reflect the opinions of the author and are not representative of our contributors as a whole.");
}

// Excerpt Ellipsis
function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* 4.6 Next & Previous Posts Link
============================*/

add_action( 'genesis_after_loop', 'add_next_and_prev_post_links', 12 );
function add_next_and_prev_post_links() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    echo '<div class="pagination-previous alignleft">';
    previous_post_link('%link', 'Previous Post', FALSE);
    echo '</div>';

    echo '<div class="pagination-next alignright">';
    next_post_link('%link', 'Next Post', FALSE);
    echo '</div>';
}

add_action( 'genesis_after_loop', 'add_next_and_prev_post_archive_links', 12 );
function add_next_and_prev_post_archive_links() {
    if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
        genesis_numeric_posts_nav();
    } else {
        genesis_prev_next_posts_nav();
    }
}

/* 4.7 Author Bios
============================*/

add_action( 'genesis_after_loop', 'display_author_bio' );
function display_author_bio() {

    if ( ! is_singular( 'post' ) ) {
        return;
    } else {

    ?>
        <div class="author-box">
            <h2 class="author-box-title">About Author</h2>
            <div class="author-img"><a href="<?php echo( esc_url( get_author_posts_url( get_the_author_meta('ID') ) ) ) ?>" title="<?php esc_attr( get_the_author() ); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), '80'); // Display the author gravatar image with the size of 80 ?></a></div>
            <h3 class="author-name"><?php esc_html(the_author_meta('display_name')); // Displays the author name of the posts ?></h3>
            <p class="author-description"><?php esc_textarea(the_author_meta('description')); // Displays the author description added in Biographical Info ?></p>
        </div>
    <?php
    }
}

/* 4.8 wpDiscuz Comments Hack
============================*/

add_action( 'genesis_after_loop', 'display_comments_plz' );
function display_comments_plz() {
    if ( ! is_singular( 'post' ) ) {
        return;
    } else {
        comments_template();
    }
}

/* 4.9 Author Page Affiliate Linkes
============================*/

//

/* 4.10 Add Link Text on User Copy
============================*/

// Appens the Site Url to any copied text
add_action('wp_enqueue_scripts', 'add_copy_link' );
function add_copy_link() {
  wp_enqueue_script('add-copy-link', CHILD_URL . '/js/copy-link-text.js' );
}

// add_action( 'pre_get_posts', 'post_check' );
// function post_checks( $query ) {
//   if ( is_post_type_archive( 'facebook-events' ) ) {
//     // echo("yes");
//   }

// }


/* 5. Footer
=================================================*/

/* 5.1 Back to Top Button
============================*/

add_action( 'genesis_after_footer', 'add_back_to_top_btn' );
function add_back_to_top_btn() {
    ?>
    <a href="javascript:void(0);" class="up_btn" id="backToTop"><i class="fa fa-arrow-up"></i></a>
    <?php
}

/* 5.2 Custom Footer Credits
============================*/

add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
    $creds = 'Copyright [footer_copyright] <a href="https://hasepharadi.com">haSepharadi</a>. All rights reserved.';
    return $creds;
}


/* 6. Widgets
=================================================*/

/* 6.1 - Author Avatars
============================*/

add_shortcode( 'author_avatars', 'display_author_avatars' );
function display_author_avatars() { ?>

    <?php
    remove_filter('widget_text_content', 'wpautop');
    $authors = array();
    $i = 0;
    if ( have_posts() ) : ob_start(); ?><div class="author-avatars">
        <?php
        while ( have_posts() ) : the_post(); ?>

        <?php
        $id = get_the_author_meta( 'ID' );
        if (! (in_array($id, $authors) ) ) {
            array_push( $authors, $id );

            $name = get_the_author_meta( 'display_name' );
            $author_posts = get_author_posts_url($id);
            ?>


            <!-- Leaving wp_list_authors here b/c the widget currently limits this to 6 authors -->
            <?php // wp_list_authors( array( 'echo' => 'false') );
                // count_user_posts( $userid, 'post', false ); ?>
            <div class="authors-wrap">
                <div class="author-box">
                    <a href="<?php echo($author_posts); ?>">
                        <div class="avatar-box"><?php echo( get_avatar( get_the_author_meta( 'ID' ) ) ); ?>
                        </div>
                        <span class="author-name"><?php echo( $name ); ?>
                        </span>
                    </a>
                </div>
            </div>
            <?php

        } else {

        }
        $i++;

    endwhile;
    endif;


    ?>
    </div>
    <?php
    $output_string = ob_get_contents();
    ob_end_clean();
    wp_reset_postdata();
    return $output_string;

}

/* 6.2 - Hide Widgets
============================*/

/* Not working currently... */
// add_filter( 'widget_display_callback', 'hide_widgets_off_home', 10, 3 );
// function hide_widgets_off_home( $instance, $widget, $args ) {
//     if ( $widget->id_base == 'luna_afl_widget' ) {
//         if ( !is_page( 'home' ) ) {
//             return $instance;
//         }
//     }
// }

/* 6.3 - Affiliate Links Test
============================*/

// Why is this here?!?!
add_shortcode( 'luna_affiliates', 'affiliate_links_widget' );
function affiliate_links_widget() {
    return "This is a test";
}

/* 6.3 - Affiliate Links Test
============================*/

add_action( 'wp_enqueue_scripts', 'enqueue_mailchimp_styles' );
function enqueue_mailchimp_styles() {
    wp_enqueue_style( 'mc-subscribe', CHILD_URL . '/css/mc-subscribe.css' );
}


/* 7. Custom User Meta
=================================================*/

/* 7.1 - Social Media
============================*/

remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
add_action( 'genesis_after_loop', 'genesis_do_author_box_archive' );

add_filter( 'user_contactmethods', 'luna_add_user_social_media' );
function luna_add_user_social_media( $fields ) {
    $fields['academia'] = 'Academia';
    $fields['facebook'] = 'Facebook';
    $fields['twitter'] = 'Twitter';
    $fields['instagram'] = 'Instagram';
    $fields['fake'] = 'Fake';

    return $fields;
}

add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );

add_action( 'genesis_after_loop', 'genesis_do_taxonomy_title_description' );



/* 8. Social Media Sharing Buttons
=================================================*/

function luna_social_sharing_buttons() {
    global $post;

    if ( is_singular() || is_home() ) {
        $post_url = urlencode( get_permalink() );
        $post_title = htmlspecialchars( urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8') ), ENT_COMPAT, 'UTF-8' );
        $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

    $fb_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    // echo( $fb_url);
    $twitter_url = 'https://twitter.com/share?text='.$post_title.'&url='.$post_url.'&via=haSepharadi';
    $google_plus_url = 'https://plus.google.com/share?url='.$post_url;
    $linked_in_url = 'https://www.linkedin.com/shareArticle?mini=true&title='.$post_title.'&source-'.$post_url.'&url='.$post_url;
    $pinterest_url = 'https://pinterest.com/pin/create/button/?media='.$post_url.'&media='.$post_thumbnail[0].'&description='.$post_title;
    // var_dump($post_thumbnail);
    $whats_app_url = 'whatsapp://send?text='.$post_title . ' ' . $post_url;

    ?>
        <!-- Remove extraneous classes here?? -->
        <div class="social-buttons share">
            <a href="<?php echo($fb_url) ?>" target="_blank" title="Facebook" class="social-btn facebook-circle"><i class="fab fa-fw fa-facebook-f"></i></a>
            <a href="<?php echo($twitter_url) ?>" target="_blank" title="Twitter" class="social-btn twitter-circle"><i class="fab fa-fw fa-twitter"></i></a>
            <a href="<?php echo($google_plus_url) ?>" target="_blank" title="Google Plus" class="social-btn google-plus-circle"><i class="fab fa-fw fa-google-plus"></i></a>
            <a href="<?php echo($pinterest_url) ?>" target="_blank" title="Pinterest" class="social-btn pinterest-circle"><i class="fab fa-fw fa-pinterest"></i></a>
            <a href="<?php echo($linked_in_url) ?>" target="_blank" title="LinkedIn" class="social-btn linkedin-circle"><i class="fab fa-fw fa-linkedin"></i></a>
            <a href="<?php echo($whats_app_url) ?>" target="_blank" title="WhatsApp" class="social-btn whatsapp-circle"><i class="fab fa-fw fa-whatsapp"></i></a>

        </div>

    <?php
    } else {
        return;
    }
}
