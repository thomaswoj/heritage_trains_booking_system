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
                bootbox.confirm({
                    message: "Are you sure you want to cancel the current booking?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-lg btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-lg btn-cancel'
                        }
                    },
                    callback: function (result) {
                        if(result) {
                            location.reload();
                        }
                    }
                });
            }
        }
    }
</script>
