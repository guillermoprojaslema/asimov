@extends('layouts.app')

@section('title', 'Dance with the Death')

@section('content')
    @if($calendar)
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}

    @else
        <h3>There isn't any appopintments</h3>
    @endif



@endsection
