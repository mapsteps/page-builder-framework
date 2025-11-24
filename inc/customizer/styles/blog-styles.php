<?php
/**
 * Blog customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Blog Layouts */

$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	// Custom width.
	$custom_width = wpbf_customize_str_value( $archive . '_custom_width' );

	if ( ! $custom_width ) {
		continue;
	}

	if ( 'archive' === $archive ) {
		// All archives.

		wpbf_write_css( array(
			'selector' => '.blog #inner-content, .search #inner-content, .' . $archive . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	} elseif ( strpos( $archive, '-' ) ) {
		// Custom post type archives & taxonomies.

		$cpt = substr( $archive, 0, strpos( $archive, '-' ) );

		wpbf_write_css( array(
			'selector' => '.tax-' . $cpt . '_category #inner-content, .tax-' . $cpt . '_tag #inner-content, .post-type-archive-' . $cpt . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	} else {
		// Other archives.

		wpbf_write_css( array(
			'selector' => '.' . $archive . ' #inner-content',
			'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
		) );

	}

	$layout    = wpbf_customize_str_value( $archive . '_layout' );
	$style     = wpbf_customize_str_value( $archive . '_post_style', 'plain' );
	$stretched = wpbf_customize_bool_value( $archive . '_boxed_image_streched' );

	$content_alignment = wpbf_customize_str_value( $archive . '_post_content_alignment', 'left' );

	// General layout settings.
	if ( $content_alignment ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post',
			'props'    => array( 'text-align' => $content_alignment ),
		) );

	}

	$accent_color = wpbf_customize_str_value( $archive . '_post_accent_color' );

	if ( $accent_color ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more)',
			'props'    => array( 'color' => $accent_color ),
		) );

	}

	$accent_color_alt = wpbf_customize_str_value( $archive . '_post_accent_color_alt' );

	if ( $accent_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post a:not(.wpbf-read-more):hover',
			'props'    => array( 'color' => $accent_color_alt ),
		) );

	}

	$title_size = wpbf_customize_str_value( $archive . '_post_title_size' );

	if ( $title_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post .entry-title',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $title_size ) ),
		) );

	}

	$font_size = wpbf_customize_str_value( $archive . '_post_font_size' );

	if ( $font_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post .entry-summary',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
		) );

	}

	$space_between = wpbf_customize_str_value( $archive . '_post_space_between' );
	$space_between = '20' === $space_between || '20px' === $space_between ? '' : $space_between;

	if ( 'plain' === $style && $space_between ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-plain',
			'props'    => array(
				'margin-bottom'  => wpbf_maybe_append_suffix( $space_between ),
				'padding-bottom' => wpbf_maybe_append_suffix( $space_between ),
			),
		) );

	}

	// Boxed.
	if ( 'boxed' === $style ) {

		$background_color = wpbf_customize_str_value( $archive . '_post_background_color' );
		$background_color = '#f5f5f7' === $background_color ? '' : $background_color;

		if ( $background_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array( 'background-color' => $background_color ),
			) );

		}

		if ( $space_between ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array( 'margin-bottom' => wpbf_maybe_append_suffix( $space_between ) ),
			) );
		}

		$boxed_padding = wpbf_customize_array_value( $archive . '_boxed_padding' );

		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_desktop ? wpbf_maybe_append_suffix( $boxed_padding_top_desktop ) : null,
					'padding-right'  => $boxed_padding_right_desktop ? wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					'padding-bottom' => $boxed_padding_bottom_desktop ? wpbf_maybe_append_suffix( $boxed_padding_bottom_desktop ) : null,
					'padding-left'   => $boxed_padding_left_desktop ? wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
				),
			) );

			if ( $stretched && 'beside' !== $layout ) {

				wpbf_write_css( array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
						'margin-right' => $boxed_padding_right_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					),
				) );

				if ( $boxed_padding_top_desktop ) {

					wpbf_write_css( array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
						),
					) );

				}

			}
		}

		$boxed_padding_top_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
					'padding-right'  => $boxed_padding_right_tablet ? wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					'padding-bottom' => $boxed_padding_bottom_tablet ? wpbf_maybe_append_suffix( $boxed_padding_bottom_tablet ) : null,
					'padding-left'   => $boxed_padding_left_tablet ? wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched && 'beside' !== $layout ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
						'margin-right' => $boxed_padding_right_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					),
				);

				if ( $boxed_padding_top_tablet ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_tablet ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_tablet ),
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}

		$boxed_padding_top_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
					'padding-right'  => $boxed_padding_right_mobile ? wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					'padding-bottom' => $boxed_padding_bottom_mobile ? wpbf_maybe_append_suffix( $boxed_padding_bottom_mobile ) : null,
					'padding-left'   => $boxed_padding_left_mobile ? wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched && 'beside' !== $layout ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $archive . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
						'margin-right' => $boxed_padding_right_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					),
				);

				if ( $boxed_padding_top_mobile ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $archive . '-content  .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_mobile ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_mobile ),
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}
	}

	// Beside.
	if ( 'beside' === $layout ) {

		$image_width = wpbf_customize_str_value( $archive . '_post_image_width' );
		$image_width = '40' === $image_width || '40px' === $image_width ? '' : $image_width;

		if ( $image_width ) {

			wpbf_write_css( array(
				'media_query' => '@media (min-width: ' . esc_attr( $breakpoint_desktop_int + 1 ) . 'px)',
				'blocks'      => array(
					array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-2-5',
						'props'    => array( 'width' => wpbf_maybe_append_suffix( $image_width, '%' ) ),
					),
					array(
						'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-large-3-5',
						'props'    => array( 'width' => wpbf_maybe_append_suffix( ( 100 - $image_width ), '%' ) ),
					),
				),
			) );

		}

		$image_alignment = wpbf_customize_str_value( $archive . '_post_image_alignment', 'left' );

		if ( $image_alignment ) {

			$image_alignment_direction = 'left' === $image_alignment ? 'row' : ( 'right' === $image_alignment ? 'row-reverse' : null );

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $archive . '-content .wpbf-blog-layout-beside .wpbf-grid',
				'props'    => array(
					'flex-direction' => $image_alignment_direction,
				),
			) );

		}
	}
}

