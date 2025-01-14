import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    
    static targets = [
        'flag1',
        'flag2',

    ]
    
    static values = {
        'isOpen': {type: Boolean, default: false}
    }

    initialize()
    {}

    connect()
    {}

    toggleOpen(){
        if (this.isOpenValue) {
            this.isOpenValue = !this.isOpenValue
            this.flag1Target.classList.add('open')
            this.flag2Target.classList.add('open')
            
        } else {
            this.isOpenValue = !this.isOpenValue
            this.flag1Target.classList.remove('open')
            this.flag2Target.classList.remove('open')
            
        }
    }



}
