<template>
    <div class="container">
        <div v-show="current_state_num !== 0" class="row">
            <div class="col-md-12">
                <div :class="['card back-black fore-gray-light', alertClass()]">
                    <div :class="['card-body text-center text-uppercase', font_size_class]" v-html="getInstructionHtml()"></div>
                </div>
            </div>
        </div>

        <!--Start Booking (State 0)-->
        <start-booking v-show="current_state_num === 0"
                       :font-size-class="font_size_class"
                       :current-instruction="current_instruction"></start-booking>

        <!--Choose Passenger Count (state 1)-->
        <transition name="fade">
        <choose-passenger-count v-show="current_state_num === 1"
                                :max-tickets-allowed="max_tickets_allowed"
                                :font-size-class="font_size_class"
                                :current-instruction="current_instruction"></choose-passenger-count>
        </transition>

        <!--Select Outbound / Return Journey (state 2)-->
        <choose-journeys v-show="current_state_num === 2"
                         :passenger-count="passenger_data.passenger_count"
                         :available-journeys="availableJourneys"
                         :date-today="dateToday"
                         :font-size-class="font_size_class"
                         :current-instruction="current_instruction"></choose-journeys>

        <!--Enter Passenger Names (state 3)-->
        <enter-passenger-names v-show="current_state_num === 3"
                               :passenger-count="passenger_data.passenger_count"
                               :font-size-class="font_size_class"
                               :current-instruction="current_instruction"></enter-passenger-names>

        <!--Finalize Booking (state 4)-->
        <finalize-booking v-show="current_state_num === 4"
                          :passenger-data="passenger_data"
                          :font-size-class="font_size_class"
                          :date-today="dateToday"
                          :current-instruction="current_instruction"></finalize-booking>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                font_size_class: 'font-size-min',
                current_instruction: '',
                current_state_num: 0,
                hide_all: false,
                alert_active: false,
                alert_html: '',
                instructions: {
                    0: "Please <strong class='fore-white'>Click Here</strong> to book tickets for today's train journeys",
                    1: "Please select the amount of tickets you would like to book. <br><span class='fore-white'>(maximum of 4 per booking)</span>",
                    2: "Please select your <strong class='fore-white'>Outbound</strong> and <strong class='fore-white'>Return</strong> journeys from the options below",
                    3: "Please enter the <strong class='fore-white'>Passenger Names</strong> for this journey.",
                    4: "Please confirm the <strong class='fore-white'>Booking Details</strong> and choose a ticket delivery method from the options below.",
                    5: "Thank you for traveling on <strong class='fore-white'>The Heritage Train Line</strong>. <br>Enjoy your journey with us today."
                },
                passenger_data: {
                    passenger_count: 1,
                    passenger_names: {
                        1: '',
                        2: '',
                        3: '',
                        4: '',
                    },
                    selected_outbound: null,
                    selected_return: null,
                },
                max_tickets_allowed: 4,
                advancing_state: false,
            }
        },
        props: ['availableJourneys', 'dateToday'],
        mounted() {
            const self = this;
            self.setCurrentInstruction();

            EventBus.$on('alert.update', function(data) {
                self.alert_active = true;
                self.alert_html = data.alert_html;
            });

            EventBus.$on('state.progress', function(data) {
                console.log('Received state.progress event');
                console.log(data);
                self.progressToNextState(data.state_reference, data.state_values);
            });
        },
        methods: {
            // Sets the instruction at top of page for the current state
            setCurrentInstruction: function() {
                this.current_instruction = this.instructions[this.current_state_num];
            },
            alertClass: function() {
                return this.alert_active ? 'alert-active' : '';
            },
            // Go to the next state in the sequence
            progressToNextState: function(state_reference = null, state_values = null) {
                const self = this;

                // No state data is required, progress to next state.
                if(state_reference === null && state_values === null) {
                    self.advanceState();
                    return true;
                }

                if(state_reference === 'passenger.count' && self.validateState(state_reference, state_values)) {
                    self.passenger_data.passenger_count = state_values;
                    self.advanceState();
                }

                if(state_reference === 'journeys.chosen') {
                    console.log(state_values);
                    self.passenger_data.selected_outbound = state_values.outbound_object;
                    self.passenger_data.selected_return = state_values.return_object;
                    self.advanceState();
                }

                if(state_reference === 'passenger.names') {
                    self.passenger_data.passenger_names = state_values;
                    self.advanceState();
                }

                // Tickets have been printed, reset the system.
                if(state_reference === 'booking.confirm.print') {
                    self.advanceState();

                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                }

            },
            // Validation logic for each state
            validateState: function(state_reference, state_values) {
                const self = this;

                console.log((state_values > 0 && state_values <= self.max_tickets_allowed));

                if(state_reference === 'passenger.count') {
                    return state_values > 0 && state_values <= self.max_tickets_allowed;
                }

                /*
                    More detailed validation would be added here in the final build
                    to ensure each state could advance correctly.
                 */

                return false;
            },
            getInstructionHtml() {
                const self = this;

                if (self.alert_active && self.alert_html !== '') {
                    return self.alert_html;
                }

                return self.current_instruction;
            },
            advanceState: function() {
                const self = this;

                // Protect against state moving multiple steps forward
                if(self.advancing_state) {
                    return false;
                }

                // Reset alerts
                self.alert_active = false;
                self.alert_html = '';

                self.advancing_state = true;
                setTimeout(function() {
                    self.current_state_num++;
                    self.setCurrentInstruction();
                }, 300);
                self.advancing_state = false;
            }
        }
    }
</script>
<style scoped>

    .alert-active {
        background-color: #dc1212!important;
        border-color: #dc1212!important;
        color: white!important;
    }

</style>