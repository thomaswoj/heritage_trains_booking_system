<template>
    <div class="row">
        <div v-for="count in maxTicketsAllowed" class="col-md-3">
            <div @click="progressToNextState('passenger.count', count)" class="card card-button back-black fore-white">
                <div :class="['card-body text-center text-uppercase', fontSizeClass]" v-text="count"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChoosePassengerCount",
        props: ['fontSizeClass', 'currentInstruction', 'maxTicketsAllowed'],
        data() {
          return {
              //
          }
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            }
        }
    }
</script>
