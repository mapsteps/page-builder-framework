import { Control_Constructor } from "wordpress__customize-browser/Control_Constructor";
import {
	DirtyValuesOptions,
	HandleSettingValiditiesArgs,
	RequestChangesetUpdateOptions,
} from "wordpress__customize-browser/Customize";
import {
	SelectControlValue,
	WpbfSelectControl,
} from "../../Select/src/select-interface";
import { Setting } from "wordpress__customize-browser/Setting";
import {
	WpbfColorControl,
	WpbfColorControlValue,
	WpbfMulticolorControl,
	WpbfMulticolorControlValue,
} from "../../Color/src/color-interface";
import { WpbfDimensionControl } from "../../Dimension/src/dimension-interface";
import { WpbfMarginPaddingControl } from "../../MarginPadding/src/margin-padding-interface";
import {
	WpbfInputSliderControl,
	WpbfResponsiveInputSliderControl,
} from "../../Slider/src/slider-interface";
import { WpbfSortableControl } from "../../Sortable/src/sortable-interface";
import { Section_Constructor } from "wordpress__customize-browser/Section_Constructor";
import { Section } from "wordpress__customize-browser/Section";
import {
	WpbfAssocArrayControl,
	WpbfGenericControl,
	WpbfResponsiveGenericControl,
} from "../../Generic/src/generic-interface";
import {
	Container_Arguments,
	Container_Deferred,
} from "wordpress__customize-browser/Container";
import { Value } from "wordpress__customize-browser/Value";
import { Notifications } from "wordpress__customize-browser/Notifications";
import { Values } from "wordpress__customize-browser/Values";
import { Utils } from "wordpress__customize-browser/Utils";
import { Class } from "wordpress__customize-browser/Class";
import { Panel } from "wordpress__customize-browser/Panel";
import { ThemesPanel } from "wordpress__customize-browser/ThemesPanel";
import { Previewer } from "wordpress__customize-browser/Previewer";
import { Element_Synchronizer } from "wordpress__customize-browser/Element";
import { Notification } from "wordpress__customize-browser/Notification";
import { Root } from "react-dom/client";
import {
	WpbfCheckboxButtonsetControl,
	WpbfCheckboxControl,
} from "../../Checkbox/src/checkbox-interface";
import { WpbfEditorControl } from "../../Editor/src/editor-interface";
import {
	WpbfRepeaterControl,
	WpbfRepeaterRow,
} from "../../Repeater/src/repeater-interface";
import {
	BuilderWidget,
	WpbfBuilderControl,
	WpbfResponsiveBuilderControl,
} from "../../Builder/src/builder-interface";
import { WpbfImageControl } from "../../Media/src/image-interface";

declare global {
	export interface WpbfCustomize extends Values<WpbfCustomizeSetting<any>> {
		_latestRevision: number;
		_lastSavedRevision: number;
		_latestSettingRevision: Record<string, number>;
		utils: Utils;
		ensure(element: string | JQuery): JQuery;
		dirtyValues(options?: DirtyValuesOptions): Record<string, any>;
		requestChangesetUpdate(
			changes?: Record<string, any>,
			args?: RequestChangesetUpdateOptions,
		): JQuery.Promise<any>;
		get(): Record<string, any>;
		defaultConstructor: WpbfCustomizeSetting<Class>;
		Panel: WpbfCustomizePanel;
		panel: Values<WpbfCustomizePanel>;
		section: Values<WpbfCustomizeSection>;
		Section: WpbfCustomizeSection;
		control: Values<WpbfCustomizeControl<any, any> | undefined>;
		notifications: Notifications;
		setDocumentTitle(documentTitle: string): void;
		settingConstructor: WpbfCustomizeSettingConstructor;
		controlConstructor: WpbfCustomizeControlConstructor;
		panelConstructor: WpbfCustomizePanelConstructor;
		sectionConstructor: WpbfCustomizeSectionConstructor;
		_handleSettingValidities(args: HandleSettingValiditiesArgs): void;
		findControlsForSettings(
			settingIds: readonly string[],
		): Record<string, WpbfCustomizeControl<any, any>>;
		reflowPaneContents(): void;
		state: Values<Class>;
		settings: any;
		l10n: Record<string, string>;
		previewer: Previewer<string>;
		previewedDevice: Value<string>;
		Control: WpbfCustomizeControl<any, any>;

		// ! There's a mistake or missing part in this type definition.
		Element: WpbfCustomizeElement;

		Value: Value<any>;

		// ! There's a mistake or missing part in this type definition.
		Notification(arg0?: any, arg1?: any): Notification;

		// ! I don't have type for this yet.
		selectiveRefresh: any;

		// Specific to PBF.
		wpbfDynamicControl: WpbfCustomizeControl<any, any>;
	}
}

