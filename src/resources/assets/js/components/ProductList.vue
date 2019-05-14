<template>
    <div>
        <div v-for="product in products">
            <ul >
                <li>{{ product.name }}</li>
                <li>{{ product.image_path }}</li>
                <li>{{ product.price }}</li>
                <li>{{ product.stock }}</li>
            </ul>
            <button @click.prevent="addToCart(product)">Add to cart</button>
        </div>
        <!--<div v-for="item in cart">-->
            <!--<span>{{ item }}</span>-->
        <!--</div>-->
    </div>
</template>

<script>
    import { mapMutations, mapGetters } from 'vuex';

    export default {
        name: "ProductList",

        data() {
            return {
                products: [],
            };
        },

        mounted() {
            this.getProducts();
        },

        computed: {
            ...mapGetters([
                'countCart'
            ]),
        },

        methods: {
            ...mapMutations([
                'ADD_TO_CART',
            ]),

            getProducts() {
                axios.get('/laracart/product').then((response) => {
                    this.products = response.data;
                }).catch((errors) => {
                    console.log(errors);
                });
            },

            addToCart(product) {
                this.ADD_TO_CART(product);
            }
        }
    }
</script>
