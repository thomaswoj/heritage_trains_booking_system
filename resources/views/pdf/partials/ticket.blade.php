
<div class="container">
    <div class="col-left" style="top: 14px; left: 35px">
        <div class="text">OUTBOUND</div>
        <div class="text"><span class="bold">FROM:</span> STATION</div>
        <div class="text"><span class="bold">DEPARTING AT: </span>11:30</div>
    </div>
    <div class="col-right" style="top: 14px; right: 48px;">
        <div class="text">25/02/19</div>
        <div class="text"><span class="bold">TO: </span>ENGINE SHED</div>
        <div class="text"><span class="bold">ARRIVING AT: </span>11:30</div>
    </div>

    @php($img_url = $type === 'outbound' ? '/img/outbound_train_crop.jpg' : '/img/return_train_crop.jpg')

    <img class="train-img" src="{{ url($img_url) }}" height="220" width="508">

    <img class="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->backgroundColor(0,0,0)->color(255,255,255)->margin(0)->generate('Make me into an QrCode!')) !!} " height="80px" width="80px">

    <div class="col-left" style="top: 312px; left: 35px;">
        <div class="text"><span class="bold">PASSENGER: </span>TOM</div>
    </div>
    <div class="col-right" style="top: 312px; right: 48px;">
        <div class="text"><span class="bold">TRAIN: </span>IVOR</div>
    </div>
</div>