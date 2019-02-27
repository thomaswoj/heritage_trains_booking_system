<template>
    <div class="col-md-3">
        <div @click="cancelBooking()" class="card card-button back-black fore-white">
            <div :class="['card-body text-center text-uppercase', fontSizeClass]">CANCEL BOOKING</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CancelBooking",
        props: ['fontSizeClass'],
        methods: {
            cancelBooking: function() {
                // Reload the page to reset all states
                location.reload();
            }
        }
    }
</script>
