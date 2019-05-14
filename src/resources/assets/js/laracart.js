import CartComponent from './components/CartComponent';
import cartModule from './storeModule';


export default function install(Vue) {
    Vue.component('cart-component', CartComponent);
}

export { cartModule };
