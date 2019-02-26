<template>
    <div id="journey-state-container">

        <div class="row">
            <div class="col-md-6">
                <div class="card text-uppercase">
                    <div class="card-header back-black fore-white">Outbound - {{ dateToday }}</div>
                    <div class="card-body">
                        TODO LIST OUTBOUND + CHECKBOX
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-uppercase">
                    <div class="card-header back-black fore-white">Return - {{ dateToday }}</div>
                    <div class="card-body">
                        TODO LIST RETURN + CHECKBOX
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="justify-content: flex-end">
            <div class="col-md-3">
                <div @click="progressToNextState('passenger.names')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">Continue</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ChooseJourneys",
        props: ['fontSizeClass', 'currentInstruction', 'passengerCount', 'dateToday'],
        data() {
          return {

          }
        },
        mounted() {
            const self = this;
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            }
        }
    }
</script>

