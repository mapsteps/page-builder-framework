<?php
/**
 * Select control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

class SelectChoices {

	/**
	 * Format the 'choices' args for 'select' control.
	 *
	 * For the usage, it accepts format like in Kirki or ReactSelect.
	 * It will then be converted to our internal format.
	 *
	 * @see https://github.com/themeum/kirki/issues/1120#issuecomment-304480821 for Kirki's choices.
	 * @see https://github.com/JedWatson/react-select/blob/master/storybook/data.ts  for ReactSelect's options.
	 *
	 * @param array $choices The choices to format. Can be using Kirki's choices or ReactSelect's options.
	 *
	 * @return array The formatted choices for internal use.
	 */
	public function format( $choices = [] ) {

		$options = [];

		foreach ( $choices as $key => $choice ) {
			if ( is_int( $key ) ) {
				if ( is_array( $choice ) ) {
					if ( ! isset( $choice['label'] ) ) {
						continue;
					}

					if ( ! isset( $choice['value'] ) && isset( $choice['options'] ) ) {
						continue;
					}

					$option = [];

					$option['l'] = (string) $choice['label'];

					if ( isset( $choice['value'] ) ) {
						$option['v'] = (string) $choice['value'];
					}

					if ( ! empty( $choice['options'] ) && is_array( $choice['options'] ) ) {
						$option['o'] = [];

						foreach ( $choice['options'] as $choice_option ) {
							if ( ! isset( $choice_option['label'] ) || ! isset( $choice_option['value'] ) ) {
								continue;
							}

							$option['o'][] = [
								'l' => $choice_option['label'],
								'v' => $choice_option['value'],
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
					'l' => $choice,
					'v' => $key,
				];

				continue;
			}

			$label = isset( $choice[0] ) ? $choice[0] : $key;

			$option['l'] = $label;
			$option['o'] = [];

			$subvalues = ! empty( $choice[1] ) && is_array( $choice[1] ) ? $choice[1] : [];

			foreach ( $subvalues as $subvalue => $sublabel ) {
				$option['o'][] = array(
					'l' => $sublabel,
					'v' => $subvalue,
				);
			}

			$options[] = $option;
		}

		return $options;

	}

}
