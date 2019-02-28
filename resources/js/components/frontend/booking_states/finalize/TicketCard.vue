<template>
    <div class="card card-ticket text-uppercase">
        <div class="card-header">
            <div class="ticket-row">
                <div>{{ title }}</div>
                <div>{{ dateToday }}</div>
            </div>
            <div class="ticket-row">
                <div><span class="font-weight-bold">From: </span>{{ getJourneyField('from_station') }}</div>
                <div><span class="font-weight-bold">To: </span>{{ getJourneyField('to_station') }}</div>
            </div>
            <div class="ticket-row">
                <div><span class="font-weight-bold">Departing At: </span>{{ getJourneyField('departure_time') }}</div>
                <div><span class="font-weight-bold">Arriving At: </span>{{ getJourneyField('arrival_time') }}</div>
            </div>
        </div>

        <div class="train-img-container" :style="{ background: 'url('+getBackgroundUrl()+')' }">
        </div>
        <div class="card-body">
            <div class="ticket-row">
                <div><span class="font-weight-bold">Passenger: </span>{{ passengerName }}</div>
                <div><span class="font-weight-bold">Train: </span>{{ getJourneyField('train') }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TicketCard",
        props: ['journey', 'dateToday', 'title', 'passengerName'],
        data() {
          return {
              //
          }
        },
        methods: {
            getJourneyField(field) {
                const self = this;
                if(self.journey === null) {
                    return '';
                }

                return self.journey[field];
            },
            getBackgroundUrl() {
                const self = this;
                if(self.title === null) {
                    return '';
                }
                return self.title === 'outbound' ? 'http://www.philipdhawkins.co.uk/images/gallery/firth-of-forth.jpg' : 'http://www.philipdhawkins.co.uk/images/gallery/saltaire-winter.jpg';
            }
        }
    }
</script>
