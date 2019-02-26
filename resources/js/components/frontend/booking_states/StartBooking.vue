<template>
    <div class="row">
        <div class="col-md-12">
            <div @click="progressToNextState()" class="card card-button back-black fore-gray-light">
                <div :class="['card-body text-center text-uppercase', fontSizeClass]" v-html="currentInstruction"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StartBooking",
        props: ['fontSizeClass', 'currentInstruction'],
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            }
        }
    }
</script>
