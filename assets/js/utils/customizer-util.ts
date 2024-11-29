import { WpbfCustomizeSetting } from "../../../../../themes/page-builder-framework/Customizer/Controls/Base/src/base-interface";

export type ControlToMove = {
	id: string;
	label?: { from: string; to: string };
	prio?: { from: number; to: number };
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
	sectionFrom: string;
	sectionTo: string;
	controlsToMove: ControlToMove[];
}) {
	for (let i = 0; i < props.controlsToMove.length; i++) {
		const controlObj = props.controlsToMove[i];
		const control = window.wp.customize?.control(controlObj.id);
		if (!control) continue;

		if (controlObj.label && !controlObj.label.from) {
			controlObj.label.from = control.params.label;
		}

		if (controlObj.prio && !controlObj.prio.from) {
			controlObj.prio.from = control.priority();
		}

		props.controlsToMove[i] = controlObj;

		// Lets embed the control earlier so they won't be empty when we move across sections.
		control.actuallyEmbed?.();
	}

	const dependencyValue =
		typeof props.dependency.moveForwardWhenValueIs === "number"
			? String(props.dependency.moveForwardWhenValueIs)
			: props.dependency.moveForwardWhenValueIs;

	window.wp.customize?.(
		props.dependency.settingId,
		(setting: WpbfCustomizeSetting<SV>) => {
			moveStickyHeaderControls(
				toBoolOrString(setting.get()) === dependencyValue,
			);

			setting.bind((value) => {
				moveStickyHeaderControls(toBoolOrString(value) === dependencyValue);
			});
		},
	);

	function moveStickyHeaderControls(moveForward: boolean) {
		for (let i = 0; i < props.controlsToMove.length; i++) {
			const controlObj = props.controlsToMove[i];
			const control = window.wp.customize?.control(controlObj.id);
			if (!control) continue;

			if (controlObj.label) {
				control.params.label = moveForward
					? controlObj.label.to
					: controlObj.label.from;
			}

			if (controlObj.prio) {
				control.priority(
					moveForward ? controlObj.prio.to : controlObj.prio.from,
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
					.html(moveForward ? controlObj.label.to : controlObj.label.from);
			}

			control.section(moveForward ? props.sectionTo : props.sectionFrom);
		}
	}
}