/* Single */

$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$custom_width = wpbf_customize_str_value( $single . '_custom_width' );

	// All post types.
	if ( 'single' === $single && $custom_width ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.single #inner-content',
					'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
				),
				// Change the max-width of the cover block contents.
				array(
					'selector' => '.single .wp-block-cover .wp-block-cover__inner-container, .single .wp-block-group .wp-block-group__inner-container',
					'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $custom_width ) ),
				),
			),
		) );

		// Individual post types.
	} elseif ( 'single' !== $single && $custom_width ) {

		wpbf_write_css( array(
			'blocks' => array(
				array(
					'selector' => '.single-' . $single . ' #inner-content',
					'props'    => array(
						'max-width' => wpbf_maybe_append_suffix( $custom_width ),
					),
				),
				// Change the max-width of the cover block contents.
				array(
					'selector' => '.single-' . $single . ' .wp-block-cover .wp-block-cover__inner-container, .single-' . $single . ' .wp-block-group .wp-block-group__inner-container',
					'props'    => array(
						'max-width' => wpbf_maybe_append_suffix( $custom_width ),
					),
				),
			),
		) );

	}

	// General Layout Settings.
	/**
	$content_alignment = wpbf_customize_str_value( $single . '_post_content_alignment', 'left' );

	if ( $content_alignment ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post',
			'props'    => array( 'text-align' => $content_alignment ),
		) );

	}
	*/

	$title_size = wpbf_customize_str_value( $single . '_post_title_size' );

	if ( $title_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post .entry-title',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $title_size ) ),
		) );

	}

	$font_size = wpbf_customize_str_value( $single . '_post_font_size' );

	if ( $font_size ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-' . $single . '-content .wpbf-post .entry-content',
			'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $font_size ) ),
		) );

	}

	$style = wpbf_customize_str_value( $single . '_post_style' );

	// Boxed.
	if ( 'boxed' === $style ) {

		$background_color = wpbf_customize_str_value( $single . '_post_background_color' );
		$background_color = '#f5f5f7' === $background_color ? '' : $background_color;

		if ( $background_color ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'background-color' => $background_color,
				),
			) );

		}

		$stretched     = wpbf_customize_bool_value( $single . '_boxed_image_stretched' );
		$boxed_padding = wpbf_customize_array_value( $single . '_boxed_padding' );

		$boxed_padding_top_desktop    = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_top' );
		$boxed_padding_right_desktop  = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_right' );
		$boxed_padding_bottom_desktop = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_bottom' );
		$boxed_padding_left_desktop   = wpbf_get_theme_mod_value( $boxed_padding, 'desktop_left' );

		if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop ) {

			wpbf_write_css( array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_desktop ? wpbf_maybe_append_suffix( $boxed_padding_top_desktop ) : null,
					'padding-right'  => $boxed_padding_right_desktop ? wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					'padding-bottom' => $boxed_padding_bottom_desktop ? wpbf_maybe_append_suffix( $boxed_padding_bottom_desktop ) : null,
					'padding-left'   => $boxed_padding_left_desktop ? wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
				),
			) );

			if ( $stretched ) {

				wpbf_write_css( array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_desktop ) : null,
						'margin-right' => $boxed_padding_right_desktop ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_desktop ) : null,
					),
				) );

				if ( $boxed_padding_top_desktop ) {

					wpbf_write_css( array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => '-' . wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
							'margin-bottom' => wpbf_maybe_append_suffix( $boxed_padding_top_desktop ),
						),
					) );

				}

			}
		}

		$boxed_padding_top_tablet    = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_top' );
		$boxed_padding_right_tablet  = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_right' );
		$boxed_padding_bottom_tablet = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_bottom' );
		$boxed_padding_left_tablet   = wpbf_get_theme_mod_value( $boxed_padding, 'tablet_left' );

		if ( $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
					'padding-right'  => $boxed_padding_right_tablet ? wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					'padding-bottom' => $boxed_padding_bottom_tablet ? wpbf_maybe_append_suffix( $boxed_padding_bottom_tablet ) : null,
					'padding-left'   => $boxed_padding_left_tablet ? wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_tablet ) : null,
						'margin-right' => $boxed_padding_right_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_tablet ) : null,
					),
				);

				if ( $boxed_padding_top_tablet ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => $boxed_padding_top_tablet ? '-' . wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
							'margin-bottom' => $boxed_padding_top_tablet ? wpbf_maybe_append_suffix( $boxed_padding_top_tablet ) : null,
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}

		$boxed_padding_top_mobile    = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_top' );
		$boxed_padding_right_mobile  = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_right' );
		$boxed_padding_bottom_mobile = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_bottom' );
		$boxed_padding_left_mobile   = wpbf_get_theme_mod_value( $boxed_padding, 'mobile_left' );

		if ( $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

			$padding_block = array(
				'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed .wpbf-article-wrapper, .wpbf-' . $single . '-content .wpbf-post-style-boxed #respond',
				'props'    => array(
					'padding-top'    => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
					'padding-right'  => $boxed_padding_right_mobile ? wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					'padding-bottom' => $boxed_padding_bottom_mobile ? wpbf_maybe_append_suffix( $boxed_padding_bottom_mobile ) : null,
					'padding-left'   => $boxed_padding_left_mobile ? wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
				),
			);

			$margin_block_1 = array();
			$margin_block_2 = array();

			if ( $stretched ) {

				$margin_block_1 = array(
					'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
					'props'    => array(
						'margin-left'  => $boxed_padding_left_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_left_mobile ) : null,
						'margin-right' => $boxed_padding_right_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_right_mobile ) : null,
					),
				);

				if ( $boxed_padding_top_mobile ) {

					$margin_block_2 = array(
						'selector' => '.wpbf-' . $single . '-content .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
						'props'    => array(
							'margin-top'    => $boxed_padding_top_mobile ? '-' . wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
							'margin-bottom' => $boxed_padding_top_mobile ? wpbf_maybe_append_suffix( $boxed_padding_top_mobile ) : null,
						),
					);

				}

			}

			wpbf_write_css( array(
				'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
				'blocks'      => array( $padding_block, $margin_block_1, $margin_block_2 ),
			) );

		}
	}
}
