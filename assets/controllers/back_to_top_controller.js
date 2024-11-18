import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    initialize() {
        this.intersectionObserver = new IntersectionObserver(entries => this.processIntersectionEntries(entries))
      }
    
      connect() {
        this.intersectionObserver.observe(document.querySelector('.header'))

      }
    
      disconnect() {
        this.intersectionObserver.unobserve(document.querySelector('.header'))
      }
    
      // Private
    
      processIntersectionEntries(entries) {
        entries.forEach(entry => {
          this.element.classList.toggle(this.data.get("class"), entry.isIntersecting)
        })
      }
    
    
}
