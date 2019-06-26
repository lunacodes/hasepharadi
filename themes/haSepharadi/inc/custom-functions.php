<?php

/* ----------------------------------------------------
[custom-functions.php]

1. Setup & Assets
	 - 1.1 Custom Image Sizes
	 - 1.2 Genesis Thumbnail Cache Fix
	 - 1.3 Custom Login Logo
	 - 1.4 WP Admin - Get Widget ID
	 - 1.5 Widget Titles - Allow HTML
2. Topbar & Header
	 - 2.1 Topbar Scripts
	 - 2.2 Create Topbar
	 - 2.3 Create Custom Header
	 - 2.4 Mobile Menu Pretty Load
	 - 2.5 Mobile Menu Disable Superfish
3. Breadcrumbs
4. Posts
	 - 4.1 Posts - Featured Image
	 - 4.2 Single Pages
	 - 4.3 Entry Footer - haSeph Disclaimer
	 - 4.4 Excerpt Ellipsis
	 - 4.5 Next & Previous Posts Link
	 - 4.6 Jetpack - Reated Posts
	 - 4.7 Author Bios
	 - 4.8 Add Link Text on User Copy
	 - 4.9 Add wpDevArt Facebook Comments
5. Footer
	 - 5.1 Back to Top Button
	 - 5.2 Custom Footer Credits
6. Widgets
	 - 6.1 Author Avatars (Voices)
	 - 6.2 Mailchimp Subscribe
7. Custom User Meta
		- 7.1 Social Media
8. Social Media Sharing Buttons
9. Maintenance

------------------------------------------------------*/


/* 1. Setup & Assets
=================================================*/

/* 1.1 - Custom Image Sizes
============================*/

add_action( 'after_setup_theme', 'add_custom_image_sizes' );
function add_custom_image_sizes() {
		add_image_size( 'recent-posts-thumb', 100, 100, array('left', 'top') );
}

/* 1.2 - Genesis Thumbnail Cache Fix
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

/* 1.3 - Custom Login Logo
============================*/

add_action( 'login_enqueue_scripts', 'haSeph_custom_login_logo' );
function haSeph_custom_login_logo() { ?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(https://hasepharadi.com/wp-content/themes/haSepharadi/images/logo.png);
			background-image: none, url(https://hasepharadi.com/wp-content/themes/haSepharadi/images/logo.png);
			background-position: left top;
			background-repeat: no-repeat;
			background-size: 320px;
			color: #444;
			display: block;
			font-size: 20px;
			font-weight: 400;
			height: 120px;
			line-height: 1.3em;
			margin: 0 auto 25px;
			outline: 0;
			overflow: hidden;
			padding: 0;
			text-decoration: none;
			text-indent: -9999px;
			width: 320px;
		}
	</style>

	<?php
}

add_filter( 'login_headerurl', 'haSeph_login_logo_url' );
function haSeph_login_logo_url() {
	return home_url();
}

add_filter( 'login_headertext', 'haSeph_login_url_title' );
function haSeph_login_url_title() {
	return 'haSepharadi';
}

/* 1.4 - WP Admin - Get Widget ID
============================*/

add_action( 'in_widget_form', 'luna_get_widget_id' );
function luna_get_widget_id( $widget_instance ) {
	if ( $widget_instance->number=="__i__" ) {
		echo( "<p><strong>Widget ID:</strong> Please save the widget first!</p>");
	} else {
		echo( "<p><strong>Widget ID: </strong>" . $widget_instance->id . "</p>");
	}
}

/* 1.5 - Widget Titles - Allow HTML
============================*/

/**
 * Replaces widget title: [link href=/contact/]Contact Us[/link]
 * with <a href="/contact/">Contact Us</a>
 */
add_filter( 'widget_title', 'accept_html_widget_title' );
function accept_html_widget_title( $mytitle ) {
  // The sequence of String Replacement is important!!
	$mytitle = str_replace( '[link', '<a', $mytitle );
	$mytitle = str_replace( '[/link]', '</a>', $mytitle );
  $mytitle = str_replace( ']', '>', $mytitle );

	return $mytitle;
}

/* 2. Top Bar & Header
=================================================*/

/* 2.1 - Topbar Scripts
============================*/

remove_action( 'genesis_header', 'genesis_do_header' );

//* Enqueue Topbar scripts
add_action('wp_enqueue_scripts', 'enqueue_topbar_scripts');
function enqueue_topbar_scripts() {
	wp_enqueue_script( 'topbar-js', CHILD_URL . '/js/topbar.js', array( 'jquery' ), CHILD_THEME_VERSION );
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
	<form id="top-search" role="search" action="https://hasepharadi.com/" method="get" name="searchform" class="search-form">
		<input type="text" name="s" class="search-text" placeholder="Keyword">
		<button form="top-search" type="submit" class="search-button"></button>
	</form>
	</div>
</div>
EOL;

		echo($topbar);
}

/* 2.3 Create Custom Header
============================*/

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

// 	$custom_header = <<<EOL
// <div class="logo" href="https://hasepharadi.com"><a href="https://hasepharadi.com" title="haSepharadi"> <span><img href="https://hasepharadi.com" src="https://hasepharadi.com/wp-content/themes/haSepharadi/images/logo.svg" width="216" height="80" style="width: 100%; height: 80px; visibility: visible;"  type="image"></span></a><div id="header-date" class="local-info"> <span class="local-date">$todays_date</span></div></div>
// EOL;

	echo($custom_header);

}

