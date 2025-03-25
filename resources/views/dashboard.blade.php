<x-app-layout>

    @section('title')
        Dashboard
    @endsection
    @if(auth()->user()->hasRole('hse') || auth()->user()->hasRole('super-admin'))
        @include('hse.dashboard.dashboard_hse')
    @elseif(auth()->user()->hasRole('engineering manager'))
        @include('hse.dashboard.dashboard_em')
    @elseif(auth()->user()->hasRole('pic location'))
        @include('hse.dashboard.dashboard_pic_location')
    @elseif(auth()->user()->hasRole('security'))
        @include('hse.dashboard.dashboard_security')
    @elseif(auth()->user()->hasRole('user'))
        @include('hse.dashboard.dashboard_user')
    @endif



</x-app-layout>
