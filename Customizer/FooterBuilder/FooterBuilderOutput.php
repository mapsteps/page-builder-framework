<?php

namespace Mapsteps\Wpbf\Customizer\FooterBuilder;

class FooterBuilderOutput {

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
	 * Setup hooks to render footer builder in front area.
	 */
	public function setup_hooks() {

		add_filter( 'wpbf_footer_classes', [ $this, 'add_footer_classes' ] );

		$saved_values = get_theme_mod( 'wpbf_footer_builder', array() );

		$desktop_values      = isset( $saved_values['desktop'] ) && is_array( $saved_values['desktop'] ) ? $saved_values['desktop'] : array();
		$desktop_rows        = isset( $desktop_values['rows'] ) && is_array( $desktop_values['rows'] ) ? $desktop_values['rows'] : array();
		$active_desktop_rows = $this->get_active_rows( $desktop_rows );

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

		if ( ! empty( $active_mobile_rows ) ) {
			foreach ( $active_mobile_rows as $mobile_row_key => $mobile_columns ) {
				if ( empty( $mobile_row_key ) || empty( $mobile_columns ) ) {
					continue;
				}

				$this->mobile_columns[ $mobile_row_key ] = $mobile_columns;
			}
		}

		// Unhook default footer functions.
		remove_action( 'wpbf_footer', 'wpbf_do_footer' );

		// Hook footer builder template.
		add_action( 'wpbf_footer', [ $this, 'do_footer_template' ] );

		// Hook footer builder content.
		add_action( 'wpbf_footer_builder_content', [ $this, 'do_footer_content' ] );

	}

