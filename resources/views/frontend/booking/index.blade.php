@extends('layouts.booking')

@section('content')
    <booking :available-journeys="{{ json_encode($available_journeys) }}" :date-today="{{ json_encode(Carbon\Carbon::now()->format('d/m/Y')) }}"></booking>
@endsection
