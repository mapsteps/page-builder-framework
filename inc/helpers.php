<?php
/**
 * Helpers.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * strpos array helper function.
 *
 * @param array   $haystack The haystack.
 * @param array   $needles The needles.
 * @param integer $offset The offset.
 *
 * @return boolean.
 */
function wpbf_strposa( $haystack, $needles, $offset = 0 ) {

	if ( ! is_array( $needles ) ) {
		$needles = array( $needles );
	}

	foreach ( $needles as $needle ) {
		if ( strpos( $haystack, $needle, $offset ) !== false ) {
			return true;
		}
	}

	return false;

}

/**
 * Pingback head link.
 *
 * Add Pingback head link if we're on singular and pings are open.
 */
function wpbf_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
	}

}
add_action( 'wp_head', 'wpbf_pingback_header' );

/**
 * Schema markup.
 */
function wpbf_body_schema_markup() {

	// Blog variable.
	$is_blog = ( is_home() || is_date() || is_category() || is_author() || is_tag() || is_attachment() || is_singular( 'post' ) ) ? true : false;

	// Default itemtype.
	$itemtype = 'WebPage';

	// Define itemtype for blog pages, otherwise use WebPage.
	$itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

	// Define itemtype for search results, otherwise use WebPage.
	$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;

	// Make result filterable.
	$result = apply_filters( 'wpbf_body_itemtype', $itemtype );

	// Output.
	echo 'itemscope="itemscope" itemtype="https://schema.org/' . esc_html( $result ) . '"';

}

/**
 * Inner content open.
 *
 * @param boolean $echo Determine wether result should return or echo.
 */
function wpbf_inner_content( $echo = true ) {

	if ( is_singular() ) {

		$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

		// Check if template is set to full width.
		$fullwidth = $options ? in_array( 'full-width', $options ) : false;

		// Check if template is set to contained.
		$contained = $options ? in_array( 'contained', $options ) : false;

		// Construct inner content wrapper.
		$inner_content = $fullwidth ? false : apply_filters( 'wpbf_inner_content', '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">' );

		// Check if Premium Add-On is active and template is not set to contained.
		if ( wpbf_is_premium() && ! $contained ) {

			$wpbf_settings = get_option( 'wpbf_settings' );

			// Get array of post types that are set to full width under Appearance > Theme Settings > Global Templat Settings.
			$fullwidth_global = isset( $wpbf_settings['wpbf_fullwidth_global'] ) ? $wpbf_settings['wpbf_fullwidth_global'] : array();

			// If current post type has been set to full-width globally, set $inner_content to false.
			$inner_content = $fullwidth_global && in_array( get_post_type(), $fullwidth_global ) ? false : $inner_content;

		}

		// On archives, we only add the wpbf_inner_content filter.
	} else {

		$inner_content = apply_filters( 'wpbf_inner_content', '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">' );

	}

	if ( $echo ) {
		echo $inner_content;
	} else {
		return $inner_content;
	}

}

/**
 * Inner content close.
 */
function wpbf_inner_content_close() {

	if ( is_singular() ) {

		$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

		$fullwidth = $options ? in_array( 'full-width', $options ) : false;

		$contained = $options ? in_array( 'contained', $options ) : false;

		$inner_content_close = $fullwidth ? false : '</div>';

		if ( wpbf_is_premium() && ! $contained ) {

			$wpbf_settings = get_option( 'wpbf_settings' );

			$fullwidth_global = isset( $wpbf_settings['wpbf_fullwidth_global'] ) ? $wpbf_settings['wpbf_fullwidth_global'] : array();

			$inner_content_close = $fullwidth_global && in_array( get_post_type(), $fullwidth_global ) ? false : $inner_content_close;

		}

	} else {

		$inner_content_close = '</div>';

	}

	echo $inner_content_close;

}

/**
 * Title.
 */
function wpbf_title() {

	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	$removetitle = $options ? in_array( 'remove-title', $options ) : false;

	$title = $removetitle ? false : '<h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1>';

	if ( wpbf_is_premium() ) {

		$wpbf_settings = get_option( 'wpbf_settings' );

		$removetitle_global = isset( $wpbf_settings['wpbf_removetitle_global'] ) ? $wpbf_settings['wpbf_removetitle_global'] : array();

		$title = $removetitle_global && in_array( get_post_type(), $removetitle_global ) ? false : $title;

	}

	// Use this filter if you want to hide the title from specific pages, etc.
	// To actually change the title itself please filter the_title() directly.
	$title = apply_filters( 'wpbf_title', $title );

	if ( $title ) {

		do_action( 'wpbf_before_page_title' );

		echo $title;

		do_action( 'wpbf_after_page_title' );

	}

}

