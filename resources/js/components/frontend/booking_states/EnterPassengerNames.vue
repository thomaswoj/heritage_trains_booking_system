<template>
    <div id="passenger-state-container">

        <div class="row">
            <div class="col-md-12 name-inputs text-center">
                <div v-for="input_num in passengerCount"
                     @click="active_input = input_num"
                     :class="['input text-left', generateInputClasses(input_num)]">
                    <i :class="['arrow-selected fa fa-arrow-circle-right']"></i>
                    <span :class="['', generatePlaceholderClasses(input_num)]" v-html="getInputText(input_num)"> </span>
                    <span v-show="showCaret(input_num)" class="flashing-caret">|</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card text-uppercase">
                    <div class="card-body">
                        <vue-keyboard :reference="'passenger.names'"></vue-keyboard>
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
        name: "EnterPassengerNames",
        props: ['fontSizeClass', 'currentInstruction', 'passengerCount'],
        data() {
          return {
              max_tickets_allowed: 4,
              passenger_names: {
                  1: '',
                  2: '',
                  3: '',
                  4: '',
              },
              active_input: 1
          }
        },
        mounted() {
            const self = this;
            EventBus.$on('vue-keyboard.keypress', function(data) {
               if(data.reference !== 'passenger.names' && data.char !== null) {
                   return null;
               }
               self.setInputValue(data.char);
            });
        },
        methods: {
            progressToNextState: function(state_reference = null, state_values = null) {
                EventBus.$emit('state.progress', { state_reference: state_reference, state_values: state_values })
            },
            setInputValue: function(char) {
                const self = this;
                const selectedInput = self.active_input,
                    inputValue = self.passenger_names[selectedInput];

                if(char === 'DEL' && inputValue.length > 0) {
                    self.passenger_names[selectedInput] = inputValue.slice(0, -1); //Ref: https://stackoverflow.com/questions/952924/javascript-chop-slice-trim-off-last-character-in-string
                } else if(char === 'SPACE' && inputValue.slice(-1) !== ' ' && inputValue.length > 0) {
                    self.passenger_names[selectedInput] += ' ';
                } else if(char !== 'DEL' && char !== 'SPACE') {
                    self.passenger_names[selectedInput] += char;
                }
                return true;
            },
            showCaret: function(input_num) {
                const self = this;
                return self.active_input === input_num
                    && self.passenger_names[input_num] !== '';
            },
            generateInputClasses: function(input_num) {
                const self = this;
                var classes = '';

                if(input_num === self.active_input) {
                    classes += 'active';
                }

                //Ref: https://stackoverflow.com/questions/5016313/how-to-determine-if-a-number-is-odd-in-javascript
                if(self.passengerCount % 2 ) {
                    classes += ' min-width-80';
                }

                return classes;
            },
            generatePlaceholderClasses: function(input_num) {
                const self = this;
                if(self.passenger_names[input_num] === '') {
                    return 'placeholder';
                }
            },
            getInputText: function(input_num) {
                const self = this;
                const word_table = {
                  1: 'one',
                  2: 'two',
                  3: 'three',
                  4: 'four'
                };

                if(self.passenger_names[input_num] === '') {
                    return 'Please enter passenger '+word_table[input_num];
                }

                return(self.passenger_names[input_num]);
            },
        }
    }
</script>

