import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static value={
        markers:{type:Array, default:[]},
        map:{type:Object,default:null}
    }

    initialize(){}

    connect() {
        this.element.addEventListener('ux:map:pre-connect', this._onPreConnect);
        this.element.addEventListener('ux:map:connect', this._onConnect);
        // this.element.addEventListener('ux:map:marker:before-create', this._onMarkerBeforeCreate);
        // this.element.addEventListener('ux:map:marker:after-create', this._onMarkerAfterCreate);
        // this.element.addEventListener('ux:map:info-window:before-create', this._onInfoWindowBeforeCreate);
        // this.element.addEventListener('ux:map:info-window:after-create', this._onInfoWindowAfterCreate);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side effects
        this.element.removeEventListener('ux:map:pre-connect', this._onPreConnect);
        // this.element.removeEventListener('ux:map:connect', this._onConnect);
        // this.element.removeEventListener('ux:map:marker:before-create', this._onMarkerBeforeCreate);
        // this.element.removeEventListener('ux:map:marker:after-create', this._onMarkerAfterCreate);
        // this.element.removeEventListener('ux:map:info-window:before-create', this._onInfoWindowBeforeCreate);
        // this.element.removeEventListener('ux:map:info-window:after-create', this._onInfoWindowAfterCreate);
    }

    _onPreConnect(event) {
        // The map is not created yet
        // You can use this event to configure the map before it is created
        // console.log(event.detail.option);
        event.target.classList.add('fade-in')
        setTimeout(() => {
            event.target.classList.add('visible'); // Finaliser l'animation
        }, 50); 
    }

    _onConnect(event) {
        // The map, markers and infoWindows are created
        // The instances depend on the renderer you are using
        console.log(event.detail.map);

        this.markersValue = event.detail.markers
        this.mapValue = event.detail.map
        

    }

    // _onMarkerBeforeCreate(event) {
    //     // The marker is not created yet
    //     // You can use this event to configure the marker before it is created
    //     // console.log(event.detail.definition);
    // }

    // _onMarkerAfterCreate(event) {
    //     // The marker is created
    //     // The instance depends on the renderer you are using
    //     // console.log(event.detail.marker);
    // }

    // _onInfoWindowBeforeCreate(event) {
    //     // The infoWindow is not created yet
    //     // You can use this event to configure the infoWindow before it is created
    //     // console.log(event.detail.definition);
    //     // The associated marker instance is also available
    //     // console.log(event.detail.marker);
    // }

    // _onInfoWindowAfterCreate(event) {
    //     // The infoWindow is created
    //     // The instance depends on the renderer you are using
    //     // console.log(event.detail.infoWindow);
    //     // The associated marker instance is also available
    //     // console.log(event.detail.marker);
    // }

    handleMarkerClick({detail:{content}}){
        // console.log(e,this.element._ux_map_instance)
        const {lat, long} = content

        this.element.markersValue.forEach(marker => {
            
            console.log(marker._latlng)
        });

        const selectedMarker = this.element.markersValue.find(marker=>{
            return marker._latlng.lat === parseFloat(lat) && marker._latlng.lng === parseFloat(long)
        })
        console.log(selectedMarker)
        selectedMarker.openPopup()
        this.element.mapValue.setView([lat, long], 11)

        // Vérifier si une instance de carte est associée
        // if (container._leaflet_id) {
        //     // Récupérer l'instance de la carte à partir de l'ID interne de Leaflet
        //     var map = L.Map._instances[container._leaflet_id];
        //     console.log(map); // Instance de la carte
        // }
    }

}