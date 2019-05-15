# Laracart

A Shopping Cart Package built with Laravel & VueJS

## Setup
##### Add via composer (not published yet)
```bash
composer require evantsai/laracart
```

##### Add npm dependencies
```bash
npm install --save vue vuex vuex-persist axios
```
or
```bash
yarn add vue vuex vuex-persist axios
```

##### Publish Package assets
```bash
php artisan vendor:publish --provider="EvanTsai\Laracart\LaracartServiceProvider"
```
- Package will auto-add
    + routes to `routes/web.php`
    + assets to `resources/assets/vendor`
    + migrations to `database/migrations`
    + configs to `configs`


## Frontend

### Usage

app.js
```js
import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';
import Laracart, { cartModule } from '../assets/vendor/Laracart/js/laracart';

Vue.use(Vuex);
Vue.use(Laracart);

const store = new Vuex.Store({
    modules: { cartModule },
    plugins: [new VuexPersistence().plugin],
});

const app = new Vue({
    el: '#app',
    store,
});
```

##### Use cart-component as inline template

```html
<cart-component inline-template :request-products="true">
    <div>
        <div v-for="product in products">
            <ul >
                <li v-text="product.name"></li>
                <li v-text="product.image_path"></li>
                <li v-text="product.price"></li>
                <li v-text="product.stock"></li>
            </ul>
            <button @click.prevent="addItem(product)">Add to cart</button>
        </div>
    </div>
</cart-component>
```
#### Props

|        Name        |   Type  | Default |                            Description                         |
|--------------------|---------|---------|----------------------------------------------------------------|
| request-products   | Boolean | False   |If true, executes an api call to populate 'products' variable.  |
| product-id         | Integer | Null    |If filled, executes an api call to populate 'product' variable. |

#### Usable Variables

Variables can be used inside template

|    Name    |   Type  |            Description           |
|------------|---------|----------------------------------|
| products   | Array   | All products from API            |
| product    | Object  | Single Product                   |
| cart       | Array   | Current items in cart            |
| countCart  | Integer | Number of products in cart       |
| countItems | Integer | Quantity of all products in cart |


#### Functions

Bind functions to click events.

|           Name          |                           Description                            |
|-------------------------|------------------------------------------------------------------|
| addItem(product)        | Add item to cart if item doesn't exist, otherwise add quantity   |
| removeItem(product)     | Remove item from cart                                            |
| toggle(product)         | Remove item if exists, otherwise add item                        |
| subtract(product)       | Decrements item quantity by one                                  |
| setQuantity(product, 5) | Sets quantity to specified number (can be used with input event) |
| clearCart()             | Clears current cart                                              |
| submitForm()            | Submits first form inside cart-component                         |

#### Notifications

Can add custom notifications via `assets/vendor/Laracart/js/notify.js`, uses console by default.