export interface WpbfCustomizeSetting<T> extends Setting<T> {
	get(): T;

	notifications: any;
}

export interface WpbfCustomizeElement
	extends Value<string | JQuery<HTMLElement>> {
	synchronizer: Element_Synchronizer;
	element: JQuery;
	events: string;
	_value: any;
	initialize(element?: string | JQuery, options?: object): void;
	find(selector: any): JQuery;
	refresh(): void;
	update(to?: string | JQuery): void;
}

export interface WpbfCustomizeSettingConstructor {}

export interface WpbfCustomizePanelConstructor {
	themes: ThemesPanel;
}

export interface WpbfCustomizePanelParams {
	id: string;
	type: string;
	active: boolean;
	title: string;
	description: string;
	content: string;
	autoExpandSoleSection: boolean;
	instanceNumber: number;
	priority: number;
	parentId?: string;
}

export interface WpbfCustomizePanel extends Panel {
	prototype: {
		attachEvents(): void;
		embed(): void;
		isContextuallyActive(): boolean;
	};
	id: string;
	params: WpbfCustomizePanelParams;
	extend: (protoProps: object, staticProps?: object) => WpbfCustomizePanel;
	headContainer: JQuery;
}

export interface WpbfCustomizeSectionConstructor extends Section_Constructor {
	"wpbf-link": any;
	"wpbf-base": any;
	"wpbf-invisible": any;
}

export interface WpbfCustomizeSectionParams {
	id: string;
	type?: string;
	panel?: string | null | undefined;
	active?: boolean;
	content?: "";
	customizeAction?: string | undefined;
	title: string;
	description?: string;
	description_hidden: boolean;
	instanceNumber?: number | null;
	priority?: number;
	parentId?: string;
	tabs?: Record<string, { label: string; [key: string]: string }>[];
	tabMenuOutput: string;
	tabClassName: string;
}

export interface WpbfCustomizeSection extends Section {
	prototype: {
		embed: () => void;
		isContextuallyActive: () => boolean;
		attachEvents: () => void;
	};
	extend: (protoProps: object, staticProps?: object) => WpbfCustomizeSection;
	params: WpbfCustomizeSectionParams;
}

export type WpbfCustomizeControlSettings = (
	| Record<string, WpbfCustomizeSetting<any> | Value<any>>
	| Array<WpbfCustomizeSetting<any> | Value<any>>
) & {
	default?: string | WpbfCustomizeSetting<any> | undefined;
};

export interface WpbfCustomizeControl<SV, CP> {
	prototype: WpbfCustomizeControl<SV, CP>;
	instanceCounter?: number | undefined;
	defaultActiveArguments: Container_Arguments;
	defaults: CP;
	params: CP;
	id: string;
	selector: string;
	container: JQuery;
	templateSelector: string;
	deferred: Container_Deferred;
	section: Value<string>;
	priority: Value<number>;
	active: Value<boolean>;
	activeArgumentsQueue: Container_Arguments[];
	notifications: Notifications;
	elements: WpbfCustomizeElement[];
	settings: WpbfCustomizeControlSettings;
	setting: WpbfCustomizeSetting<SV> | null;
	propertyElements: Array<WpbfCustomizeElement>;
	extend<CT>(this: CT, protoProps: Partial<CT>, classProps?: object): CT;
	initialize(id?: string, options?: CP): void;
	linkElements(): void;
	embed(): void;
	ready(): void;
	getNotificationsContainerElement(): JQuery;
	setupNotifications(): void;
	renderNotifications(): void;
	expand(params: Container_Arguments): void;
	focus(params?: any): void;
	onChangeActive(active: boolean, args: Container_Arguments): void;
	toggle(active: boolean): void;
	activate(params?: Container_Arguments): boolean;
	deactivate(params?: Container_Arguments): boolean;
	_toggleActive(active: boolean, params: Container_Arguments): boolean;
	dropdownInit(): void;
	renderContent(): void;
	addNewPage(): void;

