<template>
    <div class="row">
        <div v-if="!products.length" class="col-lg-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4 d-block text-center"><i class="fa fa-frown-o fa-2x"></i></h1>
                    <h1 class="display-4 d-block text-center font-weight-bold">Nothing found!</h1>
                    <h4 class="d-block text-center font-weight-bold">
                        <p class="lead font-weight-bold">Sorry, but nothing matched your search terms.</p>
                        <p class="lead font-weight-bold">Please try again.</p>
                    </h4>
                </div>
            </div>
        </div>
        <div v-if="brands.length" class="col-md-3 col-lg-2 mb-sm-4">
            <ul class="list-group">
                <li class="list-group-item font-weight-bold text-center">BRANDS</li>
                <template v-for="brand in brands">
                    <input type="checkbox" v-model="selected_brands" :value="brand" :id="brand"/>
                    <label class="list-group-item" :for="brand">{{brand}}</label>
                </template>
            </ul>
        </div>
        <div class="col-md-9 col-lg-10">
            <transition-group name="fade" class="d-flex flex-wrap" tag="div">
                <div v-for="product in filteredProducts" class="mb-3 mr-md-3" v-bind:key="product.id">
                    <div class="card border-dark" style="width: 18rem;">
                        <img height="200" class="card-cap1 card-img-top border-dark" :src="`/images/${product.image}`" alt="Card image cap">
                        <div class="card-body">
                            <strong>{{product.name}}</strong><br>
                            <strong>{{product.brand.name}}</strong>
                            <h3><span class="badge badge-danger">₱{{toCurrency(product.price)}}</span></h3>
                        </div>
                        <a :href="`/shop/product?name=${product.name}&id=${product.id}`"
                           class="btn card-footer"><strong>Details</strong></a>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['products'],
        data() {
            return {selected_brands: []}
        },
        created() {
            // this.selected_brands = this.brands
        },
        methods: {
            toCurrency(num) {
                return (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        },
        computed: {
            brands() {
                return _.uniq(this.products.map(product => product.brand.name))
            },
            filteredProducts() {
                return this.products.filter(product => this.selected_brands.length ? this.selected_brands.includes(product.brand.name) : true)
            }
        }
    }
</script>

<style scoped>
    .fade-move {
        transition: transform .5s;
    }
    .fade-enter-active {
        transition: opacity .5s;
    }
    .fade-leave-active{
        position: absolute;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }

    div.sticky {
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 0 !important;
    }

    .list-group-item {
        user-select: none;
    }

    .list-group input[type="checkbox"] {
        display: none;
    }

    .list-group input[type="checkbox"] + .list-group-item {
        cursor: pointer;
    }

    .list-group input[type="checkbox"] + .list-group-item:before {
        content: "\2713";
        color: transparent;
        font-weight: bold;
        margin-right: 1em;
    }

    .list-group input[type="checkbox"]:checked + .list-group-item {
        background-color: #0275D8;
        color: #FFF;
    }

    .list-group input[type="checkbox"]:checked + .list-group-item:before {
        color: inherit;
    }

    .list-group input[type="radio"] {
        display: none;
    }

    .list-group input[type="radio"] + .list-group-item {
        cursor: pointer;
    }

    .list-group input[type="radio"] + .list-group-item:before {
        content: "\2022";
        color: transparent;
        font-weight: bold;
        margin-right: 1em;
    }

    .list-group input[type="radio"]:checked + .list-group-item {
        background-color: #0275D8;
        color: #FFF;
    }

    .list-group input[type="radio"]:checked + .list-group-item:before {
        color: inherit;
    }
</style>