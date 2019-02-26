<template>
    <div class="row">
        <div v-for="count in max_tickets_allowed" class="col-md-3">
            <div @click="progressToNextState('passenger.count', count)" class="card card-button back-black fore-white">
                <div :class="['card-body text-center text-uppercase', fontSizeClass]" v-text="count"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StartBooking",
        props: ['fontSizeClass', 'currentInstruction'],
        data() {
          return {
              max_tickets_allowed: 4
          }
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            }
        }
    }
</script>