	// Specific to PBF.
	root?: Root;
	form?: HTMLElement;
	initialized?: boolean;
	findHtmlEl?: (
		elOrSelector: string | HTMLElement | undefined | null,
		selector?: string,
	) => HTMLElement | undefined;
	findHtmlEls?: (
		elOrSelector: string | HTMLElement | undefined | null,
		selector?: string,
	) => HTMLElement[];
	setNotificationContainer?: (el: HTMLElement) => void;
	destroy?: VoidFunction;
	updateCustomizerSetting?: (value?: SV) => void;
	updateComponentState?: (val: SV) => void;
	validateCssValue?: (value: string | number) => boolean;
	wpbfNotifications?: VoidFunction;
	onChange?: (value: SV) => void;
	onReset?: () => void;

	// Specific to PBF's dynamic control.
	_setUpSettingRootLinks?: () => void;
	_setUpSettingPropertyLinks?: () => void;
	initWpbfControl?: (control?: WpbfCustomizeControl<SV, CP>) => void;
	actuallyEmbed?: () => void;

	// Specific to PBF's checkbox-buttonset control.
	currentValue?: SV;

	// Specific to PBF's color control.
	updateColorPicker?: (value: WpbfColorControlValue) => void;

	// Specific to PBF's multicolor control.
	updateColorPickers?: (value: WpbfMulticolorControlValue) => void;
	togglePopup?: Record<string, () => void>;
	isPopupOpen?: Record<string, () => boolean>;

	// Specific to PBF's select control.
	doSelectAction?: (action: string, value: SelectControlValue) => void;

	// Specific to PBF's sortable control.
	getNewValues?: () => any[];

	// Specific to PBF's repeater control.
	settingField?: JQuery<HTMLElement>;
	setValue?: (
		newValue: Record<string, any>,
		refresh?: boolean,
		filtering?: boolean,
	) => void;
	getValue?: () => Record<string, any>[];
	repeaterFieldsContainer?: JQuery<HTMLElement>;
	currentIndex?: number;
	rows?: WpbfRepeaterRow[];
	addRow?: (
		data?: Record<string, Record<string, any>>,
	) => WpbfRepeaterRow | undefined;
	initColorPicker?: () => void;
	initSelect?: (theNewRow: WpbfRepeaterRow, data?: Record<string, any>) => void;
	sort?: () => void;
	deleteRow?: (index: number) => void;
	updateField?: (
		e: JQuery.TriggeredEvent,
		rowIndex: number,
		fieldId: string,
		element: HTMLInputElement | HTMLTextAreaElement,
	) => void;
	$thisButton?: JQuery;
	repeaterTemplate?: () => any;
	openFrame?: (e: JQuery.TriggeredEvent) => void;
	removeImage?: (e: JQuery.TriggeredEvent) => void;
	removeFile?: (e: JQuery.TriggeredEvent) => void;
	initFrame?: () => void;
	initCropperFrame?: () => void;
	onSelect?: (e: JQuery.TriggeredEvent) => void;
	onSelectForCrop?: () => void;
	onCropped?: (croppedImage: object) => void;
	setImageInRepeaterField?: (attachment: Record<string, any>) => void;
	setFileInRepeaterField?: (attachment: Record<string, any>) => void;

	// Specific to Header Builder.
	isSaving?: boolean;
	emptyWidgetMarkup?: string;
	isSortableEmpty?: (sortableEl: HTMLElement) => boolean;
	checkSortableContent?: (sortableEl: HTMLElement) => void;
	isWidgetActive?: (widgetKey: string, device?: string) => boolean;
	findWidgetByKey?: (widgetKey: string) => BuilderWidget | undefined;
	handleDeleteActiveWidget?: (
		activeWidgetEl: HTMLElement,
		availableWidgetEl: HTMLElement,
	) => void;
	availableWidgetsPanel?: HTMLElement;
	builderPanel?: HTMLElement;
	buildAvailableWidgetsPanel?: () => void;
	buildBuilderPanel?: () => void;
	draggableData?: Record<string, string> | undefined;
	initDraggable?: () => void;
	initDroppable?: () => void;
	parseDraggableData?: (e: DragEvent) => Record<string, string> | undefined;
	getWidgetItemFromDraggableData?: (e: DragEvent) => HTMLElement | undefined;
	createWidgetItem?: (
		widgetKey: string,
		insideBuilderPanel?: boolean,
	) => HTMLElement | undefined;
	handleRowSettingClick?: (rowKey: string) => void;
	bindCustomizeSection?: (rowKey: string) => void;
	handleWidgetClick?: (
		widgetEl: HTMLElement,
		widgetData: BuilderWidget,
	) => void;
	initSortable?: () => void;
	destroyDraggable?: () => void;
	destroySortable?: () => void;

