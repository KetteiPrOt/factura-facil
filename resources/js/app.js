import './bootstrap';
import {
    Collapse,
    initTWE,
} from "tw-elements";
import invoiceComponent from './components/invoice-component';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// import Plugin from '@plugin/alpine-plugin'

// Alpine.plugin(Plugin)

Alpine.data('InvoiceComponent', invoiceComponent);
 
Livewire.start()

initTWE({ Collapse });
