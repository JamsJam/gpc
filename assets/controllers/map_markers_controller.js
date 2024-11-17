import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        "markerContainer",
        "map"
    ];

    initialize(){}

    getMarker({currentTarget}){
        let {lat, long} = currentTarget.dataset
        
        let selectedMarker = {
            lat,
            long
        }
        this.dispatchMarkerLocation(selectedMarker)



    }

    /**
     * dispatch custom event with marker location
     */
    dispatchMarkerLocation(markerLocation){
        this.dispatch("clickedMarker", { detail: { content: markerLocation} })
            
    }


}
