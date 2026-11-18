/**
 * The form of the margin/padding types (one control, see margin-padding-control.tsx):
 *
 * - wpbf-margin-padding: a number field per side (top, right, bottom, left, or the sides given).
 * - wpbf-responsive-margin-padding: the same per device (desktop_top … mobile_left).
 *
 * Saves an object with the unit on each side ("10px"), or without it (`dontSaveUnit`), or as JSON text
 * (`saveAsJson`, as the theme's padding options do). Keeps the markup of the old form.
 */
import type { ChangeEvent } from "react";
import {
	isSet,
	Notifications,
	ReactControlFormProps,
	usePreviewedDevice,
	useSettingValue,
} from "../../Base/src/react-base";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import { encodeJsonOrDefault } from "../../Generic/src/string-util";
import { MarginPaddingSettingValue, MarginPaddingValue, WpbfCustomizeMarginPaddingControlParams } from "./interface";
import { makeFieldValues, makeObjValueWithoutUnit, makeObjValueWithUnit } from "./margin-padding-util";

type Props = ReactControlFormProps<MarginPaddingSettingValue, WpbfCustomizeMarginPaddingControlParams>;

export default function MarginPaddingForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);
	const isResponsive = "wpbf-responsive-margin-padding" === params.type;
	const devices = isResponsive ? (params.devices ?? []) : [];
	const activeDevice = usePreviewedDevice(devices);

	// The field values: as PHP prepared them, until the value changes.
	const fields: MarginPaddingValue =
		value === params.value ? params.valueArray : makeFieldValues(params.dimensions, value);

	const save = (values: MarginPaddingValue) => {
		if (params.saveAsJson) {
			// As typed (fields left alone keep their numbers).
			setValue(encodeJsonOrDefault<MarginPaddingValue>(values));
		} else if (params.dontSaveUnit) {
			setValue(makeObjValueWithoutUnit(params.dimensions, values));
		} else {
			setValue(makeObjValueWithUnit(params.dimensions, params.unit, values));
		}
	};

	const onType = (dimension: string, e: ChangeEvent<HTMLInputElement>) => {
		if (!params.dimensions.includes(dimension) || !fields.hasOwnProperty(dimension)) return;

		save({ ...fields, [dimension]: e.target.value });
	};

	// Reset the sides of a device (all sides without devices) to the default, or to the value the Customizer opened
	// with when there's no default.
	const reset = (device: string) => {
		const defaults = isSet(params.default) ? params.defaultArray : params.valueArray;

		if (!device) {
			save(defaults);
			return;
		}

		const values = { ...fields };

		for (const dimension in values) {
			if (dimension.includes(device + "_") && defaults.hasOwnProperty(dimension)) {
				values[dimension] = defaults[dimension];
			}
		}

		save(values);
	};

	// The header label points at the first field shown (the first side, of the shown device).
	const firstDimension = Object.keys(fields).find((dimension) => !isResponsive || dimension.includes(activeDevice + "_"));
	const firstFieldId = `_customize-input-${control.id}${isResponsive ? `-${activeDevice}` : ""}-${firstDimension ?? ""}`;

	const renderFields = (device: string) => (
		<>
			<button type="button" className="wpbf-control-reset" onClick={() => reset(device)}>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<div className="wpbf-control-cols">
				<div className="wpbf-control-left-col">
					<div className="wpbf-control-fields">
						{Object.keys(fields)
							.filter((dimension) => !device || dimension.includes(device + "_"))
							.map((dimension) => {
								const fieldValue = fields[dimension];
								const inputId = `_customize-input-${control.id}${device ? `-${device}` : ""}-${dimension}`;

								return (
									<div className="wpbf-control-field" key={dimension}>
										<input
											id={inputId}
											type="number"
											value={fieldValue || 0 === fieldValue ? fieldValue : ""}
											className={`wpbf-control-input wpbf-control-input${device ? `-${device}` : ""}-${dimension}`}
											onChange={(e) => onType(dimension, e)}
										/>
										<label className="wpbf-control-sublabel" htmlFor={inputId}>
											{device ? dimension.replace(device + "_", "") : dimension}
										</label>
									</div>
								);
							})}
					</div>
				</div>
				<div className="wpbf-control-right-col">
					<span className="wpbf-control-unit">{params.unit}</span>
				</div>
			</div>
		</>
	);

	return (
		<>
			<header className="wpbf-control-header">
				{params.label && (
					<label className="customize-control-title" htmlFor={firstFieldId}>
						<span className="customize-control-title">{params.label}</span>
					</label>
				)}

				{isResponsive && devices.length > 0 && <DeviceButtons devices={devices} active={activeDevice} />}
			</header>

			{params.description && (
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: params.description }}
				/>
			)}

			<Notifications control={control} />

			<div className="wpbf-control-form">
				{isResponsive && devices.length > 0
					? devices.map((device) => (
							<div
								className={`wpbf-control-device wpbf-control-${device}${device === activeDevice ? " is-active" : ""}`}
								data-wpbf-device={device}
								key={device}
							>
								{renderFields(device)}
							</div>
						))
					: renderFields("")}
			</div>
		</>
	);
}
