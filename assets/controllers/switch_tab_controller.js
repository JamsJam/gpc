import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    
    static targets = [
        'container',
        'map'
    ];

    static value = {
        
    };

    pendingActions = [];


    async initialize(){
        this.component = await getComponent(this.element);
        this.executePendingActions()
    }


    handleTabClick(e){
        const selectMode = e.target.getAttribute('data-mode');
        console.log(selectMode,this.containerTarget.classList.contains(selectMode))
        
        if(!this.containerTarget.classList.contains(selectMode)){
            this.addPendingAction(()=>{
                this.changeMode(selectMode)
            })
        }
    }

    /**
     * Change le mode du composant
     * @param {string} mode le nouveau mode
     * 
     */
    async changeMode(mode){

        this.removeMap()
        await this.component.action('changeMode',{mode})
        
    }

    // mapTargetConnected(element){
    //     console.log('mapConnect',element)
    // }

    removeMap(){
        this.mapTarget.remove()
    }




    //* ============== pending Action from component
    
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
