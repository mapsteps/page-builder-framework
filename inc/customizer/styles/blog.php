<?php
/**
 * Customizer CSS: Blog (pagination, archives, posts).
 *
 * Plain PHP, included from styles.php with wpbf_css_area( 'blog' ). How to write it: see styles/general.php.
 * Archives and post types come from the wpbf_archives / wpbf_singles filters (Premium adds its blog and post layouts);
 * Premium's own blog layout CSS (grid ...) is Premium's.
 *
 * Each block has 'when' => its own option (padding: its own side, 'option.key'): the old code skipped values like 0 or
 * '0' (no control saves them, an import can), so they stay skipped.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Pagination.
wpbf_css( '.pagination .page-numbers', array( 'border-radius' => '{blog_pagination_border_radius}px' ), array( 'when' => 'blog_pagination_border_radius' ) );
wpbf_css( '.pagination .page-numbers', array( 'font-size' => '{blog_pagination_font_size|px}' ), array( 'when' => 'blog_pagination_font_size' ) );
wpbf_css( '.pagination .page-numbers', array( 'background' => '{blog_pagination_background_color}' ), array( 'when' => 'blog_pagination_background_color' ) );
wpbf_css( '.pagination .page-numbers', array( 'color' => '{blog_pagination_font_color}' ), array( 'when' => 'blog_pagination_font_color' ) );
wpbf_css( '.pagination .page-numbers:hover', array( 'background' => '{blog_pagination_background_color_alt}' ), array( 'when' => 'blog_pagination_background_color_alt' ) );
wpbf_css( '.pagination .page-numbers:hover', array( 'color' => '{blog_pagination_font_color_alt}' ), array( 'when' => 'blog_pagination_font_color_alt' ) );
wpbf_css( '.pagination .page-numbers.current', array( 'background' => '{blog_pagination_background_color_active}!important' ), array( 'when' => 'blog_pagination_background_color_active' ) );
wpbf_css( '.pagination .page-numbers.current', array( 'color' => '{blog_pagination_font_color_active}' ), array( 'when' => 'blog_pagination_font_color_active' ) );

/*
 * Boxed padding per device. Each side prints on its own when it's set. With stretched images, the image reaches out
 * over the left/right padding and, as the first part of the header, over the top padding.
 *
 * @param string $option    The padding option (JSON).
 * @param string $box       The boxed element's selector.
 * @param string $content   The content wrapper's selector.
 * @param bool   $stretched Whether images are stretched.
 */
$wpbf_boxed_padding = function ( $option, $box, $content, $stretched ) {

	$devices = array(
		'desktop' => '',
		'tablet'  => 'max-desktop',
		'mobile'  => 'max-mobile',
	);

	foreach ( $devices as $device => $media ) {

		foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side ) {
			$part = $option . '.' . $device . '_' . $side;

			wpbf_css(
				$box,
				array( 'padding-' . $side => '{' . $part . '}px' ),
				array(
					'media' => $media,
					'when'  => $part,
				)
			);
		}

		if ( ! $stretched ) {
			continue;
		}

		foreach ( array( 'left', 'right' ) as $side ) {
			$part = $option . '.' . $device . '_' . $side;

			wpbf_css(
				$content . ' .wpbf-post-style-boxed.stretched .wpbf-post-image-wrapper',
				array( 'margin-' . $side => '-{' . $part . '}px' ),
				array(
					'media' => $media,
					'when'  => $part,
				)
			);
		}

		$part = $option . '.' . $device . '_top';

		wpbf_css(
			$content . ' .wpbf-post-style-boxed.stretched .article-header > .wpbf-post-image-wrapper:first-child',
			array(
				'margin-top'    => '-{' . $part . '}px',
				'margin-bottom' => '{' . $part . '}px',
			),
			array(
				'media' => $media,
				'when'  => $part,
			)
		);

	}

};

