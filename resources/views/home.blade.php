@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="visible-print text-center">
                            {!! QrCode::color(150,100,255)->size(210)->generate(Request::url()); !!}
                            <p>Scan me to return to the original page.</p>
                        </div>

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