/**
 * Disable header.
 */
function wpbf_remove_header() {

	// Stop here if we're on archives.
	if ( ! is_singular() ) {
		return;
	}

	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// Check if header is disabled.
	$remove_header = $options ? in_array( 'remove-header', $options, true ) : false;

	// Remove header if disabled.
	if ( $remove_header ) {
		remove_action( 'wpbf_header', 'wpbf_do_header' );
	}

}
add_action( 'wp', 'wpbf_remove_header' );

/**
 * Disable footer.
 */
function wpbf_remove_footer() {

	// Stop here if we're on archives.
	if ( ! is_singular() ) {
		return;
	}

	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// Check if footer is disabled.
	$remove_footer = $options ? in_array( 'remove-footer', $options ) : false;

	// Remove footer if disabled.
	if ( $remove_footer ) {
		remove_action( 'wpbf_footer', 'wpbf_do_footer' );
		remove_action( 'wpbf_before_footer', 'wpbf_custom_footer' );
	}

}
add_action( 'wp', 'wpbf_remove_footer' );

/**
 * ScrollTop.
 */
function wpbf_scrolltop() {

	if ( get_theme_mod( 'layout_scrolltop' ) ) {

		$scrollTop = get_theme_mod( 'scrolltop_value', 400 );

		echo '<a class="scrolltop" href="javascript:void(0)" data-scrolltop-value="' . (int) $scrollTop . '">';
		echo '<span class="screen-reader-text">' . __( 'Scroll to Top', 'page-builder-framework' ) . '</span>';
		echo '</a>';

	}

}
add_action( 'wp_footer', 'wpbf_scrolltop' );

/**
 * Archive Class
 *
 * Add unique class to any existing archive type.
 *
 * wpbf-archive-content
 * + wpbf-{post-type}-archive
 * + wpbf-{archive-type}-content (for post archives)
 *
 * + wpbf-{post-type}-archive-content (for cpt archives)
 * + wpbf-{post-type}-taxonomy-content (for cpt-related taxonomies)
 *
 * @return string The archive class.
 */
function wpbf_archive_class() {

	$archive_class = '';

	if ( is_date() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-date-content';
	} elseif ( is_category() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-category-content';
	} elseif ( is_tag() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-tag-content';
	} elseif ( is_author() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-author-content';
	} elseif ( is_home() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-blog-content';
	} elseif ( is_search() ) {
		$archive_class = ' wpbf-archive-content wpbf-post-archive wpbf-search-content';
	} elseif ( is_post_type_archive() ) {

		$post_type = get_post_type();

		// Stop here if no post has been found.
		if ( ! $post_type ) {
			return $archive_class;
		}

		$archive_class  = ' wpbf-archive-content';
		$archive_class .= ' wpbf-' . $post_type . '-archive';
		$archive_class .= ' wpbf-' . $post_type . '-archive-content';

	} elseif ( is_tax() ) {

		$post_type = get_post_type();

		// Stop here if no post has been found.
		if ( ! $post_type ) {
			return $archive_class;
		}

		$archive_class  = ' wpbf-archive-content';
		$archive_class .= ' wpbf-' . $post_type . '-archive';
		$archive_class .= ' wpbf-' . $post_type . '-archive-content';
		$archive_class .= ' wpbf-' . $post_type . '-taxonomy-content';

	}

	return apply_filters( 'wpbf_archive_class', $archive_class );

}

/**
 * Singular class.
 *
 * @return string The singular class.
 */
function wpbf_singular_class() {

	if ( is_singular( 'post' ) ) {
		$singular_class = ' wpbf-single-content wpbf-post-content';
	} elseif ( is_attachment() ) {
		$singular_class = ' wpbf-single-content wpbf-attachment-content';
	} elseif ( is_page() ) {
		$singular_class = ' wpbf-single-content wpbf-page-content';
	} elseif ( is_404() ) {
		$singular_class = ' wpbf-single-content wpbf-404-content';
	} else {
		$post_type      = get_post_type();
		$singular_class = ' wpbf-single-content wpbf-' . $post_type . '-content';
	}

	return apply_filters( 'wpbf_singular_class', $singular_class );

}

