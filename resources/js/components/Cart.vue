<template>
    <div class="card">
        <div class="card-body">
            <div v-if="!items.length" class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Your cart is empty! <i class="fa fa-frown-o"></i></h1>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, eveniet, maxime. Debitis eum ex harum laborum, officia quia similique. Architecto dolores esse facere impedit iste iure neque officia, pariatur sed!</p>
                    <a href="/" class="btn btn-primary">Shop now!</a>
                </div>
            </div>
            <table v-if="items.length" class="table table-hover table-bordered">
                <thead>
                <th></th>
                <th>Name</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Remove</th>
                </thead>
                <tbody>
                <tr v-for="(item,index) in items">
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
                                    @click="item.quantity++"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{toCurrency(item.product.price)}}</td>
                    <td>{{toCurrency(item.product.price * item.quantity)}}</td>
                    <td>
                        <button class="btn btn-danger w-100" @click="removeItem(index)">Remove</button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5" class="font-weight-bold text-right">TOTAL</td>
                    <td>{{toCurrency(totalPrice)}}</td>
                    <td>
                        <button class="btn btn-success w-100">Check Out</button>
                    </td>
                </tr>
                </tfoot>
            </table>
            <a href="/" class="btn btn-dark">GO BACK</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['ritems'],
        name: "Cart",
        data() {
            return {
                items: []
            }
        },
        mounted() {
            this.items = this.ritems
        },
        methods: {
            toCurrency(num) {
                return (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
            deduct(item, index) {
                if (item.quantity === 1) {
                    this.removeItem(index)
                }
                else {
                    item.quantity--
                }
            },
            removeItem(index) {
                axios.post('/cart/delete', {id: this.items[index].id})
                    .then(this.items.splice(index, 1))
            }
        },
        computed: {
            totalPrice() {
                return this.items.map(item => item.quantity * item.product.price).reduce((a, b) => a + b, 0)
            }
        },
        watch: {
            totalPrice() {
                axios.post('/cart/update', {items: this.items})
            }
        }
    }
</script>

<style scoped>

</style>