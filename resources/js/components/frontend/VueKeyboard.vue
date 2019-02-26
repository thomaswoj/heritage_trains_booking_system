<template>
    <div class="keyboard-container">
        <div class="row">
            <span @click="keyPress(keyChar)" v-for="keyChar in this.keyboard.row1" v-text="keyChar" class="key"></span>
            <span @click="keyPress('DEL')" class="key">DEL</span>
        </div>
        <div class="row">
            <span @click="keyPress(keyChar)" v-for="keyChar in this.keyboard.row2" v-text="keyChar" class="key"></span>
            <!--<span @click="keyPress('ENTER')" class="key">ENTER</span>-->
        </div>
        <div class="row">
            <span @click="keyPress(keyChar)" v-for="keyChar in this.keyboard.row3" v-text="keyChar" class="key"></span>
        </div>
        <div class="row">
            <span @click="keyPress('SPACE')" class="key space-bar">SPACE</span>
        </div>
    </div>
</template>

<script>
    /*
        Simple Vue-Keyboard v1.0 by Tom Woj (github.com/thomaswoj)
        ----------------------------------------------------------
        1. Setup a basic vue event bus in your project via window.EventBus = new Vue()
        2. Include the keyboard component in your project and pass through
           a reference string to then hook into an emitted event on key-press!
           <vue-keyboard :ref='username.input_01'></vue-keyboard>
           EventBus.$on('vue-keyboard.keypress', function(data) {
                // use data.char and data.reference to do amazing things!
           });
     */
    module.exports = {
        mounted() {
            //
        },
        data: function() {
            return {
                flashingCaretHTML: '<span class="flashing-caret">|</span>',
                keyboard: {
                    row1: ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
                    row2: ['a','s','d','f','g','h','j','k','l','\'', '-'],
                    row3: ['z','x','c','v','b','n','m'],
                },
            }
        },
        props: ['reference'],
        methods: {
            keyPress: function(char) {
                const self = this;
                // Hook into the keyboard.keypress event via an event bus to use the keyboard
                EventBus.$emit('vue-keyboard.keypress', { char: char, reference: self.reference });
            },
            processInputExample: function(num) {
                return this.inputData.inputValues[num] === '' ? "<span style=\"color: grey;\">Enter input</span>" : this.inputData.inputValues[num] + (this.inputData.selectedInput === num ? "<span class=\"flashing-caret\">|</span>" : '');
            },
            keyPressExample: function(char) {
                var self = this;
                /*
                    Example input data format:
                    inputData: {
                        inputValues: { 1: 'value', 2: 'another value' },
                        selectedInput: 1
                    },
                 */
                var selectedInput = self.inputData.selectedInput,
                    inputValue = self.inputData.inputValue[selectedInput];
                if(char === 'ENTER') {
                    // Enter / Submission logic disabled by default
                }
                if(char === 'DEL' && inputValue.length > 0) {
                    self.inputData.inputValues[selectedInput] = self.inputData.inputValues[selectedInput].slice(0, -1); //Ref: https://stackoverflow.com/questions/952924/javascript-chop-slice-trim-off-last-character-in-string
                } else if(char === 'SPACE' && inputValue.slice(-1) !== ' ' && inputValue.length > 0) {
                    self.inputData.inputValues[selectedInput] += ' ';
                } else if(char !== 'DEL' && char !== 'SPACE') {
                    self.inputData.inputValues[selectedInput] += char;
                }
            }
        }
    }
</script>
<style scoped>
    /* Optional flashing-caret CSS*/
    @keyframes flashing-caret {
        0%   { opacity: 0; }
        45%   { opacity: 1; }
        55%   { opacity: 1; }
        100% { opacity: 0; }
    }
    .flashing-caret {
        animation: flashing-caret 1.5s infinite;
        margin-left: -5px;
    }
    /* Main Styling */
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .keyboard-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }
    .row {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        width: 100%;
    }
    .key {
        min-width: 2em;
        cursor: pointer;
        text-align: center;
        border: 3px solid black;
        border-radius: 5px;
        font-size: 2.0em;
        padding: 0 0.5em;
        text-transform: uppercase;
        margin: 0 0.1em;
        user-select: none;
    }
    .key:active {
        background-color: black;
        color: white;
    }
    .space-bar {
        min-width: 40%;
    }
</style>