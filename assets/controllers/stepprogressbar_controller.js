import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        "progress",
        "circle",
        "prev",
        "next"
    ];

    connect() {
        this.currentActive = 1;
        this.update();
    }

    next() {
        this.currentActive++;
        if (this.currentActive > this.circleTargets.length) {
            this.currentActive = this.circleTargets.length;
        }
        this.update();
    }

    prev() {
        this.currentActive--;
        if (this.currentActive < 1) {
            this.currentActive = 1;
        }
        this.update();
    }

    update() {
        this.circleTargets.forEach((circle, index) => {
            if (index < this.currentActive) {
                circle.classList.add("progress-bar__circle--active");
            } else {
                circle.classList.remove("progress-bar__circle--active");
            }
        });

        const activeCircles = this.element.querySelectorAll(
            ".progress-bar__circle--active"
        );

        this.progressTarget.style.width =
            ((activeCircles.length - 1) / (this.circleTargets.length - 1)) * 100 + "%";

        // Handle disabling of prev/next buttons
        if (this.currentActive === 1) {
            this.prevTarget.disabled = true;
        } else if (this.currentActive === this.circleTargets.length) {
            this.nextTarget.disabled = true;
        } else {
            this.prevTarget.disabled = false;
            this.nextTarget.disabled = false;
        }
    }
}
