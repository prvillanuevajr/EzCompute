<template>
    <div class="col-md-8 offset-md-2">
        <div class="d-flex">
            <div class="flex-grow-1">
                <div class="input-group">
                    <div class="input-group mr-3 align-self-start brand_select_div">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="brand">Brand</label>
                        </div>
                        <select class="form-control" id="brand" v-model="sortBy" @change="change_params">
                            <option selected>Date</option>
                            <option>Type</option>
                        </select>
                        <div class="input-group-append w-50">
                            <select class="form-control" v-model="sort" @change="change_params">
                                <option>Ascending</option>
                                <option>Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <i class="header_button fa fa-trash fa-2x nav-link" href="" data-toggle="tooltip"
                   title="Delete all"></i>
                <i class="header_button fa fa-envelope fa-2x" href="" data-toggle="tooltip"
                   title="Mark all as read"></i>
            </div>
        </div>
        <transition-group>
            <div v-for="(notif, index) in notifications" class="card mb-2" :key="notif.id">
                <component @notif_read="notif_read(notif.id,index)" :is="basename(notif.type)"
                           :notif="notif"></component>
            </div>
        </transition-group>
        <infinite-loading :identifier="infiniteId" spinner="waveDots" @infinite="infiniteHandler">
            <div class="font-weight-bold" slot="no-more">No more notifications</div>
            <div class="font-weight-bold" slot="no-results">
                <div class="col-lg-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h1 class="display-4 d-block text-center"><i class="fa fa-frown-o fa-2x"></i></h1>
                            <h1 class="display-4 d-block text-center font-weight-bold">Nothing found!</h1>
                            <h4 class="d-block text-center font-weight-bold">
                                <p class="lead font-weight-bold">No notifications for now</p>
                                <p class="lead font-weight-bold">If something happens will let you know.</p>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import OrderPlaced from './notifications/OrderPlaced';
    import OrderAccepted from './notifications/OrderAccepted';

    export default {
        components: {InfiniteLoading, OrderPlaced, OrderAccepted},
        data() {
            return {
                infiniteId: 1,
                sort: 'Ascending',
                sortBy: 'Date',
                notifications: [],
            }
        },
        methods: {
            notif_read(id, index) {
                Swal.fire({
                    title: 'Mark as Read?',
                    text: `Mark notification as read?`,
                    type: "question",
                    showCancelButton: true,
                    preConfirm: () => {
                        axios.patch(`/notifications/read`, {notif_id: id})
                            .then(this.notifications.splice(index, 1))
                    }
                })
            },
            toCurrency: topeso,
            Ago(date) {
                return Moment(date).fromNow()
            },
            basename(str) {
                return str.split('\\').reverse()[0];
            },
            infiniteHandler($state) {
                axios.post(`/notifications/list`, {
                    offset: this.notifications.length,
                    sort: this.sort,
                    sortBy: this.sortBy
                }).then(({data}) => {
                    if (data.length) {
                        this.notifications.push(...data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
            change_params() {
                this.notifications = [];
                this.infiniteId += 1;
            }
        }
    }
</script>

<style scoped>
    .header_button:hover {
        cursor: pointer;
    }

    label.input-group-text {
        box-shadow: 2px 2px 15px #3490dc;
    }
</style>