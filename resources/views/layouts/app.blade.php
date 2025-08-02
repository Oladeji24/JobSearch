@extends('layouts.master')

@section('content')
    @if (isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif
@endsection