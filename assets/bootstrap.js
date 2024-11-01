import { startStimulusApp } from '@symfony/stimulus-bundle';
import flatpickr from 'flatpickr';

const app = startStimulusApp();
app.register('flatpickr', flatpickr);
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
