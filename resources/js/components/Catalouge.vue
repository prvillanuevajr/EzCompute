<template>
    <div class="row">
        <div class="col-12">
            <div v-if="usp.get('category')" class="col-md-6 offset-md-3 d-md-flex mb-3">
                <div class="input-group mr-3 w-md-50">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="brand">Brand</label>
                    </div>
                    <select class="custom-select" id="brand" v-model="brand" @change="change_params">
                        <option selected>All</option>
                        <option v-for="brand in rbrands" >{{brand.name}}</option>
                    </select>
                </div>
                <div class="input-group w-md-50">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="sort">Sort By</label>
                    </div>
                    <select v-model="sort" class="form-control" id="sort" @change="change_params">
                        <option selected>Price, high to low</option>
                        <option>Price, low to high</option>
                        <option>Alphabetically, A-Z</option>
                        <option>Alphabetically, Z-A</option>
                    </select>
                </div>
            </div>
            <transition-group name="fade" class="d-flex flex-wrap justify-content-center" tag="div">
                <div v-for="product in products" class="mb-3 mr-sm-3" v-bind:key="product.name">
                    <div class="card border-dark" style="width: 18rem;">
                        <img height="200" class="card-cap1 card-img-top border-dark" :src="`/images/${product.image}`"
                             alt="Card image cap">
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
            <div v-if="products.length" class="m-4"><br><br><br><br><br><br></div>
            <infinite-loading :identifier="infiniteId" spinner="waveDots" @infinite="infiniteHandler">
                <!--<h2 class="font-weight-bold" slot="spinner">-->
                    <!--<i class="fa fa-spin fa-spinner"></i>-->
                    <!--Loading...-->
                <!--</h2>-->
                <div class="font-weight-bold" slot="no-more">No more products</div>
                <div class="font-weight-bold" slot="no-results">
                    <div class="col-lg-12">
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
                </div>
            </infinite-loading>
        </div>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

    const api = '//hn.algolia.com/api/v1/search_by_date?tags=story';

    export default {
        props: ['rbrands'],
        components: {
            InfiniteLoading,
        },
        data() {
            return {
                infiniteId: 1,
                brand: 'All',
                sort: 'Price, high to low',
                products: [],
                usp: new URLSearchParams(window.location.search),
            }
        },
        methods: {
            toCurrency(num) {
                return (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            infiniteHandler($state) {
                axios.post(`/shop/list`, {
                    offset: this.products.length,
                    brand: this.brand.match('All') ? null : this.brand,
                    category: this.usp.get('category'),
                    search: this.usp.get('search'),
                    sort: this.sort
                }).then(({data}) => {
                    if (data.length) {
                        this.products.push(...data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
            change_params() {
                this.products = [];
                this.infiniteId += 1;
            }
        },
    }
</script>

<style scoped>
    .fade-move {
        transition: transform .5s;
    }

    .fade-enter-active {
        transition: opacity .5s;
    }

    .fade-leave-active {
        position: absolute;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }
</style>