<?php
/**
 * Select choices.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

class SelectChoices {

	/**
	 * Format the 'choices' args for 'select' control.
	 *
	 * For the usage, it accepts format like in Kirki, Select2 or ReactSelect.
	 * It will then be converted to Select2 format.
	 *
	 * @see https://github.com/themeum/kirki/issues/1120#issuecomment-304480821 for Kirki's format.
	 * @see https://select2.org/data-sources/formats for Select2's format.
	 * @see @see https://github.com/JedWatson/react-select/blob/master/storybook/data.ts  for ReactSelect's format.
	 *
	 * @param array $choices The choices to format. Can be using Kirki, Select2 or ReactSelect's format.
	 *
	 * @return array The choices formatted for Select2.
	 */
	public function toSelect2Format( $choices = [] ) {

		$options = [];

		foreach ( $choices as $key => $choice ) {
			if ( is_int( $key ) ) {
				if ( is_array( $choice ) ) {
					if ( isset( $choice['text'] ) ) {
						if ( isset( $choice['id'] ) || isset( $choice['children'] ) ) {
							// If this block is reached, it's assumed that we already have correct Select2 format.
							$options[] = $choice;
							continue;
						}
					}

					if ( ! isset( $choice['label'] ) ) {
						continue;
					}

					if ( ! isset( $choice['value'] ) && isset( $choice['options'] ) ) {
						continue;
					}

					$option = [];

					$option['text'] = (string) $choice['label'];

					if ( isset( $choice['value'] ) ) {
						$option['id'] = (string) $choice['value'];
					}

					if ( ! empty( $choice['options'] ) && is_array( $choice['options'] ) ) {
						$option['children'] = [];

						foreach ( $choice['options'] as $choice_option ) {
							if ( ! isset( $choice_option['label'] ) || ! isset( $choice_option['value'] ) ) {
								continue;
							}

							$option['children'][] = [
								'text' => $choice_option['label'],
								'id'   => $choice_option['value'],
							];
						}
					}

					if ( ! empty( $option ) ) {
						$options[] = $option;
					}

					continue;
				}

				$key = (string) $key;
			}

			if ( ! is_array( $choice ) ) {
				$options[] = [
					'text' => $choice,
					'id'   => $key,
				];

				continue;
			}

			$label = isset( $choice[0] ) ? $choice[0] : $key;

			$option['text']     = $label;
			$option['children'] = [];

			$subvalues = ! empty( $choice[1] ) && is_array( $choice[1] ) ? $choice[1] : [];

			foreach ( $subvalues as $subvalue => $sublabel ) {
				$option['children'][] = array(
					'text' => $sublabel,
					'id'   => $subvalue,
				);
			}

			$options[] = $option;
		}

		return $options;

	}

}
