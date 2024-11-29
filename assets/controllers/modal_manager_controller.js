import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';
/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    

    pendingActions = [];


    async initialize(){
        this.component = await getComponent(this.element);
        this.addPendingAction(()=>{
            this.setComponentListener(this.component)
        })
        this.executePendingActions()
        console.log('init')
    }




    openModal(e){
        console.log(e)
        // this.element.classList.replace('close','open')
        const{mode, id} = e.detail.content
        this.addPendingAction(()=>{
            this.component.action('openModal',{'modalType':'product_modal','data': JSON.stringify([ mode, id])})
    
        })
    }

    closeModal(e){
        if(e.target.classList.contains('modal__container') || e.target.classList.contains('modal__close-container'))
        this.addPendingAction(()=>{
            this.component.action('closeModal',{})

            this.element.classList.replace('open', 'close')
        })
    }



    /**
     *  Set TwigComponents Eventlistener
     * @param {*} twigComponent
     * @returns {void}
     */
    setComponentListener(twigComponent)
    {
        // twigComponent.on('loading.state:started', (html, backendRequest) => {
        //     if(backendRequest.actions[0] == "changeMode"){
        //         html.querySelector("#mapLoading").style.display = "block"
        //     }
        // });
        // twigComponent.on('loading.state:finished', (html) => {
        //     html.querySelector("#mapLoading").style.display = "none"
        // });
    }


    //* ============== pending Action from component
    /**
     * execute remaining pending actions
     * @param {*} component 
     */
    executePendingActions(component) {
        while (this.pendingActions.length > 0) {
            const action = this.pendingActions.shift();
            action();
        }
    }

    /**
     * Ajoute une action en attente ou l'exécute immédiatement si le composant est initialisé.
     * @param {function} action Une fonction à exécuter immédiatement ou à mettre en attente.
     */
    addPendingAction(action) {
        if (typeof this.component !== 'undefined' ) {
            action();
        } else {
            this.pendingActions.push(action);
        }
    }
    //* ============== 



}
