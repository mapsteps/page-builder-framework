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

	$title = $removetitle ? false : '<h1 class="entry-title">'. get_the_title() .'</h1>';

	if ( wpbf_is_premium() ) {

		$wpbf_settings = get_option( 'wpbf_settings' );

		$removetitle_global = isset( $wpbf_settings['wpbf_removetitle_global'] ) ? $wpbf_settings['wpbf_removetitle_global'] : false;

		$removetitle_global && in_array( get_post_type(), $removetitle_global ) ? $title = false : '';

	}

	echo wp_kses_post( $title );

}

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
	$remove_header = $options ? in_array( 'remove-footer', $options ) : false;

	if( $remove_header ) {
		remove_action( 'wpbf_footer', 'wpbf_do_footer' );
		remove_action( 'wpbf_before_footer', 'wpbf_custom_footer' );
	}

}
add_action( 'wp', 'wpbf_remove_footer' );

// ScrollTop
function wpbf_scrolltop() {

	if ( get_theme_mod( 'layout_scrolltop' ) ) {

		$scrollTop = get_theme_mod( 'scrolltop_value' ) ? get_theme_mod( 'scrolltop_value' ) : 400;

		?>

		<div class="scrolltop" data-scrolltop-value="<?php echo (int) $scrollTop; ?>"></div>

	<?php }

}
add_action( 'wp_footer', 'wpbf_scrolltop' );

// Archive Class
function wpbf_archive_class() {
	$archive_class = '';
	if( is_category() ) {
		$archive_class = 'wpbf-category-content';
	} else {
		$archive_class = 'wpbf-archive-content';
	}
	echo $archive_class; // WPCS: XSS ok.
}

// Archive Header
function wpbf_archive_header() {

	if( is_category() ) {

		if ( !get_theme_mod( 'category_headline' ) || get_theme_mod( 'category_headline' ) == 'show' ) { ?>

			<h1 class="entry-title category-title"><?php the_archive_title(); ?></h1>

		<?php

		}

		if( category_description() ) { ?>

		<div class="wpbf-category-description"><?php echo category_description(); ?></div>

		<?php

		}

	} elseif( is_search() ) { ?>

		<h1 class="entry-title search-title">
			<?php
			printf( // WPCS: XSS ok.
				/* translators: 1: Search query name */
				__( 'Search Results for: %s', 'page-builder-framework' ),
				'<span>' . get_search_query() . '</span>'
			);
			?>
		</h1>

	<?php } elseif( is_author() ) { ?>

		<section class="wpbf-author-box">
			<h1 class='entry-title'><?php echo get_the_author(); ?></h1>
			<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
			<div class="wpbf-avatar">
				<?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
			</div>
		</section>

	<?php } else {

		if ( !get_theme_mod( 'archive_headline' ) || get_theme_mod( 'archive_headline' ) == 'show' ) {

			the_archive_title( '<h1 class="entry-title archive-title">', '</h1>' );
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

	} elseif( get_theme_mod( 'menu_position' ) == 'menu-right' || get_theme_mod( 'menu_position' ) == 'menu-left' || get_theme_mod( 'menu_position' ) == 'menu-centered' || get_theme_mod( 'menu_position' ) == 'menu-stacked' || get_theme_mod( 'menu_position' ) == 'menu-stacked-advanced' ) {

		wp_nav_menu( array(
			'theme_location'	=>		'main_menu',
			'container'			=>		false,
			'menu_class'		=>		'wpbf-menu wpbf-sub-menu'. wpbf_sub_menu_animation() . wpbf_menu_effect() . wpbf_menu_effect_animation() . wpbf_menu_effect_alignment() .'',
			'depth'				=>		3,
			'fallback_cb'		=>		'wpbf_menu_fallback'
		));

	} elseif ( get_theme_mod( 'menu_position' ) == 'menu-off-canvas' || get_theme_mod( 'menu_position' ) == 'menu-off-canvas-left' ) {

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
		// Default
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

	$menu = get_theme_mod( 'menu_position' );
	$menu = $menu ? $menu : "menu-right";
	return $menu;

}

// Mobile Menu
function wpbf_mobile_menu() {

	$mobile_menu = get_theme_mod( 'mobile_menu_options' );
	$mobile_menu = $mobile_menu ? $mobile_menu : "menu-mobile-hamburger";
	return $mobile_menu;

}

function wpbf_is_off_canvas_menu() {
	if( get_theme_mod( 'menu_position' ) == 'menu-off-canvas' || get_theme_mod( 'menu_position' ) == 'menu-off-canvas-left' || get_theme_mod( 'menu_position' ) == 'menu-full-screen' ) {
		return true;
	} else {
		return false;
	}
}

// Alignment
function wpbf_menu_alignment() {

	if ( get_theme_mod( 'menu_alignment' ) ) {
		$alignment = get_theme_mod( 'menu_alignment', true );
		$alignment = ' menu-align-' . $alignment;
	} else {
		$alignment = ' menu-align-left';
	}

	return $alignment;

}

// Menu Effect
function wpbf_menu_effect() {

	if ( get_theme_mod( 'menu_effect' ) ) {
		$effect = get_theme_mod( 'menu_effect', true );
		$menu_effect = ' wpbf-menu-effect-' . $effect;
	} else {
		$menu_effect = ' wpbf-menu-effect-none';
	}

	return $menu_effect;

}

// Menu Animation
function wpbf_menu_effect_animation() {

	if ( get_theme_mod( 'menu_effect_animation' ) ) {
		$animation = get_theme_mod( 'menu_effect_animation', true );
		$menu_effect_animation = ' wpbf-menu-animation-' . $animation;
	} else {
		$menu_effect_animation = ' wpbf-menu-animation-fade';
	}

	return $menu_effect_animation;

}

// Menu Alignment
function wpbf_menu_effect_alignment() {

	if ( get_theme_mod( 'menu_effect_alignment' ) ) {
		$alignment = get_theme_mod( 'menu_effect_alignment', true );
		$menu_effect_alignment = ' wpbf-menu-align-' . $alignment;
	} else {
		$menu_effect_alignment = ' wpbf-menu-align-left';
	}

	return $menu_effect_alignment;

}

// Sub Menu Animation
function wpbf_sub_menu_animation() {

	if ( get_theme_mod( 'sub_menu_animation' ) ) {
		$animation = get_theme_mod( 'sub_menu_animation', true );
		$sub_menu_animation = ' wpbf-sub-menu-animation-' . $animation;
	} else {
		$sub_menu_animation = ' wpbf-sub-menu-animation-fade';
	}

	return $sub_menu_animation;

}

// Navigation Attributes
function wpbf_navigation_attributes() {

	// vars
	$submenu_animation_duration = get_theme_mod( 'sub_menu_animation_duration' );

	// Construct Navigation Attributes
	$navigation_attributes = "";
	$navigation_attributes .= $submenu_animation_duration ? 'data-sub-menu-animation-duration="' . esc_attr( $submenu_animation_duration ) . '"' : 'data-sub-menu-animation-duration="250"';

	echo $navigation_attributes; // WPCS: XSS ok.

}