export function onDragLike(
	el: HTMLElement,
	elToMove: HTMLElement,
	fn: (e: Event, el: HTMLElement) => void,
) {
	let holdTimer: number | undefined = undefined;

	// duration in milliseconds to consider as a "hold"
	const holdDuration = 500;

	// Function to handle the "hold" action
	function handleHold(e: Event) {
		console.log("Held!");

		// Call the passed function with the event and element
		fn(e, el);

		// Ensure the timer is canceled after the hold is detected
		cancelHoldTimer();
	}

	// Function to start the hold timer
	function startHoldTimer(e: Event) {
		holdTimer = window.setTimeout(() => handleHold(e), holdDuration);
	}

	// Function to cancel the hold timer
	function cancelHoldTimer() {
		if (holdTimer !== undefined) {
			window.clearTimeout(holdTimer);
			holdTimer = undefined;
		}
	}

	// For desktop (mouse events)
	el.addEventListener("mousedown", startHoldTimer);
	el.addEventListener("mouseup", cancelHoldTimer);
	el.addEventListener("mouseleave", cancelHoldTimer);

	// For mobile (touch events)
	el.addEventListener("touchstart", startHoldTimer);
	el.addEventListener("touchend", cancelHoldTimer);
	el.addEventListener("touchcancel", cancelHoldTimer);
}
