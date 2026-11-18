/**
 * The form of the image type (see image-control.tsx): the chosen image with Remove, Default and Change buttons, or a
 * "No image selected" button that opens the media library.
 *
 * Saves the image's URL, attachment id or { id, url, width, height } (`saveAs`). Keeps the markup of the old control.
 */
import { useEffect, useState } from "@wordpress/element";
import { Notifications, ReactControlFormProps, useSettingValue } from "../../Base/src/react-base";
import { WpbfCustomizeImageControlParams, WpbfCustomizeImageControlValue, WpbfCustomizeImageSrc } from "./image-interface";

declare var wp: {
	media: any;
};

type Props = ReactControlFormProps<WpbfCustomizeImageControlValue, WpbfCustomizeImageControlParams>;

const EMPTY: WpbfCustomizeImageSrc = { id: 0, url: "", width: 0, height: 0 };

export default function ImageForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);

	// The last image picked here, with the smaller size the thumbnail shows.
	const [picked, setPicked] = useState<{ src: WpbfCustomizeImageSrc; thumb: string } | null>(null);

	// Images set by attachment id from elsewhere (a reset, a restored draft), once the media library returned them.
	const [fetched, setFetched] = useState<Record<number, WpbfCustomizeImageSrc>>({});

	const saved = (src: WpbfCustomizeImageSrc): WpbfCustomizeImageControlValue =>
		"array" === params.saveAs ? src : "id" === params.saveAs ? src.id : src.url;

	const isValueOf = (src: WpbfCustomizeImageSrc) => {
		if ("array" === params.saveAs) return "object" === typeof value && !!value && value.url === src.url;
		return ("id" === params.saveAs ? src.id : src.url) === value;
	};

	// The image of the current value.
	let src: WpbfCustomizeImageSrc;

	if (value === params.value) {
		src = params.valueSrc;
	} else if (picked && isValueOf(picked.src)) {
		src = picked.src;
	} else if (isValueOf(params.defaultSrc)) {
		src = params.defaultSrc;
	} else if ("object" === typeof value && value) {
		src = { ...EMPTY, ...value };
	} else if ("number" === typeof value || ("string" === typeof value && /^\d+$/.test(value))) {
		src = fetched[Number(value)] ?? { ...EMPTY, id: Number(value) };
	} else if ("string" === typeof value && value) {
		src = { ...EMPTY, url: value };
	} else {
		src = EMPTY;
	}

	const needsFetch = !src.url && src.id > 0 && !fetched[src.id];

	useEffect(() => {
		if (!needsFetch || !wp.media) return;

		const id = src.id;

		wp.media
			.attachment(id)
			.fetch()
			.then(() => {
				const image = wp.media.attachment(id).toJSON();
				setFetched((all) => ({ ...all, [id]: { id, url: image.url ?? "", width: image.width ?? 0, height: image.height ?? 0 } }));
			});
	}, [needsFetch, src.id]);

	const thumb = picked && isValueOf(picked.src) ? picked.thumb : src.url;
	const hasImage = !!src.url;

	const openMediaLibrary = () => {
		const frame = wp
			.media({ multiple: false })
			.open()
			.on("select", function () {
				const image = frame.state().get("selection").first().toJSON();
				const chosen: WpbfCustomizeImageSrc = { id: image.id, url: image.url, width: image.width, height: image.height };
				let chosenThumb = image.url;

				if (image.sizes) {
					chosen.url = image.sizes.full.url;
					chosenThumb = image.sizes.medium?.url ?? image.sizes.thumbnail?.url ?? image.sizes.full.url;
				}

				setPicked({ src: chosen, thumb: chosenThumb });
				setValue(saved(chosen));
			});
	};

	return (
		<>
			{!params.label && <Notifications control={control} />}

			<label>
				<span className="customize-control-title" dangerouslySetInnerHTML={{ __html: params.label ?? "" }} />

				{params.label && <Notifications control={control} />}

				{params.description && (
					<span
						className="description customize-control-description"
						dangerouslySetInnerHTML={{ __html: params.description }}
					/>
				)}
			</label>

			<div className="attachment-media-view">
				<div className={`thumbnail thumbnail-image${hasImage ? "" : " hidden"}`}>
					{hasImage && <img className="attachment-thumb" src={thumb} alt="" />}
				</div>

				<button
					type="button"
					className={`upload-button button-add-media${hasImage ? " hidden" : ""}`}
					onClick={openMediaLibrary}
				>
					{params.labels.placeholder}
				</button>

				<div className="actions">
					<button
						type="button"
						className={`button remove-button${hasImage ? "" : " hidden"}`}
						onClick={() => setValue(saved(EMPTY))}
					>
						{params.labels.remove}
					</button>{" "}

					{params.defaultSrc.url && (
						<button
							type="button"
							className={`button default-button${src.url === params.defaultSrc.url ? " hidden" : ""}`}
							onClick={() => setValue(saved(params.defaultSrc))}
						>
							{params.labels.default}
						</button>
					)}{" "}

					<button
						type="button"
						className={`button change-button${hasImage ? "" : " hidden"}`}
						onClick={openMediaLibrary}
					>
						{params.labels.change}
					</button>
				</div>
			</div>
		</>
	);
}