function haSepharadi_custom_header_markup_close() {
		$close = '</header>';
		echo($close);
}
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );


/* 2.4 - Mobile Menu Pretty Load
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

/* 4.3 - Entry Footer - haSeph Disclaimer
============================*/

// add_action( 'genesis_entry_content', 'haSepharadi_disclaimer' );
function haSepharadi_disclaimer() {
		echo("Due to the variable nature of our posts and the wide spectrum of ideas exchanged, we feel it is important to clarify that the thoughts and opinions shared in posts and articles reflect the opinions of the author and are not representative of our contributors as a whole.");
}

/* 4.4 Excerpt Ellipsis */
function new_excerpt_more($more) {
		return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* 4.5 Next & Previous Posts Link
============================*/

add_action( 'genesis_after_loop', 'add_next_and_prev_post_links', 12 );
function add_next_and_prev_post_links() {
		if ( ! is_singular( 'post' ) ) {
				return;
		}

		echo '<div class="pagination-previous alignleft">';
		previous_post_link();
		echo '</div>';

		echo '<div class="pagination-next alignright">';
		next_post_link();
		echo '</div>';
}

add_action( 'genesis_after_loop', 'add_next_and_prev_post_archive_links', 10 );
function add_next_and_prev_post_archive_links() {
	if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
		genesis_numeric_posts_nav();
	} else {
		genesis_prev_next_posts_nav();
	} }

/* 4.6 Jetpack - Reated Posts
============================*/

// add_filter( 'wp', 'jetpack_remove_rp' );
function jetpack_remove_rp() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		$jprp = Jetpack_RelatedPosts::init();
		$callback = array( $jprp, 'filter_add_target_to_dom' );
		remove_filter( 'the_content', $callback, 40 );
	}
}

// add_action( 'genesis_after_entry', 'jetpack_footer' );
function jetpack_footer() {
	if ( is_singular( array('tribe_events', 'event') ) ) {
		echo do_shortcode( '[jetpack-related-posts]' );
	}
}

function jetpackme_related_posts_past_halfyear_only( $date_range ) {
	if (is_singular( 'tribe_events' ) ) {
		$date_range = array(
		'from' => time(),
		'to' => strtotime('2020'),
		);
		return $date_range;
	} else {
		return;
	}
}
add_filter( 'jetpack_relatedposts_filter_date_range', 'jetpackme_related_posts_past_halfyear_only' );


/* 4.7 Author Bios
============================*/

