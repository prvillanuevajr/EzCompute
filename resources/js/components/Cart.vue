<template>
    <div class="card">
        <div v-if="loading" class="overlay">
            <i class="fa fa-spinner fa-2x fa-spin"></i>
        </div>
        <div class="card-body">
            <div v-if="!items.length" class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4 d-block text-center"><i class="fa fa-shopping-cart fa-2x"></i></h1>
                    <h1 class="display-4 d-block text-center font-weight-bold">Your cart is empty! <i
                            class="fa fa-frown-o"></i></h1>
                    <h4 class="d-block text-center font-weight-bold">
                        <p class="lead font-weight-bold">Looks like you have no items in your shopping cart.</p>
                        <p class="lead font-weight-bold">Click <a href="/shop">here</a> to continue shopping</p>
                    </h4>
                </div>
            </div>
            <table v-if="items.length" class="table table-hover table-borderless">
                <thead>
                <th></th>
                <th>Name</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Remove</th>
                </thead>
                <transition-group name="fade" tag="tbody">
                    <tr v-for="(item,index) in items" :key="item.id">
                        <td><img width="32" :src="`/images/${item.product.image}`" class="img-fluid" alt=""></td>
                        <td>{{item.product.name}}</td>
                        <td>{{item.product.brand.name}}</td>
                        <td class="text-center">
                            <div class="btn-group w-100">
                                <button class="btn btn-outline-danger" type="button"
                                        @click="deduct(item, index)"><i class="fa fa-minus"></i>
                                </button>
                                <div class="btn btn-dark">{{item.quantity}}</div>
                                <button class="btn btn-outline-primary" type="button"
                                        @click="add_qty(item)"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td>{{toCurrency(item.product.price)}}</td>
                        <td>{{toCurrency(item.product.price * item.quantity)}}</td>
                        <td>
                            <button class="btn btn-danger w-100" @click="removeItem(index)">Remove</button>
                        </td>
                    </tr>
                </transition-group>
                <tfoot>
                <tr>
                    <td colspan="5" class="font-weight-bold text-right"><h4 class="font-weight-bold">Total:</h4></td>
                    <td><h4 class="font-weight-bold">{{toCurrency(totalPrice)}}</h4></td>
                    <td>
                        <form action="/orders" method="post">
                            <input type="hidden" name="_token" v-model="cstftoken">
                            <button class="btn btn-success w-100">Check Out</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>
                        <a href="/" class="btn btn-primary w-100">Continue Shopping</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        props: ['ritems'],
        name: "Cart",
        data() {
            return {
                cstftoken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                items: [], loading: false
            }
        },
        mounted() {
            this.items = this.ritems
        },
        methods: {
            toCurrency(num) {
                return '₱' + (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            deduct(item, index) {
                if (item.quantity === 1) {
                    this.removeItem(index)
                }
                else {
                    this.loading = true
                    axios.post('/cart/update', {item: item, toAdd: -1})
                        .then(e => {
                            item.quantity = e.data.quantity
                            this.loading = false
                        })
                }
            },
            add_qty(item) {
                this.loading = true;
                axios.post('/cart/update', {item: item, toAdd: 1})
                    .then(e => {
                        item.quantity = e.data.quantity
                        this.loading = false
                    }).catch(e => {
                    Swal.fire(e.response.data,null,'warning')
                    this.loading = false
                })
            },
            removeItem(index) {
                this.loading = true
                axios.post('/cart/delete', {item: this.items[index]})
                    .then(e => {
                        this.items.splice(index, 1)
                        this.loading = false
                    })
            }
        },
        computed: {
            totalPrice() {
                return this.items.map(item => item.quantity * item.product.price).reduce((a, b) => a + b, 0)
            }
        },
    }
</script>

<style scoped>
    .fade-leave-to {
        opacity: 0;
        transform: translateX(300%);
    }

    .fade-move {
        transition: 1s;
    }

    .fade-leave-active {
        transition: all .3s;
        transform: translateX(300%);
    }

    .overlay {
        z-index: 2;
        position: absolute;
        background: rgba(0, 0, 0, .3);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
    }
</style>