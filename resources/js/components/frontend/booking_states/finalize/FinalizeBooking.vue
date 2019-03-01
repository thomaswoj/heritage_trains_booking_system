<template>
    <div id="finalize-booking-container">

        <div class="row">
            <div class="col-md-12">
                <div class="card back-black fore-gray-light">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]"><strong class="fore-white">{{ currentLanguagePack['passengers'] }}:</strong> {{ getPassengerList() }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <ticket-card :date-today="dateToday"
                             :journey="passengerData.selected_outbound"
                             :title="'Outbound'"
                             :is-outbound="true"
                             :current-language-pack="currentLanguagePack"
                             :passenger-name="passengerData.passenger_names[1]"></ticket-card>
            </div>
            <div class="col-md-6">
                <ticket-card :date-today="dateToday"
                             :journey="passengerData.selected_return"
                             :title="'Return'"
                             :is-outbound="false"
                             :current-language-pack="currentLanguagePack"
                             :passenger-name="passengerData.passenger_names[1]"></ticket-card>
            </div>
        </div>

        <div class="row" style="justify-content: space-between;">
            <cancel-booking :font-size-class="fontSizeClass"
                            :current-language-pack="currentLanguagePack"></cancel-booking>
            <div class="col-md-4">
                <div @click="progressToNextState('booking.confirm.print')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">{{ currentLanguagePack['print_tickets'] }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div @click="progressToNextState('booking.confirm.email')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">{{ currentLanguagePack['email_tickets'] }}</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "FinalizeBooking",
        props: [
            'fontSizeClass',
            'currentInstruction',
            'passengerData',
            'dateToday',
            'currentLanguagePack'
        ],
        data() {
          return {
              //
          }
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                const self = this;

                // Create the booking and print tickets!
                if(!self.createBookingAjax()) {
                    return false;
                }

                // Advance the state
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            },
            // Ajax the selected journeys and passenger data to be saved in database
            createBookingAjax: function() {
                const self = this;

                axios.post('/booking/store', {
                    passengerData: self.passengerData
                    })
                    .then(function(response) {

                        // Download tickets on success
                        if(response.data.status === 'success') {
                            window.open(window.url + '/tickets/download?' + response.data.download_string);
                            return true;
                        }

                        if(response.data.status === 'error') {
                            // Errors would be handled here by showing an error message to the user and instructing them to either restart the booking or ask a staff member for assistance.
                            return false;
                        }
                    });

                return true;
            },
            // Return passenger list as a string (e.g. Tom / James / Sarah)
            getPassengerList() {
                const self = this;
                var list = '';
                for(var i in self.passengerData.passenger_names) {
                    var name = self.passengerData.passenger_names[i];
                    if(name != '') {
                        list += (i != 1 ? ' / ' : '') + self.passengerData.passenger_names[i];
                    }
                }
                return list;
            },
        }
    }
</script>