add_action( 'genesis_after_loop', 'display_author_bio' );
function display_author_bio() {

	// most of the if statements below are pointless.
	if ( ! is_singular( 'post' ) ) {
		return;
	} else if ( is_singular( 'tribe_events' ) ) {
		// echo( 'Tribe Events' );
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


/* 4.8 Add Link Text on User Copy
============================*/

// Append the Site Url to any copied text.
// add_action('wp_enqueue_scripts', 'add_copy_link' );
function add_copy_link() {
	wp_enqueue_script('add-copy-link', CHILD_URL . '/js/copy-link-text.js' );
}

/* 4.9 Add wpDevArt Facebook Comments
============================*/

add_action( 'genesis_after_loop', 'display_fb_comments', 10 );
function display_fb_comments() {
	if ( is_single() && (! is_single( 'tribe_events' ) ) ) {
		$url = get_the_permalink();
		// echo($url);
		$shortcode_str = '[wpdevart_facebook_comment curent_url="' . $url . '" order_type="social" title_text="Facebook Comment" title_text_color="#000000" title_text_font_size="22" title_text_font_famely="monospace" title_text_position="left" width="100%" bg_color="#d4d4d4" animation_effect="random" ]';

		echo do_shortcode( $shortcode_str );
	}
}


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

/* 6.1 Author Avatars (Voices)
============================*/

add_shortcode( 'author_avatars', 'display_author_avatars' );
function display_author_avatars() {
	remove_filter( 'widget_text_content', 'wpautop' );

	$args = array(
		'number' => 6,
		// 'orderby' => 'rand',
		'role' => 'author',
	);

	$author_query = new WP_User_Query( $args );
	// var_dump($author_query);
	$authors = $author_query->get_results();

	if ( $authors ) {
			ob_start();
		?>
			<div class="author-avatars">
			<?php

			foreach ( $authors as $author ) {
				if ( count_user_posts( $author->ID ) >= 1 ) {
					$name = $author->display_name;
					$author_id = $author->ID;
					$avatar_url = get_avatar_url( $author_id );
					// $voices_thumb =
					// $author_posts = $author->url;
					$author_posts = get_author_posts_url( $author->ID );
					$args = array(
						'size' => 100,
					);
					$alt_txt = $name + ' - Author Picture';
					?>

				<div class="authors-wrap">
					<div class="author-box">
						<a href="<?php echo($author_posts); ?>">
							<div class="avatar-box">
								<?php echo get_avatar( $author_id, 96, '', '', null ); ?>
							</div>
							<span class="author-name"><?php echo( $name ); ?>
							</span>
						</a>
					</div>
				</div>
				<?php
			}
		}
	} else {
			// echo "no users found";
	}
	?>
				</div>
	<?php

	$output_string = ob_get_contents();
	ob_end_clean();
	wp_reset_postdata();
	return $output_string;
}

/* 6.2 - Mailchimp Subscribe
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

// I don't know if this is even achieving anything
// Technically, it should be causing it to appear...
if ( is_singular( 'event' ) ) {
	add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
}

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );

add_action( 'genesis_after_loop', 'genesis_do_taxonomy_title_description' );



/* 8. Social Media Sharing Buttons
=================================================*/

function luna_social_sharing_buttons() {
	global $post;

	if ( is_singular() || is_home() ) {
		$post_url = urlencode( get_permalink() );
		$post_title = htmlspecialchars( urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
		$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		$fb_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
		$twitter_url = 'https://twitter.com/share?text=' . $post_title . '&url=' . $post_url . '&via=haSepharadi';
		$whats_app_url = 'whatsapp://send?text=' . $post_title . ' ' . $post_url;
		?>

		<!-- Remove extraneous classes here?? -->
		<div class="social-buttons share">
			<a href="<?php echo( $fb_url ); ?>" target="_blank" title="Facebook" class="social-btn facebook-circle"><i class="fab fa-fw fa-facebook-f"></i></a>
			<a href="<?php echo( $twitter_url ); ?>" target="_blank" title="Twitter" class="social-btn twitter-circle"><i class="fab fa-fw fa-twitter"></i></a>
			<a href="<?php echo( $whats_app_url ); ?>" target="_blank" title="WhatsApp" class="social-btn whatsapp-circle"><i class="fab fa-fw fa-whatsapp"></i></a>

		</div>

		<?php
	} else {
		return;
	}
}


/* 9. Maintenance
=================================================*/

$cron_args = array( false );
if ( ! wp_next_scheduled( 'luna_debug_hook', $cron_args ) ) {
	wp_schedule_event( time(), 'daily', 'luna_debug_hook' );
}
add_action( 'luna_debug_hook', 'luna_cleanup_debug_log' );

/**
 * GZip and Delete wp-content/debug.log anytime file size is greater than 100MB.
 * Email Admin debug file
 *
 */
add_action( 'genesis_loop', 'luna_cleanup_debug_log' );
function luna_cleanup_debug_log() {
	if ( file_exists('/public_html/wp-content/debug.log' ) ) {
		echo( 'debug log exists' );
	}
}

add_filter( 'genesis_attr_content', 'genesis_main_content_class' );
function genesis_main_content_class( $attributes ) {
	$attributes['class'] = '.genesis-content';
	return $attributes;
}
