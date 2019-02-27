<template>
    <div class="card card-ticket text-uppercase">
        <div class="card-header">
            <div class="ticket-row">
                <div>{{ title }}</div>
                <div>{{ dateToday }}</div>
            </div>
            <div class="ticket-row">
                <div><span class="font-weight-bold">From: </span>{{ journey.from_station }}</div>
                <div><span class="font-weight-bold">To: </span>{{ journey.to_station }}</div>
            </div>
            <div class="ticket-row">
                <div><span class="font-weight-bold">Departing At: </span>{{ journey.departure_time }}</div>
                <div><span class="font-weight-bold">Arriving At: </span>{{ journey.arrival_time }}</div>
            </div>
        </div>
        <div class="train-img-container" style="background: url(http://www.philipdhawkins.co.uk/images/gallery/firth-of-forth.jpg);">
        </div>
        <div class="card-body">
            <div class="ticket-row">
                <div><span class="font-weight-bold">Passenger: </span>{{ passengerName }}</div>
                <div><span class="font-weight-bold">Train: </span>{{ journey.train }}</div>
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
        }
    }
</script>
