import { KyInstance } from "ky";
import { Van } from "vanjs-core";
import { WpbfControlDependencies } from "./Customizer/Controls/Base/src/base-interface";
import { Hooks } from "@wordpress/hooks";

declare global {
	type WpbfBreakpoints = {
		desktop: number;
		tablet: number;
		mobile: number;
	};

	type WpbfTheme = {
		breakpoints: WpbfBreakpoints;
		activeBreakpoint: string;
		isInsideCustomizer: boolean;
	};

	type WpbfDom = {
		findHtmlEl: (selector: string) => HTMLElement | null;
		getHtmlEls: (selector: string) => HTMLElement[];
		getParentHtmlEl: (el: HTMLElement) => HTMLElement | null;
		getSiblings: (
			elementOrSelector: HTMLElement,
			selector?: string,
		) => HTMLElement[];
		getSiblingHtmlEl: (elementOrSelector: HTMLElement) => HTMLElement | null;
		getNextElsUntil: (
			elementOrSelector: Element | string,
			boundarySelector: string,
			filterSelector?: string,
		) => Element[];
		getPrevElsUntil: (
			elementOrSelector: Element | string,
			boundarySelector: string,
			filterSelector?: string,
		) => Element[];
		getLastHtmlEl: (selector: string) => HTMLElement | null;
		directQuerySelector: (
			el: HTMLElement,
			selector: string,
		) => HTMLElement | null;
		forEachEl: (
			selector: string | NodeListOf<Element> | HTMLElement[],
			handler: (el: Element) => void,
		) => void;
		listenDocumentEvent: (
			eventType: string,
			selector: string | null,
			handler: (e: any) => void,
		) => void;
		getAttr: (selector: HTMLElement | string, key: string) => string;
		getAttrAsNumber: (selector: HTMLElement | string, key: string) => number;
		getBreakpoints: () => WpbfBreakpoints;
		getActiveBreakpoint: () => string;
		updateElSrc: (el: HTMLElement | Element, src: string) => void;
		getOffset: (el: HTMLElement) => { top: number; left: number };
		getWindowScrollTop: () => number;
		getPureHeight: (el: HTMLElement) => number;
		builder: Van;
	};

	type SlideToggleOpts = {
		el: HTMLElement;
		direction: "up" | "down";
		duration?: number;
		easing?: string | undefined;
		callback?: () => void | undefined;
		animScope?: string | undefined;
	};

	type WpbfUrl = {
		addUrlParams: (url: string, params: Record<string, any>) => string;
	};

	type WpbfAnim = {
		hideElAfterDelay: (el: HTMLElement, delay: number) => void;
		writeElStyle: (
			el: HTMLElement,
			scope: string | undefined,
			styleContent?: string,
		) => HTMLStyleElement;
		getElStyleId: (el: HTMLElement, scope: string | undefined) => string;
		getElStyleTag: (
			el: HTMLElement,
			scope: string | undefined,
		) => HTMLStyleElement;
		animateScrollTop: (targetPosition: number, duration: number) => void;
		slideToggle: (opts: SlideToggleOpts) => void;
	};

	type WpbfUtils = {
		isInsideCustomizer: () => boolean;
		dom: WpbfDom;
		anim: WpbfAnim;
		fetch: KyInstance;
		url: WpbfUrl;
	};

	type wp = {
		hooks: Hooks;
		customize?: WpbfCustomize;
		media: any;
	};

	interface Window {
		ajaxurl?: string;
		wp: wp;
		WpbfObj: {
			siteUrl: string;
			ajaxurl: string;
		};
		WpbfUtils: WpbfUtils;
		WpbfTheme: WpbfTheme;
		wpbf_infinte_scroll_object: {
			next_Selector: string;
			item_Selector: string;
			content_Selector: string;
			image_loader: string;
			isotope?: boolean;
		};
		wc_add_to_cart_params?: Record<string, any>;
		wpbf_quick_view?: Record<string, any>;
		wpbfCustomizerControlDependencies?: WpbfControlDependencies;
		wpbfCustomizerSectionDependencies?: WpbfControlDependencies;
		wpbfBuilderControlIds?: string[];
		[key: string]: any;
	}

	interface JQueryStatic {
		wp?: {
			wpColorPicker?: any;
		};
	}
}
