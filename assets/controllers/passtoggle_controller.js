import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        passShow:{type: Boolean, default: false},
    }
    static targets = [
        "passicon"
    ]
    
    connect(){}


    passToggle(){
        this.passShowValue = !this.passShowValue

        this.setFieldType()
        // this.setIconName()


    }

    setFieldType(){
        document.querySelector("#password").setAttribute('type', this.passShowValue ? "text" : "password")
    }

    // setIconName(){
    //     console.log(this.passiconTarget)
    //     this.passiconTarget.setAttribute('name', this.passShowValue ? "ion:eye-off-outline" : "solar:eye-outline")
    // }

    










    //ion:eye-off-outline ->close (true)
    //solar:eye-outline -> open (false)
}
