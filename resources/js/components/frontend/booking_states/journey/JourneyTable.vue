<template>
    <div class="card-body table-card">
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">----------</th>
                <th scope="col">----------</th>
                <th scope="col"></th>
                <th scope="col">----------</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(journey, index) in journeys"
                @click="selectJourney(journey.id)"
                :class="[
                    '',
                    selectedId === journey.id ? 'active' : '',
                    !validateJourneyIsAvailable(journey) ? 'unavailable' : ''
                ]">
                <td scope="row" class="pr-0 text-right">
                    <i :class="['arrow-selected fa fa-arrow-circle-right']"></i>
                </td>
                <td>{{ journey.departure_time }}</td>
                <td>{{ journey.arrival_time }}</td>
                <td>{{ journey.train }}</td>
                <td v-text="getSeatStatus(index)"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    const _ = require('lodash');

    export default {
        props: [
            'journeys',
            'reference',
            'selectedJourney',
            'selectedId',
            'passengerCount'
        ],
        data() {
          return {
              //
          }
        },
        mounted() {
            //
        },
        methods: {
            selectJourney: function(id) {
                const self = this;
                const journey_index = _.findIndex(self.journeys, function(o) {
                    return o.id === id;
                });

                if(self.validateJourneyIsAvailable(self.journeys[journey_index])) {
                    EventBus.$emit(self.reference+'.selected', { id: id, index: journey_index })
                }

            },
            getSeatStatus: function(index) {
                const self = this;
                const journey = self.journeys[index];

                if(journey.is_canceled) {
                    return 'Canceled';
                }

                return journey.seats_available;

            },
            // Returns true if journey passes series of checks
            validateJourneyIsAvailable(journey_object) {
                const self = this;

                // Journey is not available
                if(!journey_object.is_available) {
                    return false;
                }

                // Journey is canceled
                if(journey_object.is_canceled) {
                    return false;
                }

                // Journey has no seats available for required count
                if(journey_object.seats_available - self.passengerCount <= 0) {
                    return false;
                }

                return true;
            }
        }
    }
</script>
<style scoped>
    .table {
        margin-top: -50px;
    }

    .unavailable {
        color: lightgrey;
    }
</style>

