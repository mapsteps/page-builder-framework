import { useEffect } from "react";

export default function useWindowResize(handler: any) {
	useEffect(() => {
		const listener = (_e: any) => {
			handler();
		};

		window.addEventListener("resize", listener, true);

		return () => {
			window.removeEventListener("resize", listener, true);
		};
	}, [handler]);
}
