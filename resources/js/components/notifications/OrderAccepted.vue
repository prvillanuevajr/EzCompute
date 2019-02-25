<template>
    <div class="card flex-row flex-wrap">
        <div class="card-header border-0">
            <img width="64" height="64" src="/images/orderplaced.png" alt="">
        </div>
        <div class="card-block p-2">
            <h4>Your Order has been accepted</h4>
            <p>{{toCurrency(notif.data.total_price)}}</p>
        </div>
        <div class="w-100"></div>
        <div class="card-footer w-100 text-muted d-flex justify-content-end">
            {{Ago(notif.data.created_at)}}
            <button v-if="!notif.read_at" @click="markAsRead(notif.id)"
                    class="footer_notif_btn fa btn btn-primary fa-eye"> Mark as read
            </button>
            <button @click="gotolink" class="footer_notif_btn fa btn btn-primary fa-arrow-right"></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notif'],
        methods: {
            toCurrency: topeso,
            gotolink() {
                axios.patch(`/notifications/read`, {notif_id: this.notif.id})
                    .then(window.location.href = `/orders/${this.notif.data.id}`);
            },
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