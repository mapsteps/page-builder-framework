<?php
/**
 * Body Classes
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Global Sidebar function
function wpbf_global_sidebar_class() {

	$global_sidebar_position = get_theme_mod( 'sidebar_position' );

	switch ( $global_sidebar_position ) {
		case 'left':
			$sidebar_class = 'wpbf-sidebar-left';
			break;
		case 'none':
			$sidebar_class = 'wpbf-no-sidebar';
			break;
		default:
			$sidebar_class = is_page() && !is_page_template( 'page-sidebar.php' ) ? 'wpbf-no-sidebar' : 'wpbf-sidebar-right';
			break;
	}

	return $sidebar_class;

}

/* Body Classes */
add_filter( 'body_class', 'wpbf_body_classes' );
function wpbf_body_classes( $classes ) {

	$classes[] = 'wpbf';

	if( is_singular() ) {
		global $post;
		$classes[] = 'wpbf-' . $post->post_name;
	}
	
	/* Sidebar */
	$blog_sidebar_position = get_theme_mod( 'blog_sidebar_layout' );
	$category_sidebar_position = get_theme_mod( 'category_sidebar_layout' );
	$archive_sidebar_position = get_theme_mod( 'archive_sidebar_layout' );
	$single_sidebar_position_global = get_theme_mod( 'single_sidebar_layout' );
	
	// if singular, fetch sidebar position from post if provided. otherwise fall back to global sidebar position
	if( is_singular() ) {

		$single_sidebar_position = get_post_meta( $post->ID, 'wpbf_sidebar_position', true );

		if( $single_sidebar_position && $single_sidebar_position !== 'global' ) {

			if( $single_sidebar_position == 'right' ) {
				$classes[] = 'wpbf-sidebar-right';
			} elseif( $single_sidebar_position == 'left' ) {
				$classes[] = 'wpbf-sidebar-left';
			} elseif( $single_sidebar_position == 'none' ) {
				$classes[] = 'wpbf-no-sidebar';
			}

		} elseif( $single_sidebar_position_global && $single_sidebar_position_global !== 'global' ) {

			if( $single_sidebar_position_global == 'right' ) {
				$classes[] = 'wpbf-sidebar-right';
			} elseif( $single_sidebar_position_global == 'left' ) {
				$classes[] = 'wpbf-sidebar-left';
			} elseif( $single_sidebar_position_global == 'none' ) {
				$classes[] = 'wpbf-no-sidebar';
			}

		} else {

			$classes[] = wpbf_global_sidebar_class();

		}

	} elseif( is_home() ) {

		if ( !$blog_sidebar_position || $blog_sidebar_position == 'global' ) {

			$classes[] = wpbf_global_sidebar_class();

		} elseif( $blog_sidebar_position == 'right' ) {
			$classes[] = 'wpbf-sidebar-right';
		} elseif( $blog_sidebar_position == 'left' ) {
			$classes[] = 'wpbf-sidebar-left';
		} elseif( $blog_sidebar_position == 'none' ) {
			$classes[] = 'wpbf-no-sidebar';
		}

	} elseif( is_category() ) {

		if ( !$category_sidebar_position || $category_sidebar_position == 'global' ) {

			$classes[] = wpbf_global_sidebar_class();

		} elseif( $category_sidebar_position == 'right' ) {
			$classes[] = 'wpbf-sidebar-right';
		} elseif( $category_sidebar_position == 'left' ) {
			$classes[] = 'wpbf-sidebar-left';
		} elseif( $category_sidebar_position == 'none' ) {
			$classes[] = 'wpbf-no-sidebar';
		}

	} elseif ( is_archive() ) {

		if ( !$archive_sidebar_position || $archive_sidebar_position == 'global' ) {

			$classes[] = wpbf_global_sidebar_class();

		} elseif( $archive_sidebar_position == 'right' ) {
			$classes[] = 'wpbf-sidebar-right';
		} elseif( $archive_sidebar_position == 'left' ) {
			$classes[] = 'wpbf-sidebar-left';
		} elseif( $archive_sidebar_position == 'none' ) {
			$classes[] = 'wpbf-no-sidebar';
		}

	} else {

		$classes[] = wpbf_global_sidebar_class();

	}

	// Sub Menu
	$sub_menu_alignment = get_theme_mod( 'sub_menu_alignment' );

	if( $sub_menu_alignment == 'right' ) {
		$classes[] = 'wpbf-sub-menu-align-right';
	} elseif( $sub_menu_alignment == 'center' ) {
		$classes[] = 'wpbf-sub-menu-align-center';
	} else {
		$classes[] = 'wpbf-sub-menu-align-left';
	}

	return $classes;

}

/* Post Classes */
add_filter( 'post_class', 'wpbf_post_classes' );
function wpbf_post_classes( $classes ) {

	// add class to all posts
	$classes[] = 'wpbf-post';

	return $classes;

}