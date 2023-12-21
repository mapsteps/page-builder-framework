<?php
/**
 * Aura customizer control.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer;

use Mapsteps\Aura\Customizer\Entities\AuraControlEntity;

/**
 * Class to add Aura customizer control.
 */
final class AuraCustomizerControl {

	/**
	 * Set the control's type.
	 *
	 * @param string $type Control type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		return $this;

	}

	/**
	 * Set the control's setting.
	 *
	 * @param string $setting Setting id.
	 *
	 * @return $this
	 */
	public function setting( $setting ) {

		return $this;

	}

	/**
	 * Set the control's label.
	 *
	 * @param string $label Control label.
	 *
	 * @return $this
	 */
	public function label( $label ) {

		return $this;

	}

	/**
	 * Set the control's description.
	 *
	 * @param string $description Control description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		return $this;

	}

	/**
	 * Set the control's transport.
	 *
	 * @param string $transport Control transport.
	 *
	 * @return $this
	 */
	public function transport( $transport ) {

		return $this;

	}

	/**
	 * Set the control's priority.
	 *
	 * @param int $priority Control priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		return $this;

	}

	/**
	 * Add control to a section.
	 *
	 * @param string $section_id Section id.
	 *
	 * @return AuraControlEntity
	 */
	public function addToSection( $section_id ) {

		return new AuraControlEntity();

	}

}
