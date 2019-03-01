@extends('layouts.app')

@section('content')
    <div class="container back-black">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card text-uppercase">
                    <div class="card-body">
                        <div class="col-md-12">
                            <a href="{{ route('admin.report') }}">
                            <div class="card card-button back-black fore-white">
                                <div class="card-body text-center text-uppercase">
                                    Download <br> Booking Report
                                </div>
                            </div>
                            </a>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="card card-button back-black fore-white">
                                <div onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="card-body text-center text-uppercase">
                                    Logout
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
