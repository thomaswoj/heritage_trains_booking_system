@extends('layouts.booking')

@section('content')
    <booking :available-journeys="{{ json_encode($available_journeys) }}"
             :language-packs="{{ json_encode($language_packs) }}"
             :date-today="{{ json_encode(Carbon\Carbon::now()->format('d/m/Y')) }}"
    ></booking>
@endsection
