<template>
    <div id="journey-state-container">

        <div class="row">
            <div class="col-md-6">
                <div class="card text-uppercase">
                    <div class="card-header back-black fore-white">
                        {{ currentLanguagePack['outbound'] }} / {{ dateToday }}
                        <br>
                        {{ currentLanguagePack['from'] }} <strong>Station</strong> {{ currentLanguagePack['to'] }} <strong>Engine Shed</strong>
                    </div>
                    <!-- Specific inline-styling has been used in this case
                        as unable to achieve desired effect programaticaly-->
                    <div class="card-header back-black fore-white">
                        <span style="margin-left: 0px;">{{ currentLanguagePack['departure'] }}</span>
                        <span style="margin-left: 35px;">{{ currentLanguagePack['arrival'] }}</span>
                        <span style="margin-left: 30px;">{{ currentLanguagePack['train'] }}</span>
                        <span style="margin-left: 35px;">{{ currentLanguagePack['seats_left'] }}</span>
                    </div>
                    <journey-table :reference="'journey.outbound'"
                                   :selected-journey="selected_outbound"
                                   :selected-id="selected_outbound_id"
                                   :passenger-count="passengerCount"
                                   :current-language-pack="currentLanguagePack"
                                   :journeys="availableJourneys.today_outbound"></journey-table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-uppercase">
                    <div class="card-header back-black fore-white">
                        {{ currentLanguagePack['return'] }} / {{ dateToday }}
                        <br>
                        {{ currentLanguagePack['from'] }} <strong>Engine Shed</strong> {{ currentLanguagePack['to'] }} <strong>Station</strong>
                    </div>
                    <!-- Specific inline-styling has been used in this case
                        as unable to achieve desired effect programaticaly-->
                    <div class="card-header back-black fore-white">
                        <span style="margin-left: 0px;">{{ currentLanguagePack['departure'] }}</span>
                        <span style="margin-left: 35px;">{{ currentLanguagePack['arrival'] }}</span>
                        <span style="margin-left: 30px;">{{ currentLanguagePack['train'] }}</span>
                        <span style="margin-left: 35px;">{{ currentLanguagePack['seats_left'] }}</span>
                    </div>
                    <journey-table :reference="'journey.return'"
                                   :selected-journey="selected_return"
                                   :selected-id="selected_return_id"
                                   :passenger-count="passengerCount"
                                   :current-language-pack="currentLanguagePack"
                                   :journeys="availableJourneys.today_return"></journey-table>
                </div>
            </div>
        </div>

        <div class="row" style="justify-content: space-between;">
            <cancel-booking :font-size-class="fontSizeClass"
                            :current-language-pack="currentLanguagePack"></cancel-booking>
            <div class="col-md-3">
                <div @click="progressToNextState('journeys.chosen')" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', fontSizeClass]">{{ currentLanguagePack['continue'] }}</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ChooseJourneys",
        props: [
            'fontSizeClass',
            'currentInstruction',
            'passengerCount',
            'dateToday',
            'availableJourneys',
            'currentLanguagePack'
        ],
        data() {
          return {
              selected_outbound_id: null,
              selected_return_id: null,
              selected_outbound: null,
              selected_return: null,
          }
        },
        mounted() {
            const self = this;

            EventBus.$on('journey.outbound.selected', function(data) {
                self.setOutbound(data.id, data.index);
            });

            EventBus.$on('journey.return.selected', function(data) {
                self.setReturn(data.id, data.index);
            });

        },
        computed: {
            //
        },
        methods: {
            progressToNextState: function(state_reference = null) {
                const self = this;

                if(self.selected_outbound === null || self.selected_return === null) {
                    EventBus.$emit('alert.update', { alert_html: '' });
                    return false;
                }

                const state_values = {
                    outbound_object: self.selected_outbound,
                    return_object: self.selected_return
                };

                EventBus.$emit('state.progress', {
                    state_reference: state_reference,
                    state_values: state_values
                })
            },
            // Used to toggle the selected journey
            setOutbound: function(id, index) {
                const self = this;
                if(self.selected_outbound_id === id) {
                    self.selected_outbound_id = null;
                    self.selected_outbound    = null;
                } else {
                    self.selected_outbound_id = id;
                    self.selected_outbound    = self.availableJourneys.today_outbound[index];
                }
                return true;
            },
            // Used to toggle the selected journey
            setReturn: function(id, index) {
                const self  = this;
                if(self.selected_return_id === id) {
                    self.selected_return_id = null;
                    self.selected_return    = null;
                } else {
                    self.selected_return_id = id;
                    self.selected_return    = self.availableJourneys.today_return[index];
                }
                return true;
            }
        }
    }
</script>

<style scoped>

</style>

