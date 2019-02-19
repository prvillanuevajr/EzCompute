<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h1 v-if="!average_ratings" class="font-weight-bold">No reviews yet!</h1>
                            <div v-if="average_ratings" class="flex-column">
                                <h1 class="text-center">{{average_ratings}}</h1>
                                <span><star-rating :star-size="30"
                                                   v-model="average_ratings"
                                                   :increment=".1" read-only
                                                   :show-rating="false"></star-rating></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reviews_section">
                    <transition-group name="fade" tag="div">
                        <div v-for="(rating,index) in ratings" class="card mb-3" :key="rating.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img width="64" height="64" src="https://image.ibb.co/jw55Ex/def_face.jpg"
                                             class="img img-rounded img-fluid"/>
                                        <p class="text-secondary text-center">{{Ago(rating.created_at)}}</p>
                                    </div>
                                    <div class="col-md-10">
                                        <p>
                                            <a class="float-left"
                                               href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>{{rating.user.name}}</strong></a>
                                            <span class="float-right"><star-rating :star-size="15"
                                                                                   v-model="rating.rating"
                                                                                   :increment=".5" read-only
                                                                                   :show-rating="false"></star-rating></span>
                                        </p>
                                        <div class="clearfix"></div>
                                        <p>{{rating.comment}}</p>
                                        <p>
                                            <button v-if="rating.user.id == user_id"
                                                    @click="delete_review(rating,index)"
                                                    class="float-right btn btn-danger ml-2">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </div>
                <template v-if="user.email && !user.is_admin">
                    <hr>
                    <h3 class="font-weight-bold">Rate this product</h3>
                    <div>
                        <div class="form-group">
                            <star-rating v-model="rate" :increment=".5" :star-size="30"></star-rating>
                        </div>
                        <div class="form-group">
                            <textarea v-model="comment" class="form-control" rows="3"></textarea>
                        </div>
                        <button @click="submit_review" class="btn btn-primary">submit</button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['product', 'prop_ratings'],
        data() {
            return {
                ratings: [],
                user_id: user_id,
                user: user,
                rate: .5,
                comment: 'This is awesome.'
            }
        },
        mounted() {
            this.ratings = this.prop_ratings
        },
        methods: {
            submit_review() {
                if (this.rate && this.comment) {
                    Swal.fire({
                        title: 'Please wait',
                        type: "warning",
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    })
                    axios.post(`/ratings/${this.product.id}/store`, {rating: this.rate, comment: this.comment})
                        .then(({data}) => {
                            Swal.close()
                            this.ratings.unshift(data)
                        })
                        .catch(e => Swal.fire('Error', e.response.data.message, 'error'));
                    return false
                }
                Swal.fire('Invalid review')
            },
            delete_review(rating, index) {
                Swal.fire({
                    title: `Delete Review`,
                    text: 'Are you sure?',
                    type: "question",
                    showCancelButton: true,
                    preConfirm: () => {
                        axios.post(`/ratings/${rating.id}/delete`)
                            .then(({data}) => this.ratings.splice(index, 1))
                            .catch(e => Swal.fire('Error', e.response.data.message, 'error'));
                    }
                })
            },
            Ago(date) {
                return moment(date).fromNow()
            }
        },
        computed: {
            average_ratings() {
                return this.ratings.map(rating => rating.rating).reduce((a, b) => a + b, 0) / this.ratings.length;
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

    .fade-leave-active {
        position: absolute;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }

    .reviews_section {
        max-height: 300px;
        overflow-y: auto;
    }

</style>