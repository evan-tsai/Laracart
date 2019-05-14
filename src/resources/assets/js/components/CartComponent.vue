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
            ...mapMutations(['ADD_ITEM', 'REMOVE_ITEM']),

            ...mapActions(['toggleItem', 'decrement']),

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
            }
        }
    }
</script>
