import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import invoiceComponent from './components/invoice-component';
// import Plugin from '@plugin/alpine-plugin'

// Alpine.plugin(Plugin)

Alpine.data('InvoiceComponent', invoiceComponent);
 
Livewire.start()
