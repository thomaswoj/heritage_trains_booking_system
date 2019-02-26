<template>
    <div class="container">
        <div v-show="current_state_num !== 0" class="row">
            <div class="col-md-12">
                <div class="card back-black fore-gray-light">
                    <div :class="['card-body text-center text-uppercase', font_size_class]" v-html="current_instruction"></div>
                </div>
            </div>
        </div>

        <!--Start Booking (State 0)-->
        <start-booking v-show="current_state_num === 0"
                       :font-size-class="font_size_class"
                       :current-instruction="current_instruction"></start-booking>

        <!--Choose Passenger Count (state 1)-->
        <choose-passenger-count v-show="current_state_num === 1"
                       :font-size-class="font_size_class"
                       :current-instruction="current_instruction"></choose-passenger-count>

        <!--Select Outbound / Return Journey (state 2)-->
        <div v-show="current_state_num === 2" class="row">
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

        <!--Enter Passenger Names (state 3)-->
        <enter-passenger-names v-show="current_state_num === 3"
                               :passenger-count="passenger_data.passenger_count"
                               :font-size-class="font_size_class"
                               :current-instruction="current_instruction"></enter-passenger-names>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                font_size_class: 'font-size-min',
                current_instruction: '',
                current_state_num: 3,
                instructions: {
                    0: "Please <strong class='fore-white'>Click Here</strong> to book tickets for today's train journeys",
                    1: "Please select the amount of tickets you would like to book. <br><span class='fore-white'>(maximum of 4 per booking)</span>",
                    2: "Please select your <strong class='fore-white'>Outbound</strong> and <strong class='fore-white'>Return</strong> journeys from the options below",
                    3: "Please enter the <strong class='fore-white'>Passenger Names</strong> for this journey."
                },
                passenger_data: {
                    passenger_count: 2,
                    passenger_names: {
                        1: '',
                        2: '',
                        3: '',
                        4: '',
                    },
                    selected_outbound_id: null,
                    selected_return_id: null,
                },
            }
        },
        props: ['availableJourneys', 'dateToday'],
        mounted() {
            const self = this;
            self.setCurrentInstruction();

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
            // Go to the next state in the sequence
            progressToNextState: function(state_reference = null, state_values = null) {
                const self = this;

                // No state data is required, preogress to next state.
                if(state_reference === null && state_values === null) {
                    self.advanceState();
                    return true;
                }

                if(state_reference === 'passenger.count' && self.validateState(state_reference, state_values)) {
                    // Advance the state
                    self.passenger_count = state_values;
                    self.advanceState();
                }

                if(state_reference === 'passenger.names') {

                }


            },
            validateState: function(state_reference, state_values) {
                console.log('here');
                const self = this;

                if(state_reference === 'passenger.count') {
                    return state_values > 0 && state_values <= self.max_tickets_allowed;
                }

                return false;
            },
            advanceState: function() {
                const self = this;
                setTimeout(function() {
                    self.current_state_num++;
                    self.setCurrentInstruction();
                }, 200);
            }
        }
    }
</script>