/**
 * Archive header.
 */
function wpbf_archive_header() {

	if ( is_author() ) {

		?>
		<section class="wpbf-author-box">
			<h1 class="page-title"><span class="vcard"><?php echo get_the_author(); ?></span></h1>
			<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
			<?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
		</section>
		<?php

	} elseif ( is_home() ) {

		$blog_title = apply_filters( 'wpbf_blog_page_title', '' );

		if ( ! empty( $blog_title ) ) {

			do_action( 'wpbf_before_page_title' );

			echo '<h1 class="page-title">';

			echo $blog_title;

			echo '</h1>';

			do_action( 'wpbf_after_page_title' );

		}

	} elseif ( is_search() ) {

		do_action( 'wpbf_before_page_title' );

		echo '<h1 class="page-title">';

		echo apply_filters( 'wpbf_search_page_title', sprintf(
				/* translators: Search query */
				__( 'Search Results for: %s', 'page-builder-framework' ),
				'<span>' . get_search_query() . '</span>'
			) );

		echo '</h1>';

		do_action( 'wpbf_after_page_title' );

	} else {

		if ( get_the_archive_title() ) {

			do_action( 'wpbf_before_page_title' );

			the_archive_title( '<h1 class="page-title">', '</h1>' );

			do_action( 'wpbf_after_page_title' );

		}

		the_archive_description( '<div class="taxonomy-description">', '</div>' );

	}

}

/**
 * Archive headline.
 *
 * @param string $title The archive headline.
 *
 * @return string The updated archive headline.
 */
function wpbf_archive_title( $title ) {

	$archive_headline = get_theme_mod( 'archive_headline' );

	if ( is_category() ) {

		if ( 'hide_prefix' === $archive_headline ) {
			$title = single_cat_title( '', false );
		} elseif ( 'hide' === $archive_headline ) {
			$title = false;
		}

	} elseif ( is_tag() ) {

		if ( 'hide_prefix' === $archive_headline ) {
			$title = single_tag_title( '', false );
		} elseif ( 'hide' === $archive_headline ) {
			$title = false;
		}

	} elseif ( is_date() ) {

		$date = get_the_date( 'F Y' );
		if ( is_year() ) {
			$date = get_the_date( 'Y' );
		}

		if ( is_day() ) {
			$date = get_the_date( 'F j, Y' );
		}

		if ( 'hide_prefix' === $archive_headline ) {
			$title = $date;
		} elseif ( 'hide' === $archive_headline ) {
			$title = false;
		}

	} elseif ( is_post_type_archive() ) {

		if ( 'hide_prefix' === $archive_headline ) {
			$title = post_type_archive_title( '', false );
		} elseif ( 'hide' === $archive_headline ) {
			$title = false;
		}

	} elseif ( is_tax() ) {

		if ( 'hide_prefix' === $archive_headline ) {
			$title = single_term_title( '', false );
		} elseif ( 'hide' === $archive_headline ) {
			$title = false;
		}

	}

	return $title;

}
add_filter( 'get_the_archive_title', 'wpbf_archive_title', 10 );

/**
 * Post links.
 *
 * Display the post navigation on posts.
 */
function wpbf_do_post_links() {

	if ( 'hide' === get_theme_mod( 'single_post_nav' ) ) {
		return;
	}

	do_action( 'wpbf_before_post_links' );

	?>

	<nav class="post-links wpbf-clearfix" aria-label="<?php _e( 'Post Navigation', 'page-builder-framework' ); ?>">

		<span class="screen-reader-text"><?php _e( 'Post Navigation', 'page-builder-framework' ) ?></span>

		<?php
		previous_post_link( '<span class="previous-post-link">%link</span>', apply_filters( 'wpbf_previous_post_link', __( '&larr; Previous Post', 'page-builder-framework' ) ) );
		next_post_link( '<span class="next-post-link">%link</span>', apply_filters( 'wpbf_next_post_link', __( 'Next Post &rarr;', 'page-builder-framework' ) ) );
		?>

	</nav>

	<?php

	do_action( 'wpbf_after_post_links' );

}
add_action( 'wpbf_post_links', 'wpbf_do_post_links' );

