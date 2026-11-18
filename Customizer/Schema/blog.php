<?php
/**
 * Option schema: Blog: general blog settings, then every archive ({archive}) and post type ({single}).
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'blog_sortable_meta' => array(
		'type'    => 'sortable',
		'default' => array( 'author', 'date' ),
	),
	'blog_meta_separator' => array(
		'type'    => 'text',
		'default' => '|',
	),
	'blog_author_avatar' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'excerpt_lenght' => array(
		'type'    => 'number',
		'default' => 55,
	),
	'excerpt_more' => array(
		'type'    => 'text',
		'default' => '[...]',
	),
	'blog_read_more_link' => array(
		'type'    => 'select',
		'default' => 'button',
	),
	'blog_read_more_text' => array(
		'type'    => 'text',
		'default' => 'Read more',
	),
	'blog_categories_title' => array(
		'type'    => 'text',
		'default' => 'Filed under:',
	),
	'blog_pagination_background_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_background_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_background_color_active' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_font_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_font_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_font_color_active' => array(
		'type'    => 'color',
		'default' => '',
	),
	'blog_pagination_border_radius' => array(
		'type'    => 'slider',
		'default' => 0,
	),
	'blog_pagination_font_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
	'{archive}_custom_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'{archive}_headline' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'{archive}_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'global',
	),
	'{archive}_sortable_header' => array(
		'type'    => 'sortable',
		'default' => array( 'title', 'meta', 'featured' ),
	),
	'{archive}_sortable_content' => array(
		'type'    => 'sortable',
		'default' => array( 'excerpt' ),
	),
	'{archive}_sortable_footer' => array(
		'type'    => 'sortable',
		'default' => array( 'readmore', 'categories' ),
	),
	'{archive}_layout' => array(
		'type'    => 'select',
		'default' => 'default',
	),
	'{archive}_post_style' => array(
		'type'    => 'select',
		'default' => 'plain',
	),
	'{archive}_boxed_image_streched' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'{archive}_boxed_padding' => array(
		'type'    => 'responsive-padding',
		'default' => array(),
		'json'    => true,
	),
	'{archive}_post_space_between' => array(
		'type'    => 'slider',
		'default' => 20,
	),
	'{archive}_post_content_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'{archive}_post_background_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'{archive}_post_accent_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'{archive}_post_accent_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'{archive}_post_title_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
	'{archive}_post_font_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
	'{archive}_post_image_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'{archive}_post_image_width' => array(
		'type'    => 'slider',
		'default' => 40,
	),
	'{single}_custom_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'{single}_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'global',
	),
	'{single}_sortable_header' => array(
		'type'    => 'sortable',
		'default' => array( 'title', 'meta', 'featured' ),
	),
	'{single}_sortable_footer' => array(
		'type'    => 'sortable',
		'default' => array( 'categories' ),
	),
	'{single}_disable_comments' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'{single}_post_nav' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'{single}_post_style' => array(
		'type'    => 'select',
		'default' => 'plain',
	),
	'{single}_boxed_image_stretched' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'{single}_boxed_padding' => array(
		'type'    => 'responsive-padding',
		'default' => array(),
		'json'    => true,
	),
	'{single}_post_background_color' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'{single}_post_title_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
	'{single}_post_font_size' => array(
		'type'    => 'input-slider',
		'default' => '',
	),
);
