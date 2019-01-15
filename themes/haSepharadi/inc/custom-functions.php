<?php

/* ----------------------------------------------------
[custom-functions.php]

1. Setup & Assets
   - 1.1 Font Awesome
   - 1.2 Custom Image Sizes
2. Topbar & Header
   - 2.1 Topbar Scripts
   - 2.2 Create Topbar
   - 2.3 Menu Hack for Homepage
   - 2.4 WP Admin Bar - Topbar Positioning Fix (Inactive)
   - 2.5 Menu Hack for Home Page (Inactive)
   - 2.6 Mobile Menu - Pushy (Inactive)
   - 2.7 Mobile Menu Pretty Load
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
5. Footer
   - 5.1 Back to Top
   - 5.2 Custom Footer Credits
6. Widgets
   - 6.1 Author Avatars
7. Calendar Plugin
8. Easy Footnotes Fix
9. Custom User Meta
    - 9.1 Social Media

------------------------------------------------------*/


/* 1. Setup & Assets
=================================================*/

/* 1.1 - Font Awesome
============================*/

add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', CHILD_URL . '/inc/font-awesome-4.6.3/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );
}

// add_action( 'wp_enqueue_scripts', 'enqueue_main_fonts' );
// function enqueue_main_fonts() {
//     // wp_enqueue_style( 'https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Source+Sans+Pro:400,400i,600,600i,700,700i' );
//     wp_enqueue_style( 'google-fonts', CHILD_URL . '/css/google-fonts.css', array(), CHILD_THEME_VERSION );
//     // echo($fonts_to_enqueue);
// }

/* 1.2 - Custom Image Sizes
============================*/
add_action( 'after_setup_theme', 'add_custom_image_sizes' );
function add_custom_image_sizes() {
    add_image_size( 'recent-posts-thumb', 100, 100, array('left', 'top') );
}

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

// add_action( 'wp_enqueue_scripts', 'enqueue_nav_scripts' );
// function enqueue_nav_scripts() {
//     wp_enqueue_style( 'nav.css', CHILD_URL . '/css/nav.css', array(), CHILD_THEME_VERSION );
// }


/* 2.2 - Create Topbar
============================*/

add_action( 'genesis_before_header', 'add_topbar' );
function add_topbar() {
    $topbar = <<<EOL
<div id="topbar">
  <div class="social_icons">
    <div class="social-icons clearfix"> <a href="http://www.facebook.com/HaSepharadi-164068007554007" title="Facebook" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a> <a href="http://twitter.com/HaSepharadi" title="Twitter" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a></div>
  </div>
   <!--  <button class="menu-toggle dashicons-before dashicons-menu" aria-expanded="false" aria-pressed="false" id="genesis-mobile-nav-primary">Menu</button> -->
  <div id="tools">
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
    $open = '<header id="top" class="">';
    echo($open);
}

function haSepharadi_custom_header() {

    // global $wp_registered_sidebars;

    // genesis_markup( array(
    //     'open' => '<div %s>',
    //     'context' => 'title-area'
    // ) );

    // do_action( 'genesis_site_title' );
    $site_url = get_site_url();

    $custom_header = <<<EOL
  <div class="logo"> <a href="$site_url" title="haSepharadi"> <span><img src="$site_url/wp-content/uploads/2018/08/cropped-logo-1.png" scale="0"></span> </a>
    <!-- <div class="local_info"> <span class="local_date">Friday 24 August 2018 </span></div> -->
  </div>
EOL;
    echo($custom_header);

    // genesis_do_nav();
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
    $margin_fix = <<<EOL
    <style>
        @media only screen and (max-width: 782px) {
            button#genesis-mobile-nav-primary {
                left: 20px;
                position: fixed;
                top: 36.5px;
            }

            .nav-shrinked {
                top: 96px !important;
            }

            #topbar.shrinked {
                top: 34px;
            }

            #topbar.shrinked #tools {
                margin: 14px 20px 0 0;
            }
        }
     </style>
EOL;

    if ( is_user_logged_in() && ( ! is_admin() ) ) {
        echo($margin_fix);
    }
}

/* 2.4 - WP Admin Bar - Topbar Positioning Fix
============================*/

// if ( is_admin_bar_showing()) {
//     echo("<style> .nav-shrinked { top: 30px; } </style>");
//     // echo("Admin Bar Showing");
// } else {
//     echo("Admin bar not showing!!");
// }


/* 2.5 - Menu Hack for Home Page
============================*/

/*if ( is_home() ) {
    // echo("we're home");
    ?>
    <!-- <style type="text/css" media="screen"> .menu-primary li:first-of-type a {color:#c93; }</style> -->
    <?php
}*/

/* 2.6 - Mobile Menu - Pushy
============================*/

// Note: disabled this until I can more properly figure it out


// Disable superfish.js

// add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
// function sp_disable_superfish() {
//     wp_deregister_script( 'superfish' );
//     wp_deregister_script( 'superfish-args' );
// }

// // Enable Pushy scripts and styles
// add_action( 'wp_enqueue_scripts', 'add_pushy_js_menu' );
// function add_pushy_js_menu() {
//     wp_enqueue_style( 'pushy', CHILD_URL . '/inc/pushy-master/css/pushy.css', array(), CHILD_THEME_VERSION );
//     wp_enqueue_script( 'pushy-helper', CHILD_URL . '/inc/pushy-helper.js', array(), CHILD_THEME_VERSION, true );
//     wp_enqueue_script( 'pushy-js', CHILD_URL . '/inc/pushy-master/js/pushy.min.js', array('jquery'), CHILD_THEME_VERSION, true );
//     // wp_enqueue_script( 'pushy-helper', CHILD URL . '/inc/pushy-helper.js' );
// }