/**
 * Posts pagination.
 *
 * Display the posts pagination on archives.
 */
function wpbf_do_posts_pagination() {

	the_posts_pagination( array(
		'mid_size'  => apply_filters( 'wpbf_posts_pagination_size', 2 ),
		'prev_text' => apply_filters( 'wpbf_posts_navigation_prev_text', __( '&larr; Previous', 'page-builder-framework' ) ),
		'next_text' => apply_filters( 'wpbf_posts_navigation_next_text', __( 'Next &rarr;', 'page-builder-framework' ) ),
	) );

}
add_action( 'wpbf_posts_pagination', 'wpbf_do_posts_pagination' );

if ( ! function_exists( 'wpbf_has_responsive_breakpoints' ) ) {

	/**
	 * Responsive breakpoints.
	 *
	 * Simple check if responsive breakpoints are set.
	 *
	 * @return boolean.
	 */
	function wpbf_has_responsive_breakpoints() {

		// There can't be responsive breakpoints if there's no Premium Add-On.
		if ( ! wpbf_is_premium() ) {
			return false;
		}

		$wpbf_settings = get_option( 'wpbf_settings' );

		// Check if custom breakpoints are set, otherwise return false.
		if ( ! empty( $wpbf_settings['wpbf_breakpoint_medium'] ) || ! empty( $wpbf_settings['wpbf_breakpoint_desktop'] ) || ! empty( $wpbf_settings['wpbf_breakpoint_mobile'] ) ) {
			return true;
		} else {
			return false;
		}

	}

}

/**
 * Render right sidebar.
 */
function wpbf_do_sidebar_right() {

	if ( 'right' === wpbf_sidebar_layout() ) {
		get_sidebar();
	}

}
add_action( 'wpbf_sidebar_right', 'wpbf_do_sidebar_right' );

/**
 * Render left sidebar.
 */
function wpbf_do_sidebar_left() {

	if ( 'left' === wpbf_sidebar_layout() ) {
		get_sidebar();
	}

}
add_action( 'wpbf_sidebar_left', 'wpbf_do_sidebar_left' );

/**
 * Sidebar layout.
 *
 * @return string The sidebar layout.
 */
function wpbf_sidebar_layout() {

	// Set default sidebar position.
	$sidebar = get_theme_mod( 'sidebar_position', 'right' );

	$archive_sidebar_position = get_theme_mod( 'archive_sidebar_layout', 'global' );
	$sidebar                  = 'global' !== $archive_sidebar_position ? $archive_sidebar_position : $sidebar;

	if ( is_singular() && ! is_page() ) {

		$single_sidebar_position        = get_post_meta( get_the_ID(), 'wpbf_sidebar_position', true );
		$single_sidebar_position_global = get_theme_mod( 'single_sidebar_layout', 'global' );

		$sidebar = 'global' !== $single_sidebar_position_global ? $single_sidebar_position_global : $sidebar;
		$sidebar = $single_sidebar_position && 'global' !== $single_sidebar_position ? $single_sidebar_position : $sidebar;

	}

	if ( is_page() ) {

		$single_sidebar_position        = get_post_meta( get_the_ID(), 'wpbf_sidebar_position', true );
		$single_sidebar_position_global = get_theme_mod( 'single_sidebar_layout', 'global' );

		// By default there is no sidebar on pages.
		$sidebar = 'none';

		// Backwards compatibility. For pages that have the sidebar template selected, we inherit the global settings.
		if ( is_page_template( 'page-sidebar.php' ) ) {
			$sidebar = 'global' !== $single_sidebar_position_global ? $single_sidebar_position_global : $sidebar;
		}

		$sidebar = $single_sidebar_position && 'global' !== $single_sidebar_position ? $single_sidebar_position : $sidebar;

	}

	if ( is_404() ) {
		// There is no sidebar on 404 pages.
		// We do this to output the correct body class.
		$sidebar = 'none';
	}

	return apply_filters( 'wpbf_sidebar_layout', $sidebar );

}

/*
 * Article meta.
 *
 * Construct sortable article meta.
 */
