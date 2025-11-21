import {
	handleMobileMenuResize,
	handleMobileMenuToggle,
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

(function ($: JQueryStatic, customizer?: WpbfCustomize) {
	// Mobile menu resize.
	window.addEventListener("resize", handleMobileMenuResize);

	// Mobile menu toggle.
	const mobileMenuToggle = document.querySelector(".wpbf-mobile-menu-toggle");
	if (mobileMenuToggle) {
		mobileMenuToggle.addEventListener("click", handleMobileMenuToggle);
	}

	layoutSetup($);
	typographySetup();
	fourZeroFourSetup($);
	navigationSetup();
	subMenuSetup();
	mobileNavigationSetup(customizer!);
	mobileSubMenuSetup($, customizer!);
	logoSetup();
	taglineSetup();
	preHeaderSetup();
	blogPaginationSetup();
	sidebarSetup();
	buttonsSetup();
	breadcrumbsSetup();
	footerSetup();
	woocommerceSetup();
	eddSetup();
	headerBuilderSetup();
	mobileHeaderBuilderSetup();
	offCanvasSetup(customizer);
	headerBuilderRowsSetup(customizer!);
	headerBuilderButtonsSetup();
	headerBuilderSearchSetup();
	mobileHeaderBuilderRowsSetup();
	headerBuilderRevealSetup();
	menuTriggersSetup(customizer);
	window.wp.customize?.preview?.bind("pro_notice", function (action: string) {
		if (action === "show") {
			proNotice.show();
		} else {
			proNotice.hide();
		}
	});
})(jQuery, window.wp.customize);
