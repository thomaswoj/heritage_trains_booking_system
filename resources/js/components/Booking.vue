<template>
    <div class="container">
        <div v-show="current_state_num !== 0" class="row">
            <div class="col-md-12">
                <div class="card back-black fore-gray-light">
                    <div :class="['card-body text-center text-uppercase', font_size_class]" v-html="current_instruction"></div>
                </div>
            </div>
        </div>

        <!--Start Booking (state 0)-->
        <div v-show="current_state_num === 0" class="row">
            <div class="col-md-12">
                <div @click="progressToNextState()" class="card card-button back-black fore-gray-light">
                    <div :class="['card-body text-center text-uppercase', font_size_class]" v-html="current_instruction"></div>
                </div>
            </div>
        </div>

        <!--Select Ticket Number (state 1)-->
        <div v-show="current_state_num === 1" class="row">
            <div v-for="index in max_tickets_allowed" class="col-md-3">
                <div @click="progressToNextState(index)" class="card card-button back-black fore-white">
                    <div :class="['card-body text-center text-uppercase', font_size_class]" v-text="index"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                font_size_class: 'font-size-min',
                current_instruction: '',
                current_state_num: 0,
                instructions: {
                    0: "Please <strong class='fore-white'>Click Here</strong> to book tickets for today's train journeys.",
                    1: "Please select the amount of tickets you would like to book. <br><span class='fore-white'>(maximum of 4 per booking)</span>"
                },
                max_tickets_allowed: 4,
            }
        },
        props: ['availableJourneys'],
        mounted() {
            this.setCurrentInstruction();
            console.log('Component mounted.')
        },
        methods: {
            // Sets the instruction at top of page for the current state
            setCurrentInstruction: function() {
                this.current_instruction = this.instructions[this.current_state_num];
            },
            // Go to the next state in the sequence
            progressToNextState: function() {
                const self = this;
                setTimeout(function() {
                    self.current_state_num++;
                    self.setCurrentInstruction();
                }, 200);
            }
        }
    }
</script>
