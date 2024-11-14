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
        isMobile : Boolean,
        isComponentInitialize: {type:Boolean, default:false},
        breackpoint : {type:Number, default:768}
        
    }

    pendingActions = [];

    async initialize() {
        this.component = await getComponent(this.element);
        this.isMobileValue = window.innerWidth < this.breackpointValue
        
        this.addPendingAction(()=>{

            this.setComponentListener(this.component)
            this.component.set('isMobile', this.isMobileValue )
            this.component.render()
        })
        
        this.executePendingActions(this.component)

        

    }
    

    turboload(){
        console.log('TURBOLOAD')
    }
    
    setMobileValue(e){

        const isMobile = window.innerWidth < 768
        console.log(isMobile, this.isMobileValue)
        if(this.isMobileValue !== isMobile){

            this.addPendingAction(()=>{
                    this.component.set('isMobile',  window.innerWidth < 768 )
                    this.component.render()
                })
        }

    }



        /**
     *  Set TwigComponents Eventlistener
     * @param {*} twigComponent
     * @returns {void}
     */
        setComponentListener(twigComponent)
        {

            // twigComponent.on('connect', (component) => {
            //     console.log("EVENT : Composant connecté")

            // });
            
            // twigComponent.on('disconnect', (component) => {
            //     console.log("EVENT : Composant déconnecté")
                
            // });
            
            
            //* events are only dispatched when the component is re-rendered (via an action or a model change).
            twigComponent.on('render:started', (html, backendResponse, shouldRender= { shouldRender: true}) => {
                console.log("EVENT : composant refresh start")
                // this.isComponentInitializeValue = true
                // this.executePendingActions(this.component)
                
            });
            
            
            // //* events are only dispatched when the component is re-rendered (via an action or a model change).
            // twigComponent.on('render:finished', (component) => {
            //     console.log("EVENT : composant refresh end")
                
            //     // this.handleReload()
            // });
            
            
            twigComponent.on('loading.state:started', (html, backendRequest) => {
                
                console.log("EVENT : composant loading start")
            });
            
            
            twigComponent.on('loading.state:finished', (html) => {
                
                console.log("EVENT : composant loading end ")
                console.log("EVENT : composant loading end ")
                
            });
            
            
            twigComponent.on('model:set', (model, value, component) => {
                
                console.log("EVENT SET : model " , model )
                console.log("EVENT SET : value " , value )
                console.log("EVENT SET isMobileValue " , this.isMobileValue )

                switch (model) {
                    case 'isMobile':
                        
                        this.isMobileValue = value
                        break;
                
                    default:
                        break;
                }

                console.log("EVENT SET NEW isMobileValue " , this.isMobileValue )
            });
        }



    //* ============== pending Action from component
    
    executePendingActions(component) {
        while (this.pendingActions.length > 0) {
            const action = this.pendingActions.shift();
            action();
        }
    }

    addPendingAction(action) {
        if (typeof this.component !== 'undefined' ) {
        // if (this.isComponentInitializeValue) {
            // console.log('instant exec',this.isComponentInitializeValue)
            action();
        } else {
            // console.log('defer exec',this.isComponentInitializeValue)
            this.pendingActions.push(action);
        }
    }
    //* ============== 


}
