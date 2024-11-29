import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    
    initialize(){

    }

    handleDetailRequest(event){
        event.preventDefault()
        // console.clear()
        const{id, mode} = this.element.dataset
        console.log(event.target)
        
        this.dispatch("openDetailModal", { detail: { content: {id, mode} } })
    }
}
