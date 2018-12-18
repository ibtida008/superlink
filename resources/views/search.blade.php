@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="app_search">
        <router-view></router-view>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app_search.js') }}"></script>
@endsection
