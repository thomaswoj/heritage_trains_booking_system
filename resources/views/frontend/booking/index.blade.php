@extends('layouts.app')

@section('content')
    <main class="booking-inner-container">
        <booking :available-journeys="{{ json_encode($available_journeys) }}"
                 :language-packs="{{ json_encode($language_packs) }}"
                 :date-today="{{ json_encode(Carbon\Carbon::now()->format('d/m/Y')) }}"
        ></booking>
    </main>
@endsection
