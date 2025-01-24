import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";

export type ControlToMove = {
	id: string;
	label?: { from: string | undefined; to: string };
	prio?: { from: number | undefined; to: number };
	forceActive?: boolean;
};

function toBoolOrString(value: any) {
	if (typeof value === "boolean") return value;
	if (typeof value === "string") return value;

	return String(value);
}

export function setupControlsMovement<SV>(props: {
	dependency: {
		settingId: string;
		moveForwardWhenValueIs: boolean | string | number;
	};
	sections: {
		from: string;
		to: string;
		controlsToMove: ControlToMove[];
	}[];
}) {
	for (
		let sectionIndex = 0;
		sectionIndex < props.sections.length;
		sectionIndex++
	) {
		const sectionObj = props.sections[sectionIndex];

		for (
			let controlIndex = 0;
			controlIndex < sectionObj.controlsToMove.length;
			controlIndex++
		) {
			const controlObj = sectionObj.controlsToMove[controlIndex];
			const control = window.wp.customize?.control(controlObj.id);
			if (!control) continue;

			if (controlObj.label && !controlObj.label.from) {
				controlObj.label.from = control.params.label;
			}

			if (controlObj.prio && !controlObj.prio.from) {
				controlObj.prio.from = control.priority();
			}

			sectionObj.controlsToMove[controlIndex] = controlObj;

			// Lets embed the control earlier so they won't be empty when we move across sections.
			control.actuallyEmbed?.();
		}

		props.sections[sectionIndex] = sectionObj;
	}

	const dependencyValue =
		typeof props.dependency.moveForwardWhenValueIs === "number"
			? String(props.dependency.moveForwardWhenValueIs)
			: props.dependency.moveForwardWhenValueIs;

	window.wp.customize?.(
		props.dependency.settingId,
		(setting: WpbfCustomizeSetting<SV>) => {
			moveControls(toBoolOrString(setting.get()) === dependencyValue);

			setting.bind((value) => {
				moveControls(toBoolOrString(value) === dependencyValue);
			});
		},
	);

	function moveControls(moveForward: boolean) {
		for (
			let sectionIndex = 0;
			sectionIndex < props.sections.length;
			sectionIndex++
		) {
			const sectionObj = props.sections[sectionIndex];

			for (
				let controlIndex = 0;
				controlIndex < sectionObj.controlsToMove.length;
				controlIndex++
			) {
				const controlObj = sectionObj.controlsToMove[controlIndex];
				const control = window.wp.customize?.control(controlObj.id);
				if (!control) continue;

				if (controlObj.label) {
					control.params.label = moveForward
						? controlObj.label.to
						: controlObj.label.from;
				}

				if (controlObj.prio) {
					control.priority(
						moveForward ? controlObj.prio.to : (controlObj.prio.from ?? 0),
					);
				}

				/**
				 * If this is a control that extends `dynamicControl`, the label won't be updated.
				 *
				 * There are two ways:
				 * 1. Call `control.renderContent()` to change the entire control's content.
				 * 2. Update the label directly via DOM manipulation.
				 *
				 * Updating the DOM directly seems enough (and more reliable) for now.
				 */
				if (control.initWpbfControl && controlObj.label) {
					control.container
						.find(".customize-control-title")
						.html(
							moveForward ? controlObj.label.to : (controlObj.label.from ?? ""),
						);
				}

				if (controlObj.forceActive && moveForward) {
					control.onChangeActive(true, {});
				}

				const sectionId = moveForward ? sectionObj.to : sectionObj.from;

				control.container.attr("data-wpbf-parent-tab-id", sectionId);
				control.section(sectionId);
			}
		}
	}
}
