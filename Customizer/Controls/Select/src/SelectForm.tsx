/**
 * The select form (wpbf-select): one choice, or several (`multiple`, optionally with a limit), from a list that can be
 * searched and that may be grouped (the font families: font stacks, ~1,840 Google fonts, Premium's custom fonts).
 *
 * It replaces select2 and hands the setting exactly what select2 did:
 * - one choice: the option's id as text; "" when cleared;
 * - several: the chosen ids as a list in the order of the options (not the order they were picked). Ids the list doesn't
 *   have are dropped with the next change, as select2 only knew the options it showed.
 *
 * What it shows is the control's `shown` value, which follows the setting; the typography fields also change a variant
 * select's options and shown value from outside without touching its setting (`setChoices`, `showValue`).
 * The list is only drawn while it's open: a closed select costs a button.
 */
import type { KeyboardEvent as ReactKeyboardEvent } from "react";
import { useEffect, useLayoutEffect, useMemo, useRef, useState } from "@wordpress/element";
import { Value } from "wordpress__customize-browser/Value";
import { Notifications, ReactControlFormProps } from "../../Base/src/react-base";
import { SelectControlChoices, SelectControlParams, SelectControlValue, WpbfCustomizeSelectControl } from "./interface";

type Props = ReactControlFormProps<SelectControlValue, SelectControlParams>;

export type SelectOption = { id: string; text: string; disabled: boolean };

type Row = { group: string } | { option: SelectOption; nested: boolean; index: number };

/**
 * Every option of the choices (groups opened up), in their order. Ids as text, as the browser and select2 had them.
 */
export function flattenChoices(choices: SelectControlChoices | undefined): SelectOption[] {
	const options: SelectOption[] = [];

	for (const choice of choices ?? []) {
		if (Array.isArray(choice.children) && choice.children.length) {
			for (const child of choice.children) {
				options.push({ id: String(child.id), text: String(child.text ?? ""), disabled: !!child.disabled });
			}
		} else if (undefined !== choice.id && null !== choice.id) {
			options.push({ id: String(choice.id), text: String(choice.text ?? ""), disabled: !!choice.disabled });
		}
	}

	return options;
}

/**
 * A value as the list of chosen ids (a multiple select), or as the one chosen id.
 */
export function asList(value: SelectControlValue | undefined | null): string[] {
	if (Array.isArray(value)) return value.map(String);
	return "" === value || null === value || undefined === value ? [] : [String(value)];
}

export function asOne(value: SelectControlValue | undefined | null): string {
	if (Array.isArray(value)) return undefined === value[0] ? "" : String(value[0]);
	return null === value || undefined === value ? "" : String(value);
}

/**
 * Text for searching: without accents, in capitals (as select2 matched).
 */
function searchable(text: string): string {
	return text.normalize("NFD").replace(/[̀-ͯ]/g, "").toUpperCase();
}

/**
 * The rows of the open list: group labels and the options matching the search (a group shows when one of its options
 * matches).
 */
function listRows(choices: SelectControlChoices, term: string): Row[] {
	const search = searchable(term.trim());
	const matches = (text: string) => !search || searchable(text).includes(search);
	const rows: Row[] = [];
	let index = 0;

	for (const choice of choices) {
		if (Array.isArray(choice.children) && choice.children.length) {
			const children = flattenChoices(choice.children).filter((option) => matches(option.text));
			if (!children.length) continue;

			rows.push({ group: String(choice.text ?? "") });
			for (const option of children) rows.push({ option, nested: true, index: index++ });
		} else if (undefined !== choice.id && null !== choice.id) {
			const [option] = flattenChoices([choice]);
			if (matches(option.text)) rows.push({ option, nested: false, index: index++ });
		}
	}

	return rows;
}

/**
 * A wp.customize.Value as React state.
 */
function useCustomizeValue<T>(value: Value<T>): T {
	const [state, setState] = useState<T>(() => value.get());

	useEffect(() => {
		const follow = (to: T) => setState(to);

		value.bind(follow);
		setState(value.get());

		return () => {
			value.unbind(follow);
		};
	}, [value]);

	return state;
}

