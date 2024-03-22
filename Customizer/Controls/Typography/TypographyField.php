<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyStore;
use Mapsteps\Wpbf\Customizer\CustomizerStore;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

class TypographyField extends BaseField {

	/**
	 * The setting entity.
	 *
	 * @var CustomizerSettingEntity|null
	 */
	protected $setting_entity = null;

	/**
	 * The transport type.
	 *
	 * @var string
	 */
	protected $transport = '';

	/**
	 * The tab.
	 *
	 * @var string
	 */
	protected $tab = '';

	/**
	 * Add sub controls based on the control arguments.
	 *
	 * @param array $args The arguments for the control.
	 */
	private function addSubControls( $args ) {

		$this->tab = isset( $args['tab'] ) ? $args['tab'] : '';

		// Add the label & description as custom control.
		wpbf_customizer_field()
			->id( $this->control->id . '_label' )
			->type( 'custom' )
			->tab( $this->tab )
			->capability( $this->control->capability )
			->label( $this->control->label )
			->description( $this->control->description )
			->priority( $this->control->priority )
			->activeCallback( $this->control->active_callback )
			->tooltip( $this->control->tooltip )
			->properties( [
				'wrapper_attrs' => [
					'gap' => 'small',
				],
			] )
			->addToSection( $this->control->section_id );

		$this->setting_entity = CustomizerStore::findSettingByControlId( $this->control->id );

		if ( ! $this->setting_entity ) {
			return;
		}

		$this->transport = $this->setting_entity->transport;
		$this->transport = 'auto' === $this->transport ? 'postMessage' : $this->transport;

	}

	/**
	 * Add the font family control.
	 */
	private function addFontFamilyControl() {

		// Add the font family control.
	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		if ( ! TypographyStore::initialized() ) {
			TypographyStore::init();
		}

		$control_args = $this->parseControlArgs();

		$this->addSubControls( $control_args );

	}

}