function wpbf_article_meta() {

	$blog_meta = get_theme_mod( 'blog_sortable_meta', array( 'author', 'date' ) );

	if ( is_array( $blog_meta ) && ! empty( $blog_meta ) ) {

		do_action( 'wpbf_before_article_meta' );
		echo '<p class="article-meta">';
		do_action( 'wpbf_article_meta_open' );

		foreach ( $blog_meta as $value ) {

			switch ( $value ) {
				case 'author':
					do_action( 'wpbf_before_author_meta' );
					do_action( 'wpbf_do_author_meta' );
					do_action( 'wpbf_after_author_meta' );
					break;
				case 'date':
					do_action( 'wpbf_before_date_meta' );
					do_action( 'wpbf_do_date_meta' );
					do_action( 'wpbf_after_date_meta' );
					break;
				case 'comments':
					do_action( 'wpbf_before_comments_meta' );
					do_action( 'wpbf_do_comments_meta' );
					do_action( 'wpbf_after_comments_meta' );
					break;
				default:
					break;
			}

		}

		do_action( 'wpbf_article_meta_close' );
		echo '</p>';
		do_action( 'wpbf_after_article_meta' );

	}

}

/**
 * Article meta (author).
 */
function wpbf_author_meta() {

	$rtl         = is_rtl();
	$avatar      = get_theme_mod( 'blog_author_avatar' );
	$avatar_size = apply_filters( 'wpbf_author_meta_avatar_size', 128 );

	if ( ! $rtl && $avatar ) {
		echo get_avatar( get_the_author_meta( 'ID' ), $avatar_size );
	}

	echo sprintf(
		'<span class="article-author author vcard" itemscope="itemscope" itemprop="author" itemtype="https://schema.org/Person"><a class="url fn" href="%1$s" title="%2$s" rel="author" itemprop="url"><span itemprop="name">%3$s</span></a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'page-builder-framework' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);

	if ( $rtl && $avatar ) {
		echo get_avatar( get_the_author_meta( 'ID' ), $avatar_size );
	}

	echo '<span class="article-meta-separator">' . apply_filters( 'wpbf_article_meta_separator', ' | ' ) . '</span>';

}
add_action( 'wpbf_do_author_meta', 'wpbf_author_meta' );

/*
 * Article meta (date).
 */
function wpbf_date_meta() {

	echo '<span class="posted-on">' . __( 'Posted on', 'page-builder-framework' ) . '</span> <time class="article-time published" datetime="' . get_the_date( 'c' ) . '" itemprop="datePublished">' . get_the_date() . '</time>';
	echo '<span class="article-meta-separator">' . apply_filters( 'wpbf_article_meta_separator', ' | ' ) . '</span>';

}
add_action( 'wpbf_do_date_meta', 'wpbf_date_meta' );

/**
 * Article meta (comments).
 */
function wpbf_comments_meta() {

	echo '<span class="comments-count">';

	comments_number(
		__( '<span>No</span> Comments', 'page-builder-framework' ),
		__( '<span>1</span> Comment', 'page-builder-framework' ),
		__( '<span>%</span> Comments', 'page-builder-framework' )
	);

	echo '</span>';

	echo '<span class="article-meta-separator">' . apply_filters( 'wpbf_article_meta_separator', ' | ' ) . '</span>';

}
add_action( 'wpbf_do_comments_meta', 'wpbf_comments_meta' );

/**
 * Blog layout.
 *
 * @return array The blog layout.
 */
function wpbf_blog_layout() {

	$template_parts_header = get_theme_mod( 'archive_sortable_header', array( 'title', 'meta', 'featured' ) );
	$template_parts_footer = get_theme_mod( 'archive_sortable_footer', array( 'readmore', 'categories' ) );
	$blog_layout           = get_theme_mod( 'archive_layout', 'default' );
	$style                 = get_theme_mod( 'archive_post_style', 'plain' );
	$stretched             = get_theme_mod( 'archive_boxed_image_streched', false );

	if ( 'beside' !== $blog_layout && 'boxed' === $style && $stretched ) {
		$style .= ' stretched';
	}

	return apply_filters(
		'wpbf_blog_layout',
		array(
			'blog_layout'           => $blog_layout,
			'template_parts_header' => $template_parts_header,
			'template_parts_footer' => $template_parts_footer,
			'style'                 => $style,
		)
	);

}

/**
 * Declare menu's.
 *
 * Declare wp_nav_menu based on selected menu variation.
 */
function wpbf_nav_menu() {

	$custom_menu   = get_theme_mod( 'menu_custom' );
	$menu_position = get_theme_mod( 'menu_position' );

	if ( $custom_menu ) {

		echo do_shortcode( $custom_menu );

	} elseif ( in_array( $menu_position, array( 'menu-off-canvas', 'menu-off-canvas-left' ) ) ) {

		// Off canvas menu.
		wp_nav_menu(
			array(
				'theme_location' => 'main_menu',
				'container'      => false,
				'menu_class'     => 'wpbf-menu',
				'depth'          => 3,
				'fallback_cb'    => 'wpbf_main_menu_fallback',
			)
		);

	} elseif ( 'menu-full-screen' === $menu_position ) {

		// Full screen menu.
		wp_nav_menu(
			array(
				'theme_location' => 'main_menu',
				'container'      => false,
				'menu_class'     => 'wpbf-menu',
				'depth'          => 1,
				'fallback_cb'    => 'wpbf_main_menu_fallback',
			)
		);

	} elseif ( 'menu-vertical-left' === $menu_position ) {

		// Full screen menu.
		wp_nav_menu(
			array(
				'theme_location' => 'main_menu',
				'container'      => false,
				'menu_class'     => 'wpbf-menu',
				'depth'          => 1,
				'fallback_cb'    => 'wpbf_main_menu_fallback',
			)
		);

	} else {

		// Default menu.
		wp_nav_menu(
			array(
				'theme_location' => 'main_menu',
				'container'      => false,
				'menu_class'     => 'wpbf-menu wpbf-sub-menu' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation() . wpbf_menu_hover_effect(),
				'depth'          => 4,
				'fallback_cb'    => 'wpbf_main_menu_fallback',
			)
		);

	}

}
add_action( 'wpbf_main_menu', 'wpbf_nav_menu' );

/**
 * Declare mobile menu's.
 *
 * Declare wp_nav_menu based on selected mobile menu variation.
 */
function wpbf_mobile_nav_menu() {

	$custom_menu   = get_theme_mod( 'menu_custom' );
	$menu_position = get_theme_mod( 'mobile_menu_options', 'menu-mobile-hamburger' );

	if ( $custom_menu ) {

		echo do_shortcode( $custom_menu );

	} else {

		wp_nav_menu( array(
			'theme_location' => 'mobile_menu',
			'container'      => false,
			'menu_class'     => 'wpbf-mobile-menu',
			'depth'          => 4,
			'fallback_cb'    => 'wpbf_mobile_menu_fallback',
		) );

	}

}
add_action( 'wpbf_mobile_menu', 'wpbf_mobile_nav_menu' );

/**
 * Render main menu.
 *
 * Render main menu based on selected menu variation.
 */
function wpbf_menu() {
	get_template_part( 'inc/template-parts/navigation/' . apply_filters( 'wpbf_menu_variation', get_theme_mod( 'menu_position', 'menu-right' ) ) );
}
add_action( 'wpbf_navigation', 'wpbf_menu' );

/**
 * Render mobile menu.
 *
 * Render mobile menu based on selected mobile menu variation.
 */
function wpbf_mobile_menu() {
	get_template_part( 'inc/template-parts/navigation/' . apply_filters( 'wpbf_mobile_menu_variation', get_theme_mod( 'mobile_menu_options', 'menu-mobile-hamburger' ) ) );
}
add_action( 'wpbf_mobile_navigation', 'wpbf_mobile_menu' );

/**
 * Is off canvas menu check.
 *
 * Simple check to determine wether an off canvas menu is used.
 *
 * @return boolean.
 */
function wpbf_is_off_canvas_menu() {

	if ( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left', 'menu-full-screen' ) ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Add sub menu indicators to mobile & off canvas menu's.
 *
 * @param string  $item_output The menu item's starting HTML output.
 * @param object  $item The menu item data object.
 * @param integer $depth Depth of menu item.
 * @param object  $args The arguments.
 *
 * @return string The updated mobile menu item's starting HTML output.
 */
function wpbf_mobile_sub_menu_indicators( $item_output, $item, $depth, $args ) {

	if ( 'mobile_menu' === $args->theme_location || ( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left' ) ) && 'main_menu' === $args->theme_location ) ) {

		if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
			$item_output .= '<button class="wpbf-submenu-toggle" aria-expanded="false"><i class="wpbff wpbff-arrow-down" aria-hidden="true"></i><span class="screen-reader-text">' . __( 'Menu Toggle', 'page-builder-framework' ) . '</span></button>';
		}
	}

	return $item_output;

}
add_filter( 'walker_nav_menu_start_el', 'wpbf_mobile_sub_menu_indicators', 10, 4 );

/**
 * Submenu alignment class.
 *
 * @return string The submenu alignment class.
 */
function wpbf_sub_menu_alignment() {

	$sub_menu_alignment = get_theme_mod( 'sub_menu_alignment', 'left' );

	return ' wpbf-sub-menu-align-' . $sub_menu_alignment;

}

/**
 * Submenu animation class.
 *
 * @return string The submenu animation class.
 */
function wpbf_sub_menu_animation() {

	$sub_menu_animation = get_theme_mod( 'sub_menu_animation', 'fade' );

	return ' wpbf-sub-menu-animation-' . $sub_menu_animation;

}

/**
 * Menu alignment class.
 *
 * @return string The menu alignment class.
 */
function wpbf_menu_alignment() {

	$alignment = get_theme_mod( 'menu_alignment', 'left' );

	return ' menu-align-' . $alignment;

}

/**
 * Navigation hover effect classes.
 *
 * @return string The navigation hover effect classes.
 */
function wpbf_menu_hover_effect() {

	$menu_effect           = get_theme_mod( 'menu_effect', 'none' );
	$menu_effect_animation = get_theme_mod( 'menu_effect_animation', 'fade' );
	$menu_effect_alignment = get_theme_mod( 'menu_effect_alignment', 'center' );

	$hover_effect  = ' wpbf-menu-effect-' . $menu_effect;
	$hover_effect .= ' wpbf-menu-animation-' . $menu_effect_animation;
	$hover_effect .= ' wpbf-menu-align-' . $menu_effect_alignment;

	return $hover_effect;

}

/**
 * Navigation attributes.
 *
 * Currently only being used to add the submenu animation duration.
 */
function wpbf_navigation_attributes() {

	$submenu_animation_duration = get_theme_mod( 'sub_menu_animation_duration' );
	$navigation_attributes      = $submenu_animation_duration ? 'data-sub-menu-animation-duration="' . esc_attr( $submenu_animation_duration ) . '"' : 'data-sub-menu-animation-duration="250"';

	echo $navigation_attributes;

}

/**
 * Responsive embed/oembed.
 *
 * @param string $html The HTML output.
 * @param string $url The embed URL.
 * @param array  $attr Array of shortcode attributes.
 *
 * @return string The updated HTML output.
 */
function wpbf_responsive_embed( $html, $url, $attr ) {

	$providers = array( 'vimeo.com', 'youtube.com', 'youtu.be', 'wistia.com', 'wistia.net' );

	if ( wpbf_strposa( $url, $providers ) ) {
		$html = '<div class="wpbf-video">' . $html . '</div>';
	}

	return $html;

}
add_filter( 'embed_oembed_html', 'wpbf_responsive_embed', 10, 3 );

/**
 * Page builder compatibility.
 *
 * Make the page full-width & remove the title if Page Builder is being used.
 *
 * @param int $id the ID.
 */
function wpbf_page_builder_compatibility( $id ) {

	// Stop here if we're not on a page.
	if ( 'page' !== get_post_type() ) {
		return;
	}

	$elementor  = get_post_meta( $id, '_elementor_edit_mode', true );
	$fl_enabled = get_post_meta( $id, '_fl_builder_enabled', true );

	if ( $fl_enabled || 'builder' === $elementor ) {

		$wpbf_stored_meta = get_post_meta( $id );
		$mydata           = $wpbf_stored_meta['wpbf_options'];

		// Stop here if auto conversion already took place.
		if ( in_array( 'auto-convert', $mydata ) ) {
			return;
		}

		$mydata[] .= 'remove-title';
		$mydata[] .= 'full-width';
		$mydata[] .= 'auto-convert';

		update_post_meta( $id, 'wpbf_options', $mydata );

	}

}
// add_action( 'wpbf_page_builder_compatibility', 'task' );
