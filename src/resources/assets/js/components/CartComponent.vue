<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex';

    export default {
        name: "CartComponent",

        props: {
            productId: {
                default: null,
            },

            requestProducts: {
                default: false,
            },
        },

        data() {
            return {
                product: {},
                products: [],
            };
        },

        mounted() {
            if (this.requestProducts) this.getProducts();
            if (this.productId) this.getProduct();
        },

        computed: {
            ...mapGetters(['cart', 'countCart', 'countItems']),
        },

        methods: {
            ...mapMutations(['ADD_ITEM', 'REMOVE_ITEM', 'SET_QUANTITY', 'CLEAR_CART']),

            ...mapActions(['toggleItem', 'decrement', 'submit']),

            getProduct() {
                axios.get(`/laracart/product/${this.productId}`).then((response) => {
                    this.product = response.data;
                }).catch((errors) => {
                    console.log(errors);
                });
            },

            getProducts() {
                axios.get('/laracart/product').then((response) => {
                    this.products = response.data;
                }).catch((errors) => {
                    console.log(errors);
                });
            },

            addItem(product) {
                this.ADD_ITEM(product);
            },

            removeItem(product) {
                this.REMOVE_ITEM(product);
            },

            toggle(product) {
                this.toggleItem(product);
            },

            subtract(product) {
                this.decrement(product);
            },

            setQuantity(product, quantity) {
                this.SET_QUANTITY({ product, quantity });
            },

            clearCart() {
                this.CLEAR_CART();
            },

            submitForm() {
                const form = document.querySelector('form');
                const formData = new FormData(form);

                this.submit(formData);
            }
        }
    }
</script>
