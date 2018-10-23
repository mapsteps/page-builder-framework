<?php
/**
 * Helpers
 *
 * Collection of helper functions
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Is Premium
function wpbf_is_premium() {
	if ( function_exists( 'wpbf_premium' ) ) {
		return true;
	} else {
		return false;
	}
}

// Pingback
function wpbf_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="'. esc_url( get_bloginfo( 'pingback_url' ) ) .'">';
	}

}
add_action( 'wp_head', 'wpbf_pingback_header' );

// Schema Markup
function wpbf_body_schema_markup() {

	// Set up blog variable
	$is_blog = ( is_home() || is_date() || is_category() || is_author() || is_tag() || is_attachment() || is_singular( 'post' ) ) ? true : false;

	// Set up default itemtype
	$itemtype = 'WebPage';

	// Get itemtype for the blog
	$itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

	// Get itemtype for search results
	$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;

	// Get the result
	$result = apply_filters( 'wpbf_body_itemtype', $itemtype );

	// Return our HTML
	echo 'itemscope="itemscope" itemtype="https://schema.org/'. esc_html( $result ) . '"'; // WPCS: XSS ok.

}

// Inner Content
function wpbf_inner_content() {

	// get options
	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// checking if template is set to full width (returns true if so)
	$fullwidth = $options ? in_array( 'full-width', $options ) : false;

	$inner_content = $fullwidth ? false : '<div id="inner-content" class="wpbf-container wpbf-container-center wpbf-padding-medium">';

	if ( wpbf_is_premium() ) {

		$wpbf_settings = get_option( 'wpbf_settings' );

		$fullwidth_global = isset( $wpbf_settings['wpbf_fullwidth_global'] ) ? $wpbf_settings['wpbf_fullwidth_global'] : false;

		$fullwidth_global && in_array( get_post_type(), $fullwidth_global ) ? $inner_content = false : '';

	}

	echo $inner_content; // WPCS: XSS ok.

}

// Inner Content Close
function wpbf_inner_content_close() {

	// get options
	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// checking if template is set to full width (returns true if so)
	$fullwidth = $options ? in_array( 'full-width', $options ) : false;

	$inner_content_close = $fullwidth ? false : '</div>';

	if ( wpbf_is_premium() ) {

		$wpbf_settings = get_option( 'wpbf_settings' );

		$fullwidth_global = isset( $wpbf_settings['wpbf_fullwidth_global'] ) ? $wpbf_settings['wpbf_fullwidth_global'] : false;

		$fullwidth_global && in_array( get_post_type(), $fullwidth_global ) ? $inner_content = false : '';

	}

	echo $inner_content_close; // WPCS: XSS ok.

}

// Title
function wpbf_title() {

	// get options
	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// checking if remove title is checked (returns true if so)
	$removetitle = $options ? in_array( 'remove-title', $options ) : false;

	$title = $removetitle ? false : '<h1 class="entry-title" itemprop="headline">'. get_the_title() .'</h1>';

	if ( wpbf_is_premium() ) {

		$wpbf_settings = get_option( 'wpbf_settings' );

		$removetitle_global = isset( $wpbf_settings['wpbf_removetitle_global'] ) ? $wpbf_settings['wpbf_removetitle_global'] : false;

		$removetitle_global && in_array( get_post_type(), $removetitle_global ) ? $title = false : '';

	}

	echo $title; // WPCS: XSS ok.

}

// Mobile Logo
function wpbf_mobile_logo( $custom_logo_url ) {

	$custom_mobile_logo = get_theme_mod( 'menu_mobile_logo' );

	// check if custom mobile logo is set
	if( $custom_mobile_logo ) {
		$custom_logo_url = $custom_mobile_logo;
	}

	return $custom_logo_url;

}
// add_filter( 'wpbf_logo_mobile', 'wpbf_mobile_logo', 10 );

// Remove Header
function wpbf_remove_header() {

	// don't take it further if we're on archives
	if( !is_singular() ) return;

	// get options
	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// checking if transparent header is checked (returns true if so)
	$remove_header = $options ? in_array( 'remove-header', $options ) : false;

	if( $remove_header ) {
		remove_action( 'wpbf_header', 'wpbf_do_header' );
	}

}
add_action( 'wp', 'wpbf_remove_header' );

// Remove Footer
function wpbf_remove_footer() {

	// don't take it further if we're on archives
	if( !is_singular() ) return;

	// get options
	$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

	// checking if transparent header is checked (returns true if so)
	$remove_footer = $options ? in_array( 'remove-footer', $options ) : false;

	if( $remove_footer ) {
		remove_action( 'wpbf_footer', 'wpbf_do_footer' );
		remove_action( 'wpbf_before_footer', 'wpbf_custom_footer' );
	}

}
add_action( 'wp', 'wpbf_remove_footer' );

// ScrollTop
function wpbf_scrolltop() {

	if ( get_theme_mod( 'layout_scrolltop' ) ) {

		$scrollTop = get_theme_mod( 'scrolltop_value', 400 );

		?>

		<div class="scrolltop" data-scrolltop-value="<?php echo (int) $scrollTop; ?>"></div>

	<?php }

}
add_action( 'wp_footer', 'wpbf_scrolltop' );

// Archive Class
function wpbf_archive_class() {

	$archive_class = '';

	if( is_date() ) {
		$archive_class = ' wpbf-post-archive wpbf-date-content';
	} elseif( is_category() ) {
		$archive_class = ' wpbf-post-archive wpbf-category-content';
	} elseif( is_tag() ) {
		$archive_class = ' wpbf-post-archive wpbf-tag-content';
	} elseif( is_author() ) {
		$archive_class = ' wpbf-post-archive wpbf-author-content';
	} elseif( is_home() ) {
		$archive_class = ' wpbf-post-archive wpbf-index-content';
	} elseif( is_search() ) {
		$archive_class = ' wpbf-post-archive wpbf-search-content';
	} elseif( is_tax() ) {

		$post_type = get_post_type();
		if( !$post_type ) return $archive_class;

		$archive_class = ' wpbf-'. $post_type .'-archive';
		$archive_class .= ' wpbf-'. $post_type .'-taxonomy-content';

	} elseif( is_post_type_archive() ) {

		$post_type = get_post_type();
		if( !$post_type ) return $archive_class;

		$archive_class = ' wpbf-'. $post_type .'-archive';
		$archive_class .= ' wpbf-'. $post_type .'-archive-content';

	}

	return $archive_class;

}

// Singular Class
function wpbf_singular_class() {

	$singular_class = '';

	if( is_singular( 'post' ) ) {
		$singular_class = ' wpbf-single-content';
	} elseif( is_attachment() ) {
		$singular_class = ' wpbf-attachment-content';
	} elseif( is_page() ) {
		$singular_class = ' wpbf-page-content';
	} elseif( is_404() ) {
		$singular_class = ' wpbf-404-content';
	} else {
		$post_type = get_post_type();
		$singular_class = ' wpbf-'. $post_type .'-content';
	}

	return $singular_class;

}

// Archive Header
function wpbf_archive_header() {

	if( is_category() ) {

		if ( !get_theme_mod( 'category_headline' ) || get_theme_mod( 'category_headline' ) == 'show' ) {

			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );

		}

	} elseif( is_author() ) { ?>

		<section class="wpbf-author-box">
			<h1 class="page-title"><?php echo get_the_author(); ?></h1>
			<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
			<div class="wpbf-avatar">
				<?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
			</div>
		</section>

	<?php } else {

		if ( !get_theme_mod( 'archive_headline' ) || get_theme_mod( 'archive_headline' ) == 'show' ) {

			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );

		}

	}

}

// Responsive Breakpoints
if( !function_exists( 'wpbf_has_responsive_breakpoints' ) ) {

	function wpbf_has_responsive_breakpoints() {

		// stop here if premium add-on doesn't exist
		if( !wpbf_is_premium() ) return false;

		// check if custom breakpoints are set, otherwise return false
		$wpbf_settings = get_option( 'wpbf_settings' );

		if ( !empty( $wpbf_settings['wpbf_breakpoint_medium'] ) || !empty( $wpbf_settings['wpbf_breakpoint_desktop'] ) ) {
			return true;
		} else {
			return false;
		}

	}

}

// Sidebar Right
function wpbf_do_sidebar_right() {

	$global_sidebar_position = get_theme_mod( 'sidebar_position' );
	$blog_sidebar_position = get_theme_mod( 'blog_sidebar_layout' );
	$category_sidebar_position = get_theme_mod( 'category_sidebar_layout' );
	$archive_sidebar_position = get_theme_mod( 'archive_sidebar_layout' );
	$single_sidebar_position_global = get_theme_mod( 'single_sidebar_layout' );

	if( is_singular() ) {

		$id = get_the_ID();
		$single_sidebar_position = get_post_meta( $id, 'wpbf_sidebar_position', true );

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			if( $single_sidebar_position == 'left' || $single_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'global' ) {

			if( $single_sidebar_position_global == 'left' || $single_sidebar_position_global == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} else {

			if( $global_sidebar_position == 'left' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		}

	} elseif ( is_home() ) {

		if ( !$blog_sidebar_position || $blog_sidebar_position == 'global' ) {

			if( $global_sidebar_position == 'left' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $blog_sidebar_position == 'left' || $blog_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}
		
	} elseif ( is_category() ) {

		if ( !$category_sidebar_position || $category_sidebar_position == 'global' ) {

			if( $global_sidebar_position == 'left' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $category_sidebar_position == 'left' || $category_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	} elseif ( is_archive() ) {

		if ( !$archive_sidebar_position || $archive_sidebar_position == 'global' ) {

			if( $global_sidebar_position == 'left' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $archive_sidebar_position == 'left' || $archive_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	} else {

		if( $global_sidebar_position == 'left' || $global_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	}

}

add_action( 'wpbf_sidebar_right', 'wpbf_do_sidebar_right' );

// Sidebar Left
function wpbf_do_sidebar_left() {

	$global_sidebar_position = get_theme_mod( 'sidebar_position' );
	$blog_sidebar_position = get_theme_mod( 'blog_sidebar_layout' );
	$category_sidebar_position = get_theme_mod( 'category_sidebar_layout' );
	$archive_sidebar_position = get_theme_mod( 'archive_sidebar_layout' );
	$single_sidebar_position_global = get_theme_mod( 'single_sidebar_layout' );

	if( is_singular() ) {

		$id = get_the_ID();
		$single_sidebar_position = get_post_meta( $id, 'wpbf_sidebar_position', true );

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			if( $single_sidebar_position == 'right' || $single_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'global' ) {

			if( $single_sidebar_position_global == 'right' || $single_sidebar_position_global == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} else {

			if( !$global_sidebar_position || $global_sidebar_position == 'right' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		}

	} elseif ( is_home() ) {

		if ( !$blog_sidebar_position || $blog_sidebar_position == 'global' ) {

			if( !$global_sidebar_position || $global_sidebar_position == 'right' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $blog_sidebar_position == 'right' || $blog_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}
		
	} elseif ( is_category() ) {

		if ( !$category_sidebar_position || $category_sidebar_position == 'global' ) {

			if( !$global_sidebar_position || $global_sidebar_position == 'right' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $category_sidebar_position == 'right' || $category_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	} elseif ( is_archive() ) {

		if ( !$archive_sidebar_position || $archive_sidebar_position == 'global' ) {

			if( !$global_sidebar_position || $global_sidebar_position == 'right' || $global_sidebar_position == 'none' ) {

				return false;

			} else {

				get_sidebar();

			}

		} elseif( $archive_sidebar_position == 'right' || $archive_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	} else {

		if( !$global_sidebar_position || $global_sidebar_position == 'right' || $global_sidebar_position == 'none' ) {

			return false;

		} else {

			get_sidebar();

		}

	}

}

add_action( 'wpbf_sidebar_left', 'wpbf_do_sidebar_left' );

// Navigation
add_action( 'wpbf_main_menu', 'wpbf_nav_menu' );

function wpbf_nav_menu() {

	if( get_theme_mod( 'menu_custom' ) ) {

		$custom_menu = get_theme_mod( 'menu_custom' );

		echo do_shortcode( $custom_menu );

	} elseif( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left' ) ) ) {

		wp_nav_menu( array(
			'theme_location'	=>		'main_menu',
			'container'			=>		false,
			'menu_class'		=>		'wpbf-menu',
			'depth'				=>		3,
			'fallback_cb'		=>		'wpbf_menu_fallback'
		));

	} elseif ( get_theme_mod( 'menu_position' ) == 'menu-full-screen' ) {

		wp_nav_menu( array(
			'theme_location'	=>		'main_menu',
			'container'			=>		false,
			'menu_class'		=>		'wpbf-menu',
			'depth'				=>		1,
			'fallback_cb'		=>		'wpbf_menu_fallback'
		));

	} else {

		wp_nav_menu( array(
			'theme_location'	=>		'main_menu',
			'container'			=>		false,
			'menu_class'		=>		'wpbf-menu wpbf-sub-menu'. wpbf_sub_menu_animation() . wpbf_menu_effect() . wpbf_menu_effect_animation() . wpbf_menu_effect_alignment() .'',
			'depth'				=>		3,
			'fallback_cb'		=>		'wpbf_menu_fallback'
		));
	}
}

// Menu
function wpbf_menu() {
	return get_theme_mod( 'menu_position', 'menu-right' );
}

// Mobile Menu
function wpbf_mobile_menu() {
	return get_theme_mod( 'mobile_menu_options', 'menu-mobile-hamburger' );
}

function wpbf_is_off_canvas_menu() {
	if( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left', 'menu-full-screen' ) ) ) {
		return true;
	} else {
		return false;
	}
}

// Alignment
function wpbf_menu_alignment() {

	$alignment = get_theme_mod( 'menu_alignment', 'left' );
	$alignment = ' menu-align-' . $alignment;

	return $alignment;

}

// Menu Effect
function wpbf_menu_effect() {

	$menu_effect = get_theme_mod( 'menu_effect', 'none' );
	$menu_effect = ' wpbf-menu-effect-' . $menu_effect;

	return $menu_effect;

}

// Menu Animation
function wpbf_menu_effect_animation() {

	$menu_effect_animation = get_theme_mod( 'menu_effect_animation', 'fade' );
	$menu_effect_animation = ' wpbf-menu-animation-' . $menu_effect_animation;

	return $menu_effect_animation;

}

// Menu Alignment
function wpbf_menu_effect_alignment() {

	$menu_effect_alignment = get_theme_mod( 'menu_effect_alignment', 'center' );
	$menu_effect_alignment = ' wpbf-menu-align-' . $menu_effect_alignment;

	return $menu_effect_alignment;

}

// Sub Menu Animation
function wpbf_sub_menu_animation() {

	$sub_menu_animation = get_theme_mod( 'sub_menu_animation', 'fade' );
	$sub_menu_animation = ' wpbf-sub-menu-animation-' . $sub_menu_animation;

	return $sub_menu_animation;

}

// Navigation Attributes
function wpbf_navigation_attributes() {

	// vars
	$submenu_animation_duration = get_theme_mod( 'sub_menu_animation_duration' );

	// Construct Navigation Attributes
	$navigation_attributes = $submenu_animation_duration ? 'data-sub-menu-animation-duration="' . esc_attr( $submenu_animation_duration ) . '"' : 'data-sub-menu-animation-duration="250"';

	echo $navigation_attributes; // WPCS: XSS ok.

}