	/**
	 * Append `use-footer-builder` class to the footer classes.
	 *
	 * @param string $classes The classes.
	 * @return string The updated classes.
	 */
	public function add_footer_classes( $classes ) {

		return $classes . ' use-footer-builder';

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
	 * An action to render footer builder template.
	 *
	 * This action will be hooked to `wpbf_footer` action hook.
	 * The template contains the <footer id="footer"> wrapper which is required for partialRefresh.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_footer_template() {

		get_template_part( 'inc/template-parts/footer-builder' );

	}

	/**
	 * An action to render footer builder content.
	 *
	 * This action will be hooked to `wpbf_footer_builder_content` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_footer_content() {

		echo '<div class="wpbf-footer-builder">';

		// Render desktop footer.
		$this->render_desktop_footer();

		// Render mobile footer.
		$this->render_mobile_footer();

		echo '</div>';

	}

	/**
	 * Render desktop footer.
	 */
	private function render_desktop_footer() {

		echo '<div class="wpbf-footer-desktop wpbf-hidden-medium wpbf-hidden-small">';

		$row_1_columns = isset( $this->desktop_columns['desktop_row_1'] ) ? $this->desktop_columns['desktop_row_1'] : array();

		if ( ! empty( $row_1_columns ) && is_array( $row_1_columns ) ) {
			$this->render_row( 'desktop_row_1', $row_1_columns );
		}

		$row_2_columns = isset( $this->desktop_columns['desktop_row_2'] ) ? $this->desktop_columns['desktop_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_row( 'desktop_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->desktop_columns['desktop_row_3'] ) ? $this->desktop_columns['desktop_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_row( 'desktop_row_3', $row_3_columns );
		}

		echo '</div>';

	}

	/**
	 * Render mobile footer.
	 */
	private function render_mobile_footer() {

		echo '<div class="wpbf-footer-mobile wpbf-hidden-large">';

		$row_1_columns = isset( $this->mobile_columns['mobile_row_1'] ) ? $this->mobile_columns['mobile_row_1'] : array();

		if ( ! empty( $row_1_columns ) && is_array( $row_1_columns ) ) {
			$this->render_row( 'mobile_row_1', $row_1_columns );
		}

		$row_2_columns = isset( $this->mobile_columns['mobile_row_2'] ) ? $this->mobile_columns['mobile_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_row( 'mobile_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->mobile_columns['mobile_row_3'] ) ? $this->mobile_columns['mobile_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_row( 'mobile_row_3', $row_3_columns );
		}

		echo '</div>';

	}

	/**
	 * Render footer builder row.
	 *
	 * @param string $row_key The row key.
	 * @param array  $columns The row columns.
	 */
	private function render_row( $row_key, $columns ) {

		$container_class = 'wpbf-container wpbf-container-center';

		$row_class = 'wpbf-footer-row wpbf-footer-row-' . esc_attr( $row_key );

		echo '<div class="' . esc_attr( $row_class ) . '">';
		echo '<div class="' . esc_attr( $container_class ) . '">';

		$row_alignment_class = 'wpbf-content-space-between';

		echo '<div class="wpbf-row-content wpbf-flex wpbf-items-center ' . esc_attr( $row_alignment_class ) . '">';

		// Define zones: left (columns 1), center (column 2), right (columns 3).
		$zones = array(
			'left'   => array( 'column_1_start', 'column_1_end' ),
			'center' => array( 'column_2' ),
			'right'  => array( 'column_3_start', 'column_3_end' ),
		);

		foreach ( $zones as $zone_key => $zone_columns ) {
			$zone_class = 'wpbf-footer-zone wpbf-footer-zone-' . $zone_key;

			if ( 'center' !== $zone_key ) {
				$zone_class .= ' wpbf-zone-grow';
			}

			echo '<div class="' . esc_attr( $zone_class ) . '">';

			foreach ( $zone_columns as $column_key ) {
				$widget_keys = isset( $columns[ $column_key ] ) ? $columns[ $column_key ] : array();

				$column_class    = 'wpbf-flex wpbf-footer-column';
				$alignment_class = 'wpbf-content-center wpbf-items-center';
				$column_position = '';

				if ( 'column_1_start' === $column_key ) {
					$alignment_class = 'wpbf-content-start';
					$column_position = 'left';
				} elseif ( 'column_1_end' === $column_key ) {
					$alignment_class = 'wpbf-content-end';
					$column_position = 'left';
				} elseif ( 'column_2' === $column_key ) {
					$alignment_class = 'wpbf-content-center';
					$column_position = 'center';
				} elseif ( 'column_3_start' === $column_key ) {
					$alignment_class = 'wpbf-content-start';
					$column_position = 'right';
				} elseif ( 'column_3_end' === $column_key ) {
					$alignment_class = 'wpbf-content-end';
					$column_position = 'right';
				}

				if ( empty( $widget_keys ) ) {
					$column_class .= ' wpbf-column-empty';
				}

				echo '<div class="' . esc_attr( "$column_class $alignment_class" ) . '">';

				if ( ! empty( $widget_keys ) ) {
					foreach ( $widget_keys as $widget_key ) {
						if ( empty( $widget_key ) ) {
							continue;
						}

						$this->render_widget( $widget_key, $column_position );
					}
				}

				echo '</div>';
			}

			echo '</div>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';

	}

	/**
	 * Render builder widget for frontend.
	 *
	 * @param string $widget_key The widget key.
	 * @param string $column_position The column position.
	 */
	private function render_widget( $widget_key, $column_position = '' ) {

		if ( empty( $widget_key ) ) {
			return;
		}

		$setting_group = 'wpbf_footer_builder_' . $widget_key;

		switch ( $widget_key ) {
			case 'desktop_logo':
			case 'mobile_logo':
				$this->render_logo_widget( $setting_group );
				break;
			case 'desktop_menu_1':
			case 'desktop_menu_2':
			case 'mobile_menu_1':
			case 'mobile_menu_2':
				$this->render_menu_widget( $widget_key, $setting_group, $column_position );
				break;
			case 'desktop_html_1':
			case 'desktop_html_2':
			case 'mobile_html_1':
			case 'mobile_html_2':
				$this->render_html_widget( $widget_key, $setting_group );
				break;
			case 'desktop_social':
			case 'mobile_social':
				$this->render_social_widget( $setting_group );
				break;
			case 'desktop_copyright':
			case 'mobile_copyright':
				$this->render_copyright_widget( $setting_group );
				break;
			case 'desktop_button_1':
			case 'desktop_button_2':
			case 'mobile_button_1':
			case 'mobile_button_2':
				$this->render_button_widget( $setting_group );
				break;
		}

	}

	/**
	 * Render the builder logo widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_logo_widget( $setting_group ) {

		$custom_logo = get_theme_mod( $setting_group . '_image', '' );

		if ( ! empty( $custom_logo ) ) {
			echo '<div class="wpbf-footer-logo">';
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
			echo '<img src="' . esc_url( $custom_logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
			echo '</a>';
			echo '</div>';
		} else {
			echo '<div class="wpbf-footer-logo">';
			get_template_part( 'inc/template-parts/logo/logo' );
			echo '</div>';
		}

	}

	/**
	 * Render footer builder's menu widget.
	 *
	 * @param string $widget_key    The widget key.
	 * @param string $setting_group The setting group key.
	 * @param string $placement     The placement position.
	 */
	private function render_menu_widget( $widget_key, $setting_group, $placement = '' ) {

		$menu_id = get_theme_mod( $setting_group . '_menu_id', '' );

		if ( empty( $menu_id ) ) {
			return;
		}

		$widget_title = get_theme_mod( $setting_group . '_widget_title', '' );

		// Wrapper div to ensure title and nav stack vertically within flex column.
		echo '<div class="wpbf-footer-menu-widget">';

		if ( ! empty( $widget_title ) ) {
			$title_class = 'wpbf-footer-widget-title wpbf-footer-widget-title-' . esc_attr( $widget_key );
			echo '<h4 class="' . esc_attr( $title_class ) . '">' . esc_html( $widget_title ) . '</h4>';
		}

		$menu_position_class = 'center' === $placement ? 'wpbf-menu-centered' : 'wpbf-menu-' . $placement;

		echo '<nav class="wpbf-footer-nav wpbf-clearfix ' . esc_attr( $menu_position_class ) . '" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="' . esc_attr__( 'Footer Navigation', 'page-builder-framework' ) . '">';

		$menu_container_class = 'wpbf-footer-menu ' . $widget_key;

		$nav_menu_args = array(
			'menu'        => $menu_id,
			'container'   => false,
			'menu_class'  => $menu_container_class,
			'depth'       => 1,
			'fallback_cb' => false,
		);

		wp_nav_menu( $nav_menu_args );

		echo '</nav>';
		echo '</div>';

	}

	/**
	 * Render the builder html widget.
	 *
	 * @param string $widget_key    The widget key (e.g., 'desktop_html_1').
	 * @param string $setting_group The setting group key.
	 */
	private function render_html_widget( $widget_key, $setting_group ) {

		$widget_title = get_theme_mod( $setting_group . '_widget_title', '' );

		$default_content = '';

		if ( false !== strpos( $widget_key, 'html_1' ) ) {
			$default_content = __( 'Content for widget HTML 1', 'page-builder-framework' );
		} elseif ( false !== strpos( $widget_key, 'html_2' ) ) {
			$default_content = __( 'Content for widget HTML 2', 'page-builder-framework' );
		}

		$content = wpbf_customize_str_value( $setting_group . '_content', $default_content );

		// Return early if both title and content are empty.
		if ( empty( $widget_title ) && empty( $content ) ) {
			return;
		}

		// Content should be parsed for template tags and shortcodes.
		$content = wpbf_parse_template_tags( $content );
		$content = do_shortcode( $content );

		// Add unique class for postMessage live preview targeting.
		$widget_class = 'wpbf-footer-html-widget wpbf_footer_builder_' . esc_attr( $widget_key );

		// Wrapper div to ensure title and content stack vertically within flex column.
		echo '<div class="wpbf-footer-html-widget-wrapper">';

		if ( ! empty( $widget_title ) ) {
			$title_class = 'wpbf-footer-widget-title wpbf-footer-widget-title-' . esc_attr( $widget_key );
			echo '<h4 class="' . esc_attr( $title_class ) . '">' . esc_html( $widget_title ) . '</h4>';
		}
		?>

		<div class="<?php echo esc_attr( $widget_class ); ?>">
			<?php echo wp_kses_post( $content ); ?>
		</div>

		<?php
		echo '</div>';
	}

	/**
	 * Render the builder social icons widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_social_widget( $setting_group ) {

		$social_links = array(
			'facebook'  => array(
				'url'   => get_theme_mod( $setting_group . '_facebook', '' ),
				'label' => __( 'Facebook', 'page-builder-framework' ),
				'icon'  => 'facebook',
			),
			'twitter'   => array(
				'url'   => get_theme_mod( $setting_group . '_twitter', '' ),
				'label' => __( 'X (Twitter)', 'page-builder-framework' ),
				'icon'  => 'twitter',
			),
			'instagram' => array(
				'url'   => get_theme_mod( $setting_group . '_instagram', '' ),
				'label' => __( 'Instagram', 'page-builder-framework' ),
				'icon'  => 'instagram',
			),
			'youtube'   => array(
				'url'   => get_theme_mod( $setting_group . '_youtube', '' ),
				'label' => __( 'YouTube', 'page-builder-framework' ),
				'icon'  => 'youtube',
			),
			'linkedin'  => array(
				'url'   => get_theme_mod( $setting_group . '_linkedin', '' ),
				'label' => __( 'LinkedIn', 'page-builder-framework' ),
				'icon'  => 'linkedin',
			),
		);

		$has_links = false;

		foreach ( $social_links as $social ) {
			if ( ! empty( $social['url'] ) ) {
				$has_links = true;
				break;
			}
		}

		if ( ! $has_links ) {
			return;
		}

		echo '<div class="wpbf-footer-social">';

		foreach ( $social_links as $key => $social ) {
			if ( empty( $social['url'] ) ) {
				continue;
			}

			echo '<a href="' . esc_url( $social['url'] ) . '" class="wpbf-social-icon wpbf-social-' . esc_attr( $key ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $social['label'] ) . '">';

			if ( function_exists( 'wpbf_svg' ) && wpbf_svg_enabled() ) {
				echo wpbf_svg( $social['icon'] );
			} else {
				echo '<i class="wpbff wpbff-' . esc_attr( $social['icon'] ) . '" aria-hidden="true"></i>';
			}

			echo '</a>';
		}

		echo '</div>';

	}

	/**
	 * Render the builder copyright widget.
	 *
	 * @param string $setting_group The setting group key.
	 */
	private function render_copyright_widget( $setting_group ) {

		$text = get_theme_mod( $setting_group . '_text', __( '© [year] [blogname]. All rights reserved.', 'page-builder-framework' ) );

		if ( empty( $text ) ) {
			return;
		}

		$text = wpbf_parse_template_tags( $text );

		echo '<div class="wpbf-footer-copyright">';
		echo wp_kses_post( $text );
		echo '</div>';

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

}
