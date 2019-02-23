<template>
    <div class="card flex-row flex-wrap">
        <div class="card-header border-0">
            <img width="64" height="64" src="/images/orderplaced.png" alt="">
        </div>
        <div class="card-block p-2">
            <h4>An Order was placed</h4>
            <p>{{toCurrency(notif.data.total_price)}}</p>
        </div>
        <div class="w-100"></div>
        <div class="card-footer w-100 text-muted d-flex justify-content-end">
            {{Ago(notif.data.created_at)}}
            <button v-if="!notif.read_at" @click="markAsRead(notif.id)"
                    class="footer_notif_btn fa btn btn-primary fa-eye"> Mark as read
            </button>
            <a :href="`/orders/${notif.data.id}`" class="footer_notif_btn fa btn btn-primary fa-arrow-right"></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notif'],
        methods: {
            toCurrency: topeso,
            Ago(date) {
                return Moment(date).format('L');
            },
            markAsRead(id) {
                this.$emit('notif_read');
            }
        }
    }
</script>

<style scoped>

</style>