export default function SelectForm({ control: baseControl }: Props) {
	const control = baseControl as unknown as WpbfCustomizeSelectControl;
	const params = control.params;
	const isMulti = !!params.isMulti;
	const limit = isMulti && params.maxSelections > 0 ? params.maxSelections : 0;
	const inputId = `wpbf-control-input-${control.id}`;
	const listId = `wpbf-select-list-${control.id}`;
	const messages = params.messages ?? {};

	const choices = useCustomizeValue(control.choicesValue!);
	const shown = useCustomizeValue(control.shownValue!);
	const options = useMemo(() => flattenChoices(choices), [choices]);

	const [open, setOpen] = useState(false);
	const [above, setAbove] = useState(false);
	const [term, setTerm] = useState("");
	const [highlighted, setHighlighted] = useState(-1);

	const root = useRef<HTMLDivElement>(null);
	const trigger = useRef<HTMLButtonElement>(null);
	const search = useRef<HTMLInputElement>(null);
	const list = useRef<HTMLUListElement>(null);

	const chosen = isMulti ? asList(shown) : [asOne(shown)];
	const chosenOptions = options.filter((option) => chosen.includes(option.id));
	const single = isMulti ? undefined : options.find((option) => option.id === chosen[0]);
	const atLimit = limit > 0 && chosenOptions.length >= limit;

	const rows = useMemo(() => (open ? listRows(choices, term) : []), [open, choices, term]);
	const optionRows = rows.filter((row): row is Extract<Row, { option: SelectOption }> => "option" in row);

	/**
	 * Hand a value to the setting (and show it, also when the setting already has it: a typography variant select may
	 * show another value than its setting).
	 */
	const commit = (value: SelectControlValue) => {
		control.shownValue!.set(value);
		control.setting?.set(value);
	};

	// Chosen ids in the order of the options; ids the options don't have are dropped (select2 only knew its options).
	const inOptionOrder = (ids: string[]) => options.filter((option) => ids.includes(option.id)).map((option) => option.id);

	const choose = (option: SelectOption) => {
		if (option.disabled) return;

		if (!isMulti) {
			commit(option.id);
			close(true);
			return;
		}

		const ids = chosenOptions.map((item) => item.id);

		if (ids.includes(option.id)) {
			commit(inOptionOrder(ids.filter((id) => id !== option.id)));
		} else if (!atLimit) {
			commit(inOptionOrder([...ids, option.id]));
		}

		close(true);
	};

	const remove = (option: SelectOption) => {
		commit(inOptionOrder(chosenOptions.map((item) => item.id).filter((id) => id !== option.id)));
	};

	const clear = () => {
		commit(isMulti ? [] : "");
		close(false);
	};

	const openList = (startTerm = "") => {
		if (open) return;

		// Open upwards when there's more room above than below in the Customizer's scrolling pane.
		const box = root.current?.getBoundingClientRect();
		const pane = root.current?.closest(".wp-full-overlay-sidebar-content")?.getBoundingClientRect();

		if (box && pane) {
			const below = pane.bottom - box.bottom;
			setAbove(below < 260 && box.top - pane.top > below);
		}

		setTerm(startTerm);
		setOpen(true);
	};

	const close = (focusTrigger: boolean) => {
		setOpen(false);
		setTerm("");

		if (focusTrigger) (isMulti ? search.current : trigger.current)?.focus();
	};

	// Opening highlights the chosen option (or the first one); searching the first match.
	useEffect(() => {
		if (!open) return;

		const first = optionRows.find((row) => !row.option.disabled);
		const current = !term && !isMulti ? optionRows.find((row) => row.option.id === chosen[0]) : undefined;

		setHighlighted((current ?? first)?.index ?? -1);
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [open, term]);

	// The single select's search field takes the focus when the list opens.
	useLayoutEffect(() => {
		if (open && !isMulti) search.current?.focus();
	}, [open, isMulti]);

	// Keep the highlighted option in view.
	useLayoutEffect(() => {
		if (!open || !list.current) return;

		const item = list.current.querySelector<HTMLElement>(`[data-index="${highlighted}"]`);
		if (!item) return;

		const box = list.current;

		if (item.offsetTop < box.scrollTop) {
			box.scrollTop = item.offsetTop;
		} else if (item.offsetTop + item.offsetHeight > box.scrollTop + box.clientHeight) {
			box.scrollTop = item.offsetTop + item.offsetHeight - box.clientHeight;
		}
	}, [open, highlighted]);

	// Close on a click anywhere else.
	useEffect(() => {
		if (!open) return;

		const onDown = (e: MouseEvent) => {
			if (root.current && !root.current.contains(e.target as Node)) close(false);
		};

		document.addEventListener("mousedown", onDown, true);

		return () => document.removeEventListener("mousedown", onDown, true);
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [open]);

	const move = (step: number) => {
		const enabled = optionRows.filter((row) => !row.option.disabled);
		if (!enabled.length) return;

		const at = enabled.findIndex((row) => row.index === highlighted);
		const next = -1 === at ? (step > 0 ? 0 : enabled.length - 1) : Math.min(enabled.length - 1, Math.max(0, at + step));

		setHighlighted(enabled[next].index);
	};

	const onKeyDown = (e: ReactKeyboardEvent<HTMLElement>) => {
		if (!open) {
			if (["ArrowDown", "ArrowUp", "Enter"].includes(e.key) || (" " === e.key && !isMulti)) {
				e.preventDefault();
				openList();
			} else if (isMulti && "Backspace" === e.key && !term && chosenOptions.length) {
				// Backspace in an empty search removes the last choice (as select2 did).
				e.preventDefault();
				remove(chosenOptions[chosenOptions.length - 1]);
			} else if (!isMulti && 1 === e.key.length && !e.ctrlKey && !e.metaKey && !e.altKey) {
				// Typing on the closed select starts a search.
				e.preventDefault();
				openList(e.key);
			}
			return;
		}

		if ("ArrowDown" === e.key || "ArrowUp" === e.key) {
			e.preventDefault();
			move("ArrowDown" === e.key ? 1 : -1);
		} else if ("PageDown" === e.key || "PageUp" === e.key) {
			e.preventDefault();
			move("PageDown" === e.key ? 8 : -8);
		} else if ("Enter" === e.key) {
			e.preventDefault();
			const row = optionRows.find((item) => item.index === highlighted);
			// At the limit the list only shows the limit message (as select2 did).
			if (row && !atLimit) choose(row.option);
		} else if ("Escape" === e.key) {
			e.preventDefault();
			e.stopPropagation();
			close(true);
		} else if ("Tab" === e.key) {
			close(false);
		} else if (isMulti && "Backspace" === e.key && !term && chosenOptions.length) {
			e.preventDefault();
			remove(chosenOptions[chosenOptions.length - 1]);
		}
	};

	const activeId = open && highlighted > -1 ? `${listId}-${highlighted}` : undefined;

	const searchField = (
		<input
			ref={search}
			className="wpbf-select-search"
			type="search"
			id={isMulti ? inputId : undefined}
			value={term}
			placeholder={isMulti && !chosenOptions.length ? params.placeholder : undefined}
			autoComplete="off"
			autoCorrect="off"
			autoCapitalize="none"
			spellCheck={false}
			role={isMulti ? "combobox" : "searchbox"}
			aria-expanded={isMulti ? open : undefined}
			aria-controls={open ? listId : undefined}
			aria-activedescendant={activeId}
			aria-autocomplete="list"
			onChange={(e) => {
				setTerm(e.target.value);
				if (!open) openList(e.target.value);
			}}
			onKeyDown={onKeyDown}
		/>
	);

	return (
		<>
			<header className="wpbf-control-header">
				{params.label && (
					<label className="customize-control-title" htmlFor={inputId}>
						{params.label}
					</label>
				)}

				{params.description && (
					<div
						className="customize-control-description description"
						dangerouslySetInnerHTML={{ __html: params.description }}
					/>
				)}
			</header>

			<Notifications control={control} />

			<div className="wpbf-control-form">
				<div
					ref={root}
					className={
						"wpbf-select" +
						(isMulti ? " wpbf-select-multiple" : " wpbf-select-single") +
						(open ? " is-open" + (above ? " is-above" : " is-below") : "") +
						(params.isClearable && chosenOptions.length ? " is-clearable" : "")
					}
				>
					{isMulti ? (
						<div className="wpbf-select-selection" onMouseDown={(e) => {
							if (e.target === e.currentTarget) {
								e.preventDefault();
								search.current?.focus();
								open ? close(false) : openList();
							}
						}}>
							<ul className="wpbf-select-chips">
								{chosenOptions.map((option) => (
									<li key={option.id} className="wpbf-select-chip" title={option.text}>
										<button
											type="button"
											className="wpbf-select-chip-remove"
											tabIndex={-1}
											aria-label={messages.remove ?? "Remove item"}
											onMouseDown={(e) => e.preventDefault()}
											onClick={() => remove(option)}
										>
											<span aria-hidden="true">×</span>
										</button>
										<span className="wpbf-select-chip-text">{option.text}</span>
									</li>
								))}
								<li className="wpbf-select-inline-search" onMouseDown={() => openList()}>
									{searchField}
								</li>
							</ul>
						</div>
					) : (
						<button
							ref={trigger}
							type="button"
							id={inputId}
							className="wpbf-select-selection"
							role="combobox"
							aria-haspopup="listbox"
							aria-expanded={open}
							aria-controls={open ? listId : undefined}
							onMouseDown={(e) => {
								e.preventDefault();
								trigger.current?.focus();
								open ? close(false) : openList();
							}}
							onKeyDown={onKeyDown}
						>
							{single ? (
								<span className="wpbf-select-value" title={single.text}>
									{single.text}
								</span>
							) : (
								<span className="wpbf-select-placeholder">{params.placeholder}</span>
							)}
							<span className="wpbf-select-arrow" aria-hidden="true">
								<b></b>
							</span>
						</button>
					)}

					{params.isClearable && chosenOptions.length > 0 && (
						<button
							type="button"
							className="wpbf-select-clear"
							tabIndex={-1}
							aria-label={messages.clear ?? "Remove all items"}
							onMouseDown={(e) => e.preventDefault()}
							onClick={clear}
						>
							<span aria-hidden="true">×</span>
						</button>
					)}

					{open && (
						<div className="wpbf-select-dropdown">
							{!isMulti && <div className="wpbf-select-search-box">{searchField}</div>}

							{atLimit ? (
								<ul className="wpbf-select-options">
									<li className="wpbf-select-message" role="alert">
										{messages.maxLimitReached}
									</li>
								</ul>
							) : (
								<ul ref={list} className="wpbf-select-options" id={listId} role="listbox" aria-multiselectable={isMulti || undefined}>
									{!optionRows.length && <li className="wpbf-select-message">{messages.noResults ?? "No results found"}</li>}
									{rows.map((row, i) =>
										"group" in row ? (
											<li key={"group-" + i} className="wpbf-select-group" role="presentation">
												{row.group}
											</li>
										) : (
											<li
												key={row.index}
												id={`${listId}-${row.index}`}
												data-index={row.index}
												className={
													"wpbf-select-option" +
													(row.nested ? " is-nested" : "") +
													(chosen.includes(row.option.id) ? " is-selected" : "") +
													(row.index === highlighted ? " is-highlighted" : "") +
													(row.option.disabled ? " is-disabled" : "")
												}
												role="option"
												aria-selected={chosen.includes(row.option.id)}
												aria-disabled={row.option.disabled || undefined}
												onMouseEnter={() => !row.option.disabled && setHighlighted(row.index)}
												onMouseDown={(e) => e.preventDefault()}
												onClick={() => choose(row.option)}
											>
												{row.option.text}
											</li>
										),
									)}
								</ul>
							)}
						</div>
					)}
				</div>
			</div>
		</>
	);
}
