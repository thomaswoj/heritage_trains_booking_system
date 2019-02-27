<template>
    <div id="finalize-booking-container">
        <div class="row">
            <div class="col-md-6">
                <ticket-card :date-today="dateToday"
                             :journey="passengerData.selected_outbound"
                             :title="'Outbound'"
                             :passenger-name="passengerData.passenger_names[1]"></ticket-card>
            </div>
            <div class="col-md-6">
                <ticket-card :date-today="dateToday"
                             :journey="passengerData.selected_return"
                             :title="'Return'"
                             :passenger-name="'test'"></ticket-card>
            </div>
        </div>

        <div class="row" style="justify-content: space-between;">
            <cancel-booking :font-size-class="fontSizeClass"></cancel-booking>
            <div class="col-md-3">
                <div @click="progressToNextState('journeys.chosen')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">Print Tickets</div>
                </div>
            </div>
            <div class="col-md-3">
                <div @click="progressToNextState('journeys.chosen')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">Email Tickets</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "FinalizeBooking",
        props: ['fontSizeClass', 'currentInstruction', 'passengerData', 'dateToday'],
        data() {
          return {
              //
          }
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            },
        }
    }
</script>