	// Gave up (still some/many types are missing)
	[key: string]: any;
}

export interface AnyWpbfCustomizeControl
	extends WpbfCustomizeControl<any, any> {}

export interface WpbfCustomizeControlParams<SV> {
	label: string;
	description: string;
	active: boolean;
	priority: number;
	type: any;
	content?: string;
	templateId?: string;
	section: string;
	setting?: SV;
	settings: WpbfCustomizeControlSettings;
	instanceNumber?: number;
	params?: WpbfCustomizeControlParams<SV>;

	// Specific to PBF.
	sectionId: string;
	default: SV;
	value: SV;
	choices: Record<string, any> | any[];
	link: string;
	id: string;
	ajaxurl: string;
	inputAttrs: Record<string, number | string>;
	inputId: string;
	wrapperAttrs: Record<string, number | string>;
	allowCollapse: boolean;
	[key: string]: any;
}

export interface WpbfCustomizeControlConstructor extends Control_Constructor {
	"wpbf-checkbox": WpbfCheckboxControl;
	"wpbf-checkbox-buttonset": WpbfCheckboxButtonsetControl;
	"wpbf-color": WpbfColorControl;
	"wpbf-multicolor": WpbfMulticolorControl;
	"wpbf-dimension": WpbfDimensionControl;
	"wpbf-editor": WpbfEditorControl;
	"wpbf-generic": WpbfGenericControl;
	"wpbf-responsive-generic": WpbfResponsiveGenericControl;
	"wpbf-assoc-array": WpbfAssocArrayControl;
	"wpbf-image": WpbfImageControl;
	"wpbf-margin-padding": WpbfMarginPaddingControl;
	"wpbf-responsive-margin-padding": WpbfMarginPaddingControl;
	"wpbf-radio": {};
	"wpbf-radio-buttonset": {};
	"wpbf-radio-image": {};
	"wpbf-repeater": WpbfRepeaterControl;
	"wpbf-enhanced-select": WpbfSelectControl;
	"wpbf-slider": WpbfCustomizeControl<
		number | string,
		WpbfCustomizeControlParams<number | string>
	>;
	"wpbf-input-slider": WpbfInputSliderControl;
	"wpbf-responsive-input-slider": WpbfResponsiveInputSliderControl;
	"wpbf-sortable": WpbfSortableControl;
	"wpbf-toggle": WpbfCheckboxControl;
	"wpbf-builder": WpbfBuilderControl;
	"wpbf-responsive-builder": WpbfResponsiveBuilderControl;
}

export interface WpbfSectionDependency {
	// The `id` prop here is for backwards compatibility.
	id?: string;
	setting: string;
	operator: string;
	value: string;
}

export interface WpbfSectionDependencies {
	[dependantSectionId: string]: WpbfSectionDependency[];
}

export interface WpbfReversedSectionDependency {
	dependantSectionId: string;
	operator: string;
	value: string;
}

export interface WpbfReversedSectionDependencies {
	[dependencySettingId: string]: WpbfReversedSectionDependency[];
}

export interface WpbfControlDependency {
	// The `id` prop here is for backwards compatibility.
	id?: string;
	setting: string;
	operator: string;
	value: string;
}

export interface WpbfControlDependencies {
	[dependantControlId: string]: WpbfControlDependency[];
}

export interface WpbfReversedControlDependency {
	dependantControlId: string;
	operator: string;
	value: string;
}

export interface WpbfReversedControlDependencies {
	[dependencySettingId: string]: WpbfReversedControlDependency[];
}
