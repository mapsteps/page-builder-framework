import {
	handleMobileMenuResize,
	registerSectionHandler,
	registerPanelHandler,
	initializeSectionHandler,
	initializePanelHandlers,
} from "./customizer-util";
import layoutSetup from "./postmessage-parts/layout";
import typographySetup from "./postmessage-parts/typography";
import fourZeroFourSetup from "./postmessage-parts/404";
import navigationSetup from "./postmessage-parts/navigation";
import subMenuSetup from "./postmessage-parts/sub-menu";
import mobileNavigationSetup from "./postmessage-parts/mobile-navigation";
import mobileSubMenuSetup from "./postmessage-parts/mobile-sub-menu";
import logoSetup from "./postmessage-parts/logo";
import taglineSetup from "./postmessage-parts/tagline";
import preHeaderSetup from "./postmessage-parts/pre-header";
import blogPaginationSetup from "./postmessage-parts/blog-pagination";
import sidebarSetup from "./postmessage-parts/sidebar";
import buttonsSetup from "./postmessage-parts/buttons";
import breadcrumbsSetup from "./postmessage-parts/breadcrumbs";
import footerSetup from "./postmessage-parts/footer";
import woocommerceSetup from "./postmessage-parts/woocommerce";
import eddSetup from "./postmessage-parts/edd";
import headerBuilderSetup from "./postmessage-parts/header-builder";
import mobileHeaderBuilderSetup from "./postmessage-parts/mobile-header-builder";
import offCanvasSetup from "./postmessage-parts/off-canvas";
import { proNotice } from "./postmessage-parts/pro-notice";
import headerBuilderRowsSetup from "./postmessage-parts/header-builder-rows";
import headerBuilderButtonsSetup from "./postmessage-parts/header-builder-buttons";
import headerBuilderSearchSetup from "./postmessage-parts/header-builder-search";
import mobileHeaderBuilderRowsSetup from "./postmessage-parts/mobile-header-builder-rows";
import headerBuilderRevealSetup from "./postmessage-parts/header-builder-reveal";
import menuTriggersSetup from "./postmessage-parts/menu-triggers";
import footerBuilderRowsSetup from "./postmessage-parts/footer-builder-rows";
import footerBuilderButtonsSetup from "./postmessage-parts/footer-builder-buttons";

(function ($: JQueryStatic, customizer?: WpbfCustomize) {
	// Mobile menu resize.
	window.addEventListener("resize", handleMobileMenuResize);

	// ========================================
	// EAGER REGISTRATION
	// These handlers are always needed at load
	// ========================================

	layoutSetup($);
	typographySetup();
	logoSetup();
	taglineSetup();

	// ========================================
	// LAZY REGISTRATION SETUP
	// Map sections to their handler functions
	// ========================================

	// Footer sections
	registerSectionHandler("wpbf_footer_options", footerSetup);
	registerSectionHandler("wpbf_404_options", () => fourZeroFourSetup($));

	// Navigation sections
	registerSectionHandler("wpbf_menu_options", navigationSetup);
	registerSectionHandler("wpbf_sub_menu_options", subMenuSetup);
	registerSectionHandler("wpbf_mobile_menu_options", () => {
		mobileNavigationSetup(customizer!);
		mobileSubMenuSetup($, customizer!);
	});

	// Pre-header
	registerSectionHandler("wpbf_pre_header_options", preHeaderSetup);

	// Blog
	registerSectionHandler("wpbf_blog_settings", blogPaginationSetup);

	// Sidebar
	registerSectionHandler("wpbf_sidebar_options", sidebarSetup);

	// Buttons
	registerSectionHandler("wpbf_button_options", buttonsSetup);

	// Breadcrumbs
	registerSectionHandler("wpbf_breadcrumb_settings", breadcrumbsSetup);

	// WooCommerce - only if active
	if (window.wpbfIsWooActive) {
		// WooCommerce has many sections in the woocommerce panel
		registerPanelHandler("woocommerce", woocommerceSetup);
	}

	// EDD
	registerPanelHandler("edd", eddSetup);

	// Header Builder sections - register to header_panel
	registerPanelHandler("header_panel", () => {
		headerBuilderSetup();
		mobileHeaderBuilderSetup();
		offCanvasSetup(customizer);
		headerBuilderRowsSetup(customizer!);
		headerBuilderButtonsSetup();
		headerBuilderSearchSetup();
		mobileHeaderBuilderRowsSetup();
		headerBuilderRevealSetup();
		menuTriggersSetup(customizer);
	});

	// Footer Builder sections - register to footer_panel
	registerPanelHandler("footer_panel", () => {
		footerBuilderRowsSetup();
		footerBuilderButtonsSetup();
	});

	// ========================================
	// LISTEN FOR SECTION EXPANSION
	// ========================================

	customizer?.preview?.bind(
		"wpbf-section-expanded",
		function (sectionId: string) {
			// Initialize specific section handler
			initializeSectionHandler(sectionId);

			// Also check if this section belongs to a panel that has handlers
			customizer?.section?.(sectionId, function (section: WpbfCustomizeSection) {
				const panelId = section.params?.panel;
				if (panelId) {
					initializePanelHandlers(panelId);
				}
			});
		},
	);

	// Pro notice handler
	customizer?.preview?.bind("pro_notice", function (action: string) {
		if (action === "show") {
			proNotice.show();
		} else {
			proNotice.hide();
		}
	});
})(jQuery, window.wp.customize);
