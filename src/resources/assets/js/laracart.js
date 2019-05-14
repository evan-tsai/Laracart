import CartComponent from './components/CartComponent';
import storeModule from './storeModule';

export default function install(Vue, options = {}) {
    if (!options.store) console.warn('Please provide a store!!');

    Vue.component('cart-component', CartComponent);

    options.store.registerModule('cartModule', storeModule);
}
