import { Controller } from "@hotwired/stimulus";

/*
 * The following line makes this controller "lazy": it won't be downloaded until needed
 * See https://github.com/symfony/stimulus-bridge#lazy-controllers
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
	static targets = ["container"];
	// ...

	initialize() {
		console.log("CROP CROP");
	}

	connect() {
		this.cropper = null;
	}

	loadImage(event) {
		const file = event.target.files[0];

		if (file) {
			const reader = new FileReader();

			// Charge l'image dans le reader
			reader.onload = (e) => {
				const imageUrl = e.target.result;
				this.displayImage(imageUrl);
			};

			reader.readAsDataURL(file);
		}
	}

	displayImage(imageUrl) {
		// Crée un nouvel élément <img> et l'affiche dans le conteneur
		const img = document.createElement("img");
		img.src = imageUrl;
		this.containerTarget.innerHTML = "";
		this.containerTarget.appendChild(img);
	}
}
