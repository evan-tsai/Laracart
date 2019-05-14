const state = {
    cart: [],
};

const getters = {
    cart: state => {
        return state.cart
    },

    countCart: state => {
        return state.cart.length;
    },

    countItems: state => {
        // Add all quantity
        return state.cart.reduce((acc, curr) => {
            return (acc ? acc.quantity : 0) + curr.quantity;
        }, 0);
    }
};

const actions = {};

const mutations = {
    ADD_ITEM: (state, product) => {
        const record = state.cart.find(item => item.id === product.id);

        if (!record) {
            state.cart.push({...product, quantity: 1});
        } else {
            record.quantity++;
        }
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
