
<div class="container">
    <div class="col-left" style="top: 14px; left: 35px">
        <div class="text">{{ $ticket['type'] }}</div>
        <div class="text"><span class="bold">FROM: </span>{{ $ticket['from_station'] }}</div>
        <div class="text"><span class="bold">DEPARTING AT: </span>{{ $ticket['departure_time'] }}</div>
    </div>
    <div class="col-right" style="top: 14px; right: 48px;">
        <div class="text">{{ $ticket['journey_date'] }}</div>
        <div class="text"><span class="bold">TO: </span>{{ $ticket['to_station'] }}</div>
        <div class="text"><span class="bold">ARRIVING AT: </span>{{ $ticket['arrival_time'] }}</div>
    </div>

    @php($img_url = $ticket['type'] === 'outbound' ? '/img/outbound_train_crop.jpg' : '/img/return_train_crop.jpg')

    <img class="train-img" src="{{ url($img_url) }}" height="220" width="508">

    <img class="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->backgroundColor(0,0,0)->color(255,255,255)->margin(0)->generate($ticket['uuid'])) !!} " height="80px" width="80px">

    <div class="col-left" style="top: 312px; left: 35px;">
        <div class="text"><span class="bold">PASSENGER: </span>{{ $ticket['passenger_name'] }}</div>
    </div>
    <div class="col-right" style="top: 312px; right: 48px;">
        <div class="text"><span class="bold">TRAIN: </span>{{ $ticket['train_name'] }}</div>
    </div>
</div>