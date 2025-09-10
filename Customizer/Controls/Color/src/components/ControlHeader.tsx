import ColorPickerCirleTrigger from "./ColorPickerCircleTrigger";
import ControlLabel from "./ControlLabel";
import { hexColorFromHueModeValue } from "../utils/misc";
import { ColorControlLabelStyle } from "../color-interface";

export default function ControlHeader(props: {
	label: string;
	description: string;
	labelStyle: ColorControlLabelStyle;
	pickerComponent: string;
	useHueMode: boolean;
	inputValue?: string | number;
	isPopupOpen?: boolean;
	togglePicker?: () => void;
	resetRef?: React.MutableRefObject<HTMLButtonElement | null>;
	onResetButtonClick: () => void;
	setNotificationContainer?: any;
}) {
	const { label, description, labelStyle, setNotificationContainer } = props;

	function renderLabel() {
		return (
			<ControlLabel
				label={label}
				description={description}
				setNotificationContainer={setNotificationContainer}
			/>
		);
	}

	function renderTrigger(useTooltip?: boolean) {
		if (
			typeof props.inputValue === "undefined" ||
			typeof props.isPopupOpen === "undefined"
		) {
			return <></>;
		}

		return (
			<div className="wpbf-buttons">
				<ColorPickerCirleTrigger
					color={String(
						props.useHueMode
							? hexColorFromHueModeValue(props.inputValue)
							: props.inputValue,
					)}
					isPopupOpen={props.isPopupOpen}
					resetRef={props.resetRef}
					onToggleButtonClick={props.togglePicker}
					onResetButtonClick={props.onResetButtonClick}
					tooltip={useTooltip && !props.isPopupOpen ? label : undefined}
				/>
			</div>
		);
	}

	switch (labelStyle) {
		case "tooltip":
			return <>{renderTrigger(true)}</>;

		case "top":
			return (
				<>
					{renderLabel()}
					{renderTrigger()}
				</>
			);

		case "label_only":
			return renderLabel();

		case "none":
			return renderTrigger();

		default:
			return (
				<>
					<div className="wpbf-control-cols">
						<div className="wpbf-control-left-col">{renderLabel()}</div>
						<div className="wpbf-control-right-col">{renderTrigger()}</div>
					</div>
				</>
			);
	}
}
