<?php
/**
 * Blog customizer settings - General Fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - General */

// Meta sortable.
wpbf_customizer_field()
	->id( 'blog_sortable_meta' )
	->type( 'sortable' )
	->label( __( 'Meta Data', 'page-builder-framework' ) )
	->defaultValue( array(
		'author',
		'date',
	) )
	->choices( array(
		'author'   => __( 'Author', 'page-builder-framework' ),
		'date'     => __( 'Date', 'page-builder-framework' ),
		'comments' => __( 'Comments', 'page-builder-framework' ),
	) )
	->priority( 1 )
	->partialRefresh( [
		'metasortable' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_meta_separator' )
	->type( 'text' )
	->label( __( 'Separator', 'page-builder-framework' ) )
	->defaultValue( '|' )
	->priority( 1 )
	->partialRefresh( [
		'metaseparator' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Author avatar.
wpbf_customizer_field()
	->id( 'blog_author_avatar' )
	->type( 'toggle' )
	->label( __( 'Author Avatar', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'blog_sortable_meta',
			'operator' => 'in',
			'value'    => 'author',
		),
	] )
	->partialRefresh( [
		'metaavatar' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'meta_excerpt_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Excerpt length.
wpbf_customizer_field()
	->id( 'excerpt_lenght' )
	->type( 'number' )
	->label( __( 'Excerpt Length', 'page-builder-framework' ) )
	->description( __( 'By default the excerpt length is set to return 55 words.', 'page-builder-framework' ) )
	->defaultValue( 55 )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->priority( 1 )
	->partialRefresh( [
		'blogexcerpt' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Excerpt more.
wpbf_customizer_field()
	->id( 'excerpt_more' )
	->type( 'text' )
	->label( __( 'Excerpt Indicator', 'page-builder-framework' ) )
	->defaultValue( '[...]' )
	->priority( 1 )
	->partialRefresh( [
		'blogexcerptindicator' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_read_more_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Read more button.
wpbf_customizer_field()
	->id( 'blog_read_more_link' )
	->type( 'select' )
	->label( __( 'Read More Link', 'page-builder-framework' ) )
	->defaultValue( 'button' )
	->choices( [
		'text'    => __( 'Text', 'page-builder-framework' ),
		'button'  => __( 'Button', 'page-builder-framework' ),
		'primary' => __( 'Button (Primary)', 'page-builder-framework' ),
	] )
	->priority( 1 )
	->partialRefresh( [
		'blogreadmore' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Read more text.
wpbf_customizer_field()
	->id( 'blog_read_more_text' )
	->type( 'text' )
	->label( __( 'Read More Text', 'page-builder-framework' ) )
	->defaultValue( 'Read more' )
	->priority( 1 )
	->partialRefresh( [
		'blogreadmoretext' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_categories_title_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Categories title.
wpbf_customizer_field()
	->id( 'blog_categories_title' )
	->type( 'text' )
	->label( __( 'Categories Title', 'page-builder-framework' ) )
	->defaultValue( 'Filed under:' )
	->priority( 1 )
	->partialRefresh( [
		'catstitle' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .footer-categories',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-categories' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );
