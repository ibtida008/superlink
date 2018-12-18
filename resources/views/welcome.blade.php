@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="height:100vh; margin-top: 30%">
        <div class="col-md-8 col-md-offset-2 center">
            <h6 id="welcome_intro1">Introducing</h6>
            <h5 id="welcome_intro2">The All In One <strong>Super URL</strong></h5>
            <a href="{{route('register')}}"><button class="btn btn-success">Get Started</button></a>
        </div>
    </div>
</div>
@endsection
