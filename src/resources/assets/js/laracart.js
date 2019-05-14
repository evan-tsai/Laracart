import ProductList from './components/ProductList';
import storeModule from './storeModule';

export default function install(Vue, options = {}) {
    if (!options.store) console.warn('Please provide a store!!');

    Vue.component('product-list', ProductList);

    options.store.registerModule('cartModule', storeModule)
}
