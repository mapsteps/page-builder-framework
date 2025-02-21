<?php

namespace Mapsteps\Wpbf\Customizer\HeaderBuilder;

class HeaderBuilderOutput {

	/**
	 * Associative array with row_key as key and columns as value.
	 *
	 * @var array
	 */
	private $desktop_columns = array();

	/**
	 * Associative array with row_key as key and columns as value.
	 *
	 * @var array
	 */
	private $mobile_columns = array();

	/**
	 * Associative array with sidebar widgets.
	 *
	 * @var array
	 */
	private $mobile_offcanvas_widgets = array();

	/**
	 * The mobile menu type. Accepts 'hamburger' or 'off-canvas'.
	 *
	 * @var string
	 */
	private $mobile_menu_type = '';


	/**
	 * Setup hooks to render header builder in front area.
	 */
	public function setup_hooks() {

		add_filter( 'wpbf_navigation_classes', [ $this, 'add_navigation_classes' ] );

		$saved_values = get_theme_mod( 'wpbf_header_builder', array() );

		$desktop_values      = isset( $saved_values['desktop'] ) && is_array( $saved_values['desktop'] ) ? $saved_values['desktop'] : array();
		$desktop_rows        = isset( $desktop_values['rows'] ) && is_array( $desktop_values['rows'] ) ? $desktop_values['rows'] : array();
		$active_desktop_rows = $this->get_active_rows( $desktop_rows );

		// Unhook functions which are supposed to be used when header builder is disabled.
		remove_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );
		remove_action( 'wpbf_navigation', 'wpbf_menu' );

		// Hook functions which are supposed to be used when header builder is enabled.
		add_action( 'wpbf_pre_header', [ $this, 'do_desktop_pre_header' ] );
		add_action( 'wpbf_navigation', [ $this, 'do_desktop_navigation' ] );

		if ( ! empty( $active_desktop_rows ) ) {
			foreach ( $active_desktop_rows as $desktop_row_key => $desktop_columns ) {
				if ( empty( $desktop_row_key ) || empty( $desktop_columns ) ) {
					continue;
				}

				$this->desktop_columns[ $desktop_row_key ] = $desktop_columns;
			}
		}

		$mobile_values      = isset( $saved_values['mobile'] ) && is_array( $saved_values['mobile'] ) ? $saved_values['mobile'] : array();
		$mobile_rows        = isset( $mobile_values['rows'] ) && is_array( $mobile_values['rows'] ) ? $mobile_values['rows'] : array();
		$active_mobile_rows = $this->get_active_rows( $mobile_rows );

		$this->mobile_offcanvas_widgets = isset( $mobile_values['sidebar'] ) && is_array( $mobile_values['sidebar'] ) ? $mobile_values['sidebar'] : array();

		// Unhook functions which are supposed to be used when header builder is disabled.
		remove_action( 'wpbf_mobile_navigation', 'wpbf_mobile_menu' );
		remove_action( 'wpbf_before_mobile_toggle', 'wpbf_search_menu_icon_mobile', 20 );

		// Hook functions which are supposed to be used when header builder is enabled.
		add_action( 'wpbf_mobile_navigation', [ $this, 'do_mobile_navigation' ] );