// Add pushy menu to header
// function add_pushy_js_menu() {
    // echo
// }

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
            // console.log(c);
            c.remove('no-js');
            c.add('js');
            // console.log(c);
        })();
        //]]>
    </script>
    <?php
}

/* 2.7 - Mobile Menu Disable Superfish
============================*/

//* Disable the superfish script
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
    wp_deregister_script( 'superfish' );
    wp_deregister_script( 'superfish-args' );
}

/* 3. Breadcrumbs
=================================================*/


add_action( 'genesis_before_content', 'custom_breadcrumbs', 8 );
function custom_breadcrumbs() {
    if ( ! is_singular( 'page' ) && (! is_home() ) && (! is_404() ) ) { ?>
        <div class="breadcrumbs">
          <div class="navi">
            <i class="fa fa-home"></i>
            <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
            <a href="<?php get_site_url(); ?>" itemprop="item">
            <span itemprop="name">Home</span></a>
            </span> <span class="sep">»</span> <?php the_title(); ?>
          </div>
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
        // echo("It's a singular page!");
    } elseif ( is_category() ) {
        echo("We're a category");
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
        // echo("We're on a category page");
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

// Customize entry meta header
// add_filter( 'genesis_post_info', 'themeprefix_post_info_filter' );
// function themeprefix_post_info_filter( $post_info ) {
//     // $category = get_the_category();
//     // $category_str = "<span>"
//     $post_info = '[post_categories before=""][post_title][post_author_posts_link]';
//     return $post_info;
// }

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

// I'd love to use the built-in option, instead of having to write a custom function
// but for some reason, using my custom loop is causing me to have to write a function

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
    // echo("This is a test");
    // the_author();
    ?>
    <div class="author-box">
        <h2 class="author-box-title">About Author</h2>
        <div class="author-img"><?php echo get_avatar(get_the_author_meta('user_email'), '100'); // Display the author gravatar image with the size of 100 ?></div>
        <h3 class="author-name"><?php esc_html(the_author_meta('display_name')); // Displays the author name of the posts ?></h3>
        <p class="author-description"><?php esc_textarea(the_author_meta('description')); // Displays the author description added in Biographical Info ?></p>
    </div>
<?php
}

/* 4.8 wpDiscuz Comments Hack
============================*/

add_action( 'genesis_after_loop', 'display_comments_plz' );
function display_comments_plz() {
    if ( is_singular( 'post' ) ) {
        comments_template();
    }
}


/* 5. Footer
=================================================*/

//* Back to Top Button
add_action( 'genesis_after_footer', 'add_back_to_top_btn' );
function add_back_to_top_btn() {
    ?>
    <a href="javascript:void(0);" class="up_btn" id="backToTop"><i class="fa fa-arrow-up"></i></a>
    <?php
}

//* Change the footer text
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


            <?php // the_author_posts_link(); ?>
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
            // echo("Already In");
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
    // echo("This is a test");
}


/* 8. Easy Footnotes Fix
=================================================*/

// remove_filter('the_content', 'easy_footnote_after_content', 19);

/* 9. Editor Stylesheet
=================================================*/

// add_editor_style( array|string $stylesheet = 'editor-style.css' )

// ex:
// Basic Example

// Add the following to the functions.php file of your theme.

// /**
//  * Registers an editor stylesheet for the theme.
//  */
// function wpdocs_theme_add_editor_styles() {
//     add_editor_style( 'custom-editor-style.css' );
// }
// add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );
// Next, create a file named custom-editor-style.css in your themes root directory. Any CSS rules added to that file will be reflected within the TinyMCE visual editor. The contents of the file might look like this:

// body#tinymce.wp-editor {
//     font-family: Arial, Helvetica, sans-serif;
//     margin: 10px;
// }

// body#tinymce.wp-editor a {
//     color: #4CA6CF;
// }

// Add files dynamically:
// add_filter('tiny_mce_before_init','wpdocs_theme_editor_dynamic_styles');
// function wpdocs_theme_editor_dynamic_styles( $mceInit ) {
//     $styles = 'body.mce-content-body { background-color: #' . get_theme_mod( 'background-color', '#FFF' ) . '}';
//     if ( isset( $mceInit['content_style'] ) ) {
//         $mceInit['content_style'] .= ' ' . $styles . ' ';
//     } else {
//         $mceInit['content_style'] = $styles . ' ';
//     }
//     return $mceInit;
// }
//
//

// Google Fonts in Editor
/**
 * Registers an editor stylesheet for the current theme.
 */
// function wpdocs_theme_add_editor_styles() {
//     $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
//     add_editor_style( $font_url );
// }
// add_action( 'after_setup_theme', 'wpdocs_theme_add_editor_styles' );

/* 9. Custom User Meta
=================================================*/

/* 9.1 - Social Media
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
/**
 * @author    Brad Dalton
 */
add_action( 'genesis_after_loop', 'genesis_do_taxonomy_title_description' );


add_shortcode( 'luna_affiliates', 'affiliate_links_widget' );
function affiliate_links_widget() {
    return "This is a test";
}
