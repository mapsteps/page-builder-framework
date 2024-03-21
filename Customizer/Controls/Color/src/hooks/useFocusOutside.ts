import { useEffect } from "react";

export default function useFocusOutside(ref: any, handler: any) {
	useEffect(() => {
		const listener = (e: any) => {
			// Do nothing if the component hasn't been mounted.
			if (!ref.current) return;

			// Do nothing if the focused element is inside the ref or the ref itself.
			if (ref.current.contains(e.target)) return;

			handler();
		};

		document.addEventListener("focus", listener, true);

		return () => {
			document.removeEventListener("focus", listener, true);
		};
	}, [ref, handler]);
}
