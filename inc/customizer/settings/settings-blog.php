<?php
/**
 * Blog customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Panel & Sections.
require_once __DIR__ . '/blog/blog-panel-sections.php';

// General Fields.
require_once __DIR__ . '/blog/blog-general-fields.php';

// Pagination Fields.
require_once __DIR__ . '/blog/blog-pagination-fields.php';

// Archive Layout Fields.
require_once __DIR__ . '/blog/blog-archive-layout-fields.php';

// Single/Post Layout Fields.
require_once __DIR__ . '/blog/blog-single-layout-fields.php';