		if ( ! empty( $active_mobile_rows ) ) {
			foreach ( $active_mobile_rows as $mobile_row_key => $mobile_columns ) {
				if ( empty( $mobile_row_key ) || empty( $mobile_columns ) ) {
					continue;
				}

				$this->mobile_columns[ $mobile_row_key ] = $mobile_columns;
			}
		}

	}

	/**
	 * Append `use-header-builder` class to the navigation classes.
	 *
	 * @param string $classes The classes.
	 * @return string The updated classes.
	 */
	public function add_navigation_classes( $classes ) {

		return $classes . ' use-header-builder';

	}

	/**
	 * Get the active rows.
	 *
	 * @param array $rows The rows to check.
	 *
	 * @return array The active rows.
	 */
	private function get_active_rows( $rows = array() ) {

		if ( empty( $rows ) ) {
			return array();
		}

		$active_rows = [];

		foreach ( $rows as $row_key => $columns ) {
			if ( empty( $row_key ) || empty( $columns ) ) {
				continue;
			}

			foreach ( $columns as $column_key => $widget_keys ) {
				if ( empty( $widget_keys ) ) {
					continue;
				}

				if ( ! isset( $active_rows[ $row_key ] ) ) {
					$active_rows[ $row_key ] = [];
				}

				$active_rows[ $row_key ][ $column_key ] = $widget_keys;
			}
		}

		return $active_rows;

	}

	/**
	 * An action to render desktop pre-header.
	 *
	 * This action will be hooked to `wpbf_pre_header` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_desktop_pre_header() {

		$pre_header_columns = isset( $this->desktop_columns['desktop_row_1'] ) ? $this->desktop_columns['desktop_row_1'] : array();

		if ( empty( $pre_header_columns ) || ! is_array( $pre_header_columns ) ) {
			return;
		}
		?>

		<div id="pre-header" class="wpbf-pre-header">
			<?php
			do_action( 'wpbf_before_pre_header' );
			$this->render_desktop_row( 'desktop_row_1', $pre_header_columns );
			do_action( 'wpbf_after_pre_header' );
			?>
		</div>

		<?php
	}

	/**
	 * An action to render desktop navigation.
	 *
	 * This action will be hooked to `wpbf_navigation` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_desktop_navigation() {

		$row_2_columns = isset( $this->desktop_columns['desktop_row_2'] ) ? $this->desktop_columns['desktop_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_desktop_row( 'desktop_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->desktop_columns['desktop_row_3'] ) ? $this->desktop_columns['desktop_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_desktop_row( 'desktop_row_3', $row_3_columns );
		}

	}

	/**
	 * Render desktop header builder row.
	 *
	 * @param string $row_key The row key.
	 * @param array  $columns The row columns.
	 */
	private function render_desktop_row( $row_key, $columns ) {

		$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

		$dimensions   = [ 'large', 'medium', 'small' ];
		$visibilities = get_theme_mod( $row_id_prefix . 'visibility', null );
		$visibilities = is_array( $visibilities ) ? $visibilities : [ 'large', 'medium', 'small' ];

		// Lets only enable desktop for now.
		$visibilities = [ 'large' ];

		$hidden_dimensions = array_diff( $dimensions, $visibilities );

		$visibility_class = implode( ' ', array_map( function ( $dimension ) {
			return 'wpbf-hidden-' . esc_attr( $dimension );
		}, $hidden_dimensions ) );

		$container_class = 'wpbf-container wpbf-container-center';

		$row_class = ( 'desktop_row_1' === $row_key ? "wpbf-inner-pre-header $container_class " : '' ) . 'wpbf-header-row wpbf-header-row-' . esc_attr( $row_key ) . ' ' . esc_attr( $visibility_class );

		echo '<div class="' . esc_attr( $row_class ) . '">';

		if ( 'desktop_row_1' !== $row_key ) {
			echo '<div class="' . esc_attr( $container_class ) . '">';
		}

		echo '<div class="' . ( 'desktop_row_1' === $row_key ? 'wpbf-inner-pre-header-content ' : '' ) . 'wpbf-row-content wpbf-flex wpbf-items-center wpbf-content-center">';

		foreach ( $columns as $column_key => $widget_keys ) {
			$column_class    = 'wpbf-flex wpbf-header-column';
			$alignment_class = 'wpbf-content-center wpbf-items-center';
			$column_position = '';

			if ( false !== stripos( $column_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
				$column_position = 'left';
			} elseif ( false !== stripos( $column_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
				$column_position = 'right';
			}

			if (
			in_array( 'desktop_menu_1', $widget_keys, true )
			|| in_array( 'desktop_menu_2', $widget_keys, true )
			|| in_array( 'desktop_html_1', $widget_keys, true )
			|| in_array( 'desktop_html_2', $widget_keys, true )
			) {
				$column_class .= ' wpbf-column-grow';
			}

			echo '<div class="' . esc_attr( "$column_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				$this->render_widget( 'header_builder', $widget_key, $column_position );
			}

			echo '</div>';
		}

		echo '</div>';

		if ( 'desktop_row_1' !== $row_key ) {
			echo '</div>';
		}

		echo '</div>';

	}

	/**
	 * An action to render mobile navigation.
	 *
	 * This action will be hooked to `wpbf_navigation` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_mobile_navigation() {

		$reveal_as = get_theme_mod( 'wpbf_header_builder_mobile_sidebar_reveal_as' );

		$this->mobile_menu_type = 'off-canvas' !== $reveal_as ? 'dropdown' : $reveal_as;

		echo '<div class="wpbf-mobile-header-rows wpbf-hidden-large ' . ( 'off-canvas' === $this->mobile_menu_type ? 'wpbf-mobile-menu-off-canvas' : 'wpbf-mobile-menu-dropdown wpbf-mobile-menu-hamburger' ) . '">';

		$row_1_columns = isset( $this->mobile_columns['mobile_row_1'] ) ? $this->mobile_columns['mobile_row_1'] : array();

		if ( ! empty( $row_1_columns ) && is_array( $row_1_columns ) ) {
			$this->render_mobile_row( 'mobile_row_1', $row_1_columns );
		}

		$row_2_columns = isset( $this->mobile_columns['mobile_row_2'] ) ? $this->mobile_columns['mobile_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_mobile_row( 'mobile_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->mobile_columns['mobile_row_3'] ) ? $this->mobile_columns['mobile_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_mobile_row( 'mobile_row_3', $row_3_columns );
		}

		if ( ! empty( $this->mobile_offcanvas_widgets ) && is_array( $this->mobile_offcanvas_widgets ) ) {
			$this->render_mobile_menu( $this->mobile_offcanvas_widgets );
		}

		echo '</div>';

	}

	/**
	 * Render mobile header builder row.
	 *
	 * @param string $row_key The row key.
	 * @param array  $columns The row columns.
	 */
	private function render_mobile_row( $row_key, $columns ) {

		$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

		$dimensions   = [ 'large', 'medium', 'small' ];
		$visibilities = get_theme_mod( $row_id_prefix . 'visibility', null );
		$visibilities = is_array( $visibilities ) ? $visibilities : [ 'medium', 'small' ];

		// Lets only enable mobile for now.
		$visibilities = [ 'medium', 'small' ];

		$hidden_dimensions = array_diff( $dimensions, $visibilities );

		$visibility_class = implode( ' ', array_map( function ( $dimension ) {
			return 'wpbf-hidden-' . esc_attr( $dimension );
		}, $hidden_dimensions ) );

		$container_class = 'wpbf-container wpbf-container-center';

		$row_class = ( 'mobile_row_1' === $row_key ? "wpbf-inner-pre-header $container_class " : '' ) . 'wpbf-header-row wpbf-header-row-' . esc_attr( $row_key ) . ' ' . esc_attr( $visibility_class );

		echo '<div class="' . esc_attr( $row_class ) . '">';

		if ( 'mobile_row_1' !== $row_key ) {
			echo '<div class="' . esc_attr( $container_class ) . '">';
		}

		echo '<div class="' . ( 'mobile_row_1' === $row_key ? 'wpbf-inner-pre-header-content ' : '' ) . 'wpbf-row-content wpbf-flex wpbf-items-center wpbf-content-center">';

		foreach ( $columns as $column_key => $widget_keys ) {

			$column_class    = 'wpbf-flex wpbf-header-column';
			$alignment_class = 'wpbf-content-center wpbf-items-center';
			$column_position = '';

			if ( false !== stripos( $column_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
				$column_position = 'left';
			} elseif ( false !== stripos( $column_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
				$column_position = 'right';
			}

			if (
			in_array( 'mobile_menu_1', $widget_keys, true )
			|| in_array( 'mobile_menu_2', $widget_keys, true )
			|| in_array( 'mobile_html_1', $widget_keys, true )
			|| in_array( 'mobile_html_2', $widget_keys, true )
			|| in_array( 'mobile_button_1', $widget_keys, true )
			|| in_array( 'mobile_button_2', $widget_keys, true )
			|| in_array( 'mobile_search', $widget_keys, true )
			|| in_array( 'mobile_logo', $widget_keys, true )
			|| in_array( 'mobile_menu_trigger', $widget_keys, true )
			) {
				$column_class .= ' wpbf-column-grow';
			}

			echo '<div class="' . esc_attr( "$column_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {

				if ( empty( $widget_key ) ) {
					continue;
				}

				$this->render_widget( 'header_builder', $widget_key, $column_position );
			}

			echo '</div>';
		}

		echo '</div>';

		if ( 'mobile_row_1' !== $row_key ) {
			echo '</div>';
		}

		echo '</div>';

	}

	/**
	 * Render builder widget for frontend.
	 *
	 * @param string $builder_type The builder type. Accepts 'header_builder' or 'footer_builder'.
	 * @param string $widget_key The widget key.
	 * @param string $column_position The column position.
	 */
	private function render_widget( $builder_type, $widget_key, $column_position = '' ) {

		if ( empty( $widget_key ) ) {
			return;
		}

		$setting_group = "wpbf_$builder_type" . '_' . $widget_key;

		switch ( $widget_key ) {
			case 'logo':
			case 'desktop_logo':
			case 'mobile_logo':
				$this->render_logo_widget( $setting_group );
				break;
			case 'search':
			case 'desktop_search':
			case 'mobile_search':
				$this->render_search_widget( $setting_group );
				break;
			case 'button_1':
			case 'button_2':
			case 'desktop_button_1':
			case 'desktop_button_2':
			case 'mobile_button_1':
			case 'mobile_button_2':
				$this->render_button_widget( $setting_group );
				break;
			case 'menu_1':
			case 'menu_2':
			case 'desktop_menu_1':
			case 'desktop_menu_2':
			case 'mobile_menu_1':
			case 'mobile_menu_2':
				$this->render_menu_widget( $setting_group, $column_position );
				break;
			case 'html_1':
			case 'html_2':
			case 'desktop_html_1':
			case 'desktop_html_2':
			case 'mobile_html_1':
			case 'mobile_html_2':
				$this->render_html_widget( $setting_group );
				break;
			case 'mobile_menu_trigger':
				$this->render_mobile_menu_trigger_widget( $setting_group, $column_position );
				break;
		}

	}

	/**
	 * Render the builder logo widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_logo_widget( $setting_group ) {

		get_template_part( 'inc/template-parts/logo/logo' );

	}

	/**
	 * Render the builder search widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_search_widget( $setting_group ) {

		echo wpbf_search_menu_item( false, false );

	}

	/**
	 * Render the builder menu widget.
	 *
	 * @param string $setting_group The setting group key.
	 * @param string $column_position The column position. Accepts 'left', 'center', 'right', or empty string.
	 */
	private function render_mobile_menu_trigger_widget( $setting_group, $column_position = '' ) {

		$icon_variant = wpbf_customize_str_value( $setting_group . '_icon', 'variant-1' );
		$button_label = wpbf_customize_str_value( $setting_group . '_text' );
		$button_style = wpbf_customize_str_value( $setting_group . '_style', 'simple' );

		$menu_position_class = 'wpbf-menu-' . $column_position;
		$menu_variant_class  = 'wpbf-mobile-menu-' . $icon_variant;
		?>

		<div class="wpbf-menu-toggle-container">

			<?php do_action( 'wpbf_before_mobile_toggle' ); ?>

			<button
				id="wpbf-mobile-menu-toggle"
				class="wpbf-mobile-nav-item wpbf-mobile-menu-toggle <?php echo esc_attr( $menu_position_class ); ?> <?php echo esc_attr( $menu_variant_class ); ?> <?php echo esc_attr( $button_style ); ?>"
				aria-label="<?php _e( 'Mobile Site Navigation', 'page-builder-framework' ); ?>"
				aria-controls="navigation"
				aria-expanded="false"
				aria-haspopup="true"
			>
				<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'page-builder-framework' ); ?></span>

				<?php
				echo wp_kses(
					HeaderBuilderConfig::menuTriggerButtonSvg( $icon_variant ),
					array(
						'svg'  => array(
							'class'        => true,
							'width'        => true,
							'height'       => true,
							'viewbox'      => true,
							'fill'         => true,
							'xmlns'        => true,
							'data-variant' => true,
						),
						'rect' => array(
							'x'      => true,
							'y'      => true,
							'width'  => true,
							'height' => true,
							'rx'     => true,
						),
					)
				);

				if ( ! empty( $button_label ) ) {
					echo '<span class="menu-trigger-button-text">' . esc_html( $button_label ) . '</span>';
				}

				?>
			</button>

			<?php do_action( 'wpbf_after_mobile_toggle' ); ?>

		</div>

		<?php

	}

	/**
	 * Render the builder button widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_button_widget( $setting_group ) {

		// Extract the last character from setting group.
		$group_number = substr( $setting_group, -1 );

		$default_text = 'Button ' . ( is_numeric( $group_number ) ? $group_number : '1' );

		$link_text = get_theme_mod( $setting_group . '_text', $default_text );
		$link_url  = get_theme_mod( $setting_group . '_url', get_site_url() );

		if ( empty( $link_text ) && empty( $link_url ) ) {
			return;
		}

		$link_rel = '';

		$link_rel_values = get_theme_mod( $setting_group . '_rel', [] );
		$link_rel_values = ! is_array( $link_rel_values ) ? [] : $link_rel_values;

		if ( ! empty( $link_rel_values ) ) {
			$link_rel = implode( ' ', $link_rel_values );
		}

		$open_new_tab = get_theme_mod( $setting_group . '_new_tab', false );
		$button_size  = get_theme_mod( $setting_group . '_size', '' );
		$button_class = 'wpbf-button' . ( empty( $button_size ) ? '' : ' wpbf-button-' . $button_size ) . ' ' . $setting_group;
		?>

		<a
			href="<?php echo esc_url( wpbf_parse_template_tags( $link_url ) ); ?>"
			class="<?php echo esc_attr( $button_class ); ?>"
			<?php echo esc_attr( empty( $open_new_tab ) ? '' : 'target="_blank"' ); ?>
			<?php echo esc_attr( empty( $link_rel ) ? '' : ' rel="' . $link_rel . '"' ); ?>
		>
			<?php echo esc_html( $link_text ); ?>
		</a>

		<?php
	}

	/**
	 * Render header builder's menu widget.
	 *
	 * @param string $setting_group The setting group key.
	 * @param string $placement The placement position. Accepts 'left', 'center', 'right', 'mobile-menu', or empty string.
	 */
	private function render_menu_widget( $setting_group, $placement = '' ) {

		$menu_id = get_theme_mod( $setting_group . '_menu_id', '' );

		if ( empty( $menu_id ) ) {
			return;
		}

		if ( 'mobile-menu' !== $placement ) {
			$menu_position_class = 'wpbf-menu-' . $placement;

			echo '<nav class="navigation wpbf-clearfix ' . esc_attr( $menu_position_class ) . '" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="' . __( 'Site Navigation', 'page-builder-framework' ) . '">';
		}

		wp_nav_menu( array(
			'menu'        => $menu_id,
			'container'   => false,
			'menu_class'  => 'mobile-menu' === $placement
							? 'wpbf-mobile-menu'
							: 'wpbf-menu wpbf-sub-menu' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation() . wpbf_menu_hover_effect(),
			'depth'       => 4,
			'fallback_cb' => false,
		) );

		if ( 'mobile-menu' !== $placement ) {
			echo '</nav>';
		}
	}

	/**
	 * Render the builder html widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_html_widget( $setting_group ) {

		$content = wpbf_customize_str_value( $setting_group . '_content', '' );
		?>

		<div class="wpbf-html-widget">
			<?php echo wp_kses_post( $content ); ?>
		</div>

		<?php
	}

	/**
	 * Render header builder's mobile menu.
	 *
	 * Declare wp_nav_menu based on selected mobile menu variation.
	 *
	 * @param array $widget_keys The off-canvas widget keys.
	 */
	private function render_mobile_menu( $widget_keys ) {

		if ( empty( $widget_keys ) || ! is_array( $widget_keys ) ) {
			return;
		}

		if ( get_theme_mod( 'mobile_menu_overlay' ) ) {
			echo '<div class="wpbf-mobile-menu-overlay"></div>';
		}
		?>

		<div class="wpbf-mobile-menu-container">

			<?php do_action( 'wpbf_before_mobile_menu' ); ?>

			<nav id="mobile-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-labelledby="wpbf-mobile-menu-toggle">

				<?php
				do_action( 'wpbf_mobile_menu_open' );

				foreach ( $widget_keys as $widget_key ) {

					if ( empty( $widget_key ) ) {
						continue;
					}

					$this->render_widget( 'header_builder', $widget_key, 'mobile-menu' );
				}
				?>

				<?php do_action( 'wpbf_mobile_menu_close' ); ?>

			</nav>

			<?php do_action( 'wpbf_after_mobile_menu' ); ?>

			<?php if ( 'off-canvas' === $this->mobile_menu_type ) : ?>

				<?php if ( wpbf_svg_enabled() ) { ?>
					<span class="wpbf-close">
						<?php echo wpbf_svg( 'times' ); ?>
					</span>
				<?php } else { ?>
					<i class="wpbf-close wpbff wpbff-times" aria-hidden="true"></i>
				<?php } ?>

			<?php endif; ?>

		</div>
		
		<?php
	}

}
