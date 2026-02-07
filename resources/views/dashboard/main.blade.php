@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            @include('dashboard.elements.main_cards')
            @include('dashboard.elements.main_element')
            @include('dashboard.elements.main_tables')
        </div>
    </section>
@endsection
