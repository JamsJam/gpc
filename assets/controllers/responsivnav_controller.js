import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    // static targets = ['desk', 'mobile']
    static values = {
        'isMobile' : {type:Boolean, default: true}
    }

    async initialize() {
        this.component = await getComponent(this.element);
        console.log("Initialized component:", this.component,window.innerWidth < 768 );
        this.component.action('setMobile', { a : window.innerWidth<768  })
        this.component.render()
        
        // this.component.on('render:finished', (component) => {
        //     // do something after the component re-renders
        //     // component.set('isMobile', true);
        //     console.log(component) //-> return []
        // });

    }
    
    
    connect(){
        console.log('connect')
        // this.setMobileValue()
    }
    
    setMobileValue(){

        
        // this.setMobileBreakpoint(this.component, 768, current)
        this.component.action('setMobile', { a : window.innerWidth<768  })
        this.component.render()
    }

    isMobileValueChanged(current,old){

        if(current != old){

            console.log('change',current, old, window.innerWidth)
            this.setMobileBreakpoint(this.component, 768, current)
        }
    }


    setMobileBreakpoint(component, breakpoint,isMobile){
        // component.set('loading', true)
        // 
        component.action('setMobile', { a : window.innerWidth < breakpoint  })
        
        // component.set('loading', false)
        // 
    }




}
