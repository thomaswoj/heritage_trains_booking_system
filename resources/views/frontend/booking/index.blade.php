@extends('layouts.booking')

@section('content')
    <booking :available-journeys="{{ json_encode($available_journeys) }}"></booking>
@endsection
