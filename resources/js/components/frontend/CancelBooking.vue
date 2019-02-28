<template>
    <div class="col-md-4">
        <div @click="cancelBooking()" class="card card-button back-black fore-white">
            <div :class="['card-body text-center text-uppercase', fontSizeClass]">{{ currentLanguagePack['cancel_booking'] }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CancelBooking",
        props: ['fontSizeClass', 'currentLanguagePack'],
        methods: {
            cancelBooking: function() {
                const self = this;
                bootbox.confirm({
                    message: self.currentLanguagePack['cancel_confirm'],
                    buttons: {
                        confirm: {
                            label: self.currentLanguagePack['yes'],
                            className: 'btn-lg btn-success'
                        },
                        cancel: {
                            label: self.currentLanguagePack['no'],
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
