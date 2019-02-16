<template>
    <div class="row">
        <div v-if="!products.length" class="col-lg-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">No result!</h1>
                    <p class="lead">No products found which match your selection</p>
                    <a href="/" class="btn btn-primary">Home</a>
                </div>
            </div>
        </div>
        <div v-if="brands.length" class="col-lg-2">
            <ul class="list-group">
                <li class="list-group-item font-weight-bold text-center">BRANDS</li>
                <template v-for="brand in brands">
                    <input type="checkbox" v-model="selected_brands" :value="brand" :id="brand"/>
                    <label class="list-group-item" :for="brand">{{brand}}</label>
                </template>
            </ul>
        </div>
        <div class="col-lg-9 offset-lg-1">
            <div class="row">
                <div v-for="product in filteredProducts" class="col-lg-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-cap1 card-img-top" :src="`/images/${product.image}`" alt="Card image cap">
                        <div class="card-body">
                            <strong>{{product.name}}</strong><br>
                            <strong>{{product.brand.name}}</strong>
                            <h3><span class="badge badge-danger">₱{{product.price}}</span></h3>
                        </div>
                        <a :href="`/shop/product?name=${product.name}&id=${product.id}`"
                           class="btn card-footer"><strong>Details</strong></a>
                    </div>
                </div>
            </div>
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