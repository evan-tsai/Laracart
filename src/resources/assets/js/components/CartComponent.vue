<script>
    import { mapMutations, mapGetters } from 'vuex';

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
            ...mapGetters(['cart', 'countCart']),
        },

        methods: {
            ...mapMutations([
                'ADD_ITEM',
            ]),

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
            }
        }
    }
</script>
