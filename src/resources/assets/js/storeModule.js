const state = {
    cart: [],
};

const getters = {
    countCart: state => {
        return state.cart.length;
    },
};

const actions = {};

const mutations = {
    ADD_TO_CART: (state, product) => {
        state.cart.push(product);
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
