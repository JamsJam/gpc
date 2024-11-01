import { Controller } from '@hotwired/stimulus';


/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['datepicker']
    



    connect() {
        console.log('Flatpickr connected');
        this.initializeDatePicker();
    }

    initializeDatePicker() {
        // Initialisation de Flatpickr sur le target 'datepicker'
        flatpickr('#trip_periode',{
            mode: "range",
            minDate: "today",
            dateFormat: "d-m-Y",
            // disable: [
            //     function(date) {
            //         // disable every multiple of 8
            //         return !(date.getDate() % 8);
            //     }
            // ]
        })
    
    }
}
