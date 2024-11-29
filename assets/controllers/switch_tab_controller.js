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

    


    pendingActions = [];


    async initialize(){
        this.component = await getComponent(this.element);
        this.addPendingAction(()=>{
            this.setComponentListener(this.component)
        })
        this.executePendingActions()
    }


    /**
     * gere le clic sur une tab
     * @param {*} event.target
     */
    handleTabClick({target}){
        const selectMode = target.getAttribute('data-mode');
        document.querySelectorAll('.marker__container').forEach(element => {
            element.classList.remove('focus')
        });
        
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

        await this.removeMap()
        await this.component.action('changeMode',{mode})
        
    }

    /**
     * remove map from html
     * @return {void}
     */
    async removeMap() {
        if (this.hasMapTarget) {
            // Ajouter une classe pour l'animation CSS
            this.mapTarget.classList.add('fade-out');
    
            // Attendre la fin de l'animation avant de continuer
            const animationDuration = 250; // Durée de l'animation en m
            await new Promise((resolve) => setTimeout(resolve, animationDuration));
    
            // Supprimer la carte après l'animation
            this.mapTarget.remove();
        }
    }

    /**
     *  Set TwigComponents Eventlistener
     * @param {*} twigComponent
     * @returns {void}
     */
    setComponentListener(twigComponent)
    {
        twigComponent.on('loading.state:started', (html, backendRequest) => {
            if(backendRequest.actions[0] == "changeMode"){
                html.querySelector("#mapLoading").style.display = "block"
            }
        });
        twigComponent.on('loading.state:finished', (html) => {
            html.querySelector("#mapLoading").style.display = "none"
        });
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
