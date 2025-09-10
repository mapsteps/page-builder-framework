export const proNotice = {
	show: (autoHide?: boolean) => {
		const notice = document.querySelector(".udb-pro-login-customizer-notice");

		if (!(notice instanceof HTMLElement)) return;

		notice.classList.add("is-shown");

		if (autoHide) setTimeout(proNotice.hide, 3000);
	},

	hide: () => {
		const notice = document.querySelector(".udb-pro-login-customizer-notice");

		if (!(notice instanceof HTMLElement)) return;

		notice.classList.remove("is-shown");
	},
};
