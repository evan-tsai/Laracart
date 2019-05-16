import notify, { ITEM_ADDED, ITEM_REMOVED, TYPE_ERROR } from './notify';

const state = {
    cart: [],
};

const getters = {
    cart(state) {
        return state.cart
    },

    countCart(state) {
        return state.cart.length;
    },

    countItems(state) {
        // Add all quantity
        return state.cart.reduce((acc, curr) => {
            return (acc ? acc.quantity : 0) + curr.quantity;
        }, 0);
    }
};

const actions = {
    toggleItem({ commit, state }, product) {
        const record = findProduct(state, product);

        if (record) {
            commit('REMOVE_ITEM', product);
        } else {
            commit('ADD_ITEM', product);
        }
    },

    decrement({ commit, state }, product) {
        const record = findProduct(state, product);

        if (record) {
            commit('DECREMENT', record);
            if (record.quantity === 0) {
                commit('REMOVE_ITEM', product);
            }
        }
    },

    submit({ commit, state }, form) {
        form.append('cart', JSON.stringify(state.cart));

        axios.post('/laracart/order', form)
        .then((response) => {
            commit('CLEAR_CART');
            if (response.data.html) {
                // Auto submit form

                document.open();
                document.write(response.data.html);
                document.close();
            } else {
                window.location.href = response.data.redirect;
            }
        })
        .catch((error) => {
            notify(error, TYPE_ERROR);
        });
    }
};

const mutations = {
    ADD_ITEM(state, product) {
        const record = findProduct(state, product);

        if (!record) {
            state.cart.push({...product, quantity: 1});
            notify(ITEM_ADDED);
        } else {
            record.quantity++;
        }
    },

    REMOVE_ITEM(state, product) {
        const record = findProduct(state, product);

        if (record) {
            state.cart = state.cart.filter(item => item !== record);
            notify(ITEM_REMOVED);
        }
    },

    DECREMENT(state, record) {
        record && record.quantity--;
    },

    SET_QUANTITY(state, { product, quantity }) {
        const record = findProduct(state, product);

        if (record) {
            record.quantity = quantity;
        }
    },

    CLEAR_CART(state) {
        state.cart = [];
    },
};

const findProduct = ({ cart }, product) => {
    return cart.find(item => item.id === product.id);
};

export default {
    state,
    getters,
    actions,
    mutations,
};