// Archives.
foreach ( apply_filters( 'wpbf_archives', array( 'archive' ) ) as $wpbf_archive ) {

	$wpbf_content = '.wpbf-' . $wpbf_archive . '-content';

	// Custom width: all archives; a post type's archive and taxonomies (Premium's "<post type>-archive"); other archives.
	if ( 'archive' === $wpbf_archive ) {
		$wpbf_width_selector = '.blog #inner-content,.search #inner-content,.archive #inner-content';
	} elseif ( strpos( $wpbf_archive, '-' ) ) {
		$wpbf_cpt            = substr( $wpbf_archive, 0, strpos( $wpbf_archive, '-' ) );
		$wpbf_width_selector = '.tax-' . $wpbf_cpt . '_category #inner-content,.tax-' . $wpbf_cpt . '_tag #inner-content,.post-type-archive-' . $wpbf_cpt . ' #inner-content';
	} else {
		$wpbf_width_selector = '.' . $wpbf_archive . ' #inner-content';
	}

	wpbf_css( $wpbf_width_selector, array( 'max-width' => '{' . $wpbf_archive . '_custom_width}' ), array( 'when' => $wpbf_archive . '_custom_width' ) );

	$wpbf_layout = wpbf_mod( $wpbf_archive . '_layout' );
	$wpbf_style  = wpbf_mod( $wpbf_archive . '_post_style' );

	// Printed at the default (left) too, as before.
	wpbf_css(
		$wpbf_content . ' .wpbf-post',
		array( 'text-align' => '{' . $wpbf_archive . '_post_content_alignment}' ),
		array(
			'always' => true,
			'when'   => $wpbf_archive . '_post_content_alignment',
		)
	);

	wpbf_css( $wpbf_content . ' .wpbf-post a:not(.wpbf-read-more)', array( 'color' => '{' . $wpbf_archive . '_post_accent_color}' ), array( 'when' => $wpbf_archive . '_post_accent_color' ) );
	wpbf_css( $wpbf_content . ' .wpbf-post a:not(.wpbf-read-more):hover', array( 'color' => '{' . $wpbf_archive . '_post_accent_color_alt}' ), array( 'when' => $wpbf_archive . '_post_accent_color_alt' ) );
	wpbf_css( $wpbf_content . ' .wpbf-post .entry-title', array( 'font-size' => '{' . $wpbf_archive . '_post_title_size|px}' ), array( 'when' => $wpbf_archive . '_post_title_size' ) );
	wpbf_css( $wpbf_content . ' .wpbf-post .entry-summary', array( 'font-size' => '{' . $wpbf_archive . '_post_font_size|px}' ), array( 'when' => $wpbf_archive . '_post_font_size' ) );

	if ( 'plain' === $wpbf_style ) {
		wpbf_css(
			$wpbf_content . ' .wpbf-post-style-plain',
			array(
				'margin-bottom'  => '{' . $wpbf_archive . '_post_space_between}px',
				'padding-bottom' => '{' . $wpbf_archive . '_post_space_between}px',
			),
			array( 'when' => $wpbf_archive . '_post_space_between' )
		);
	}

	if ( 'boxed' === $wpbf_style ) {
		wpbf_css( $wpbf_content . ' .wpbf-post-style-boxed', array( 'background-color' => '{' . $wpbf_archive . '_post_background_color}' ), array( 'when' => $wpbf_archive . '_post_background_color' ) );
		wpbf_css( $wpbf_content . ' .wpbf-post-style-boxed', array( 'margin-bottom' => '{' . $wpbf_archive . '_post_space_between}px' ), array( 'when' => $wpbf_archive . '_post_space_between' ) );

		$wpbf_boxed_padding(
			$wpbf_archive . '_boxed_padding',
			$wpbf_content . ' .wpbf-post-style-boxed',
			$wpbf_content,
			wpbf_mod( $wpbf_archive . '_boxed_image_streched' ) && 'beside' !== $wpbf_layout
		);
	}

	if ( 'beside' === $wpbf_layout ) {
		wpbf_css(
			$wpbf_content . ' .wpbf-blog-layout-beside .wpbf-large-2-5',
			array( 'width' => '{' . $wpbf_archive . '_post_image_width}%' ),
			array(
				'media' => 'min-desktop',
				'when'  => $wpbf_archive . '_post_image_width',
			)
		);

		wpbf_css(
			$wpbf_content . ' .wpbf-blog-layout-beside .wpbf-large-3-5',
			array( 'width' => 'calc(100% - {' . $wpbf_archive . '_post_image_width}%)' ),
			array(
				'media' => 'min-desktop',
				'when'  => $wpbf_archive . '_post_image_width',
			)
		);

		// Image left or right (printed at the default too; other values print an empty block, as before).
		$wpbf_image_alignment = wpbf_mod( $wpbf_archive . '_post_image_alignment' );

		if ( $wpbf_image_alignment ) {
			$wpbf_directions = array(
				'left'  => 'flex-direction:row;',
				'right' => 'flex-direction:row-reverse;',
			);

			echo esc_attr( $wpbf_content ) . ' .wpbf-blog-layout-beside .wpbf-grid{' . ( isset( $wpbf_directions[ $wpbf_image_alignment ] ) ? $wpbf_directions[ $wpbf_image_alignment ] : '' ) . '}'; // phpcs:ignore WordPress.Security.EscapeOutput -- Fixed text.
		}
	}
}

// Posts (and Premium's post types).
foreach ( apply_filters( 'wpbf_singles', array( 'single' ) ) as $wpbf_single ) {

	$wpbf_content = '.wpbf-' . $wpbf_single . '-content';
	$wpbf_page    = 'single' === $wpbf_single ? '.single' : '.single-' . $wpbf_single;

	wpbf_css( $wpbf_page . ' #inner-content', array( 'max-width' => '{' . $wpbf_single . '_custom_width}' ), array( 'when' => $wpbf_single . '_custom_width' ) );

	// The content width of cover and group blocks follows.
	wpbf_css(
		$wpbf_page . ' .wp-block-cover .wp-block-cover__inner-container, ' . $wpbf_page . ' .wp-block-group .wp-block-group__inner-container',
		array( 'max-width' => '{' . $wpbf_single . '_custom_width}' ),
		array( 'when' => $wpbf_single . '_custom_width' )
	);

	wpbf_css( $wpbf_content . ' .wpbf-post .entry-title', array( 'font-size' => '{' . $wpbf_single . '_post_title_size|px}' ), array( 'when' => $wpbf_single . '_post_title_size' ) );
	wpbf_css( $wpbf_content . ' .wpbf-post .entry-content', array( 'font-size' => '{' . $wpbf_single . '_post_font_size|px}' ), array( 'when' => $wpbf_single . '_post_font_size' ) );

	if ( 'boxed' === wpbf_mod( $wpbf_single . '_post_style' ) ) {
		$wpbf_box = $wpbf_content . ' .wpbf-post-style-boxed .wpbf-article-wrapper, ' . $wpbf_content . ' .wpbf-post-style-boxed #respond';

		wpbf_css( $wpbf_box, array( 'background' => '{' . $wpbf_single . '_post_background_color}' ), array( 'when' => $wpbf_single . '_post_background_color' ) );

		$wpbf_boxed_padding( $wpbf_single . '_boxed_padding', $wpbf_box, $wpbf_content, wpbf_mod( $wpbf_single . '_boxed_image_stretched' ) );
	}
}
