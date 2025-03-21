<x-app-layout>

    @section('title')
        Dashboard
    @endsection
    @if(auth()->user()->hasRole('hse'))
        @include('hse.dashboard.dashboard_hse')
    @endif
    
    @if(auth()->user()->hasRole('engineering manager'))
        @include('hse.dashboard.dashboard_em')
    @endif

    @if(auth()->user()->hasRole('pic location'))
        @include('hse.dashboard.dashboard_pic_location')
    @endif

    @if(auth()->user()->hasRole('security'))
        @include('hse.dashboard.dashboard_security')
    @endif

    @if(auth()->user()->hasRole('user'))
        @include('hse.dashboard.dashboard_user')
    @endif
    {{-- @include('hse.guest.dashboard')
    @can('view dashboard Finance')
        @include('dashboard.dashboardInventory')
    @endcan

    @can('view dashboard Sales & Marketing')
        @include('dashboard.dashboardSales')
    @endcan

    @can('view dashboard R&D')
        @include('dashboard.dashboardProduction')
    @endcan --}}



</x-app-layout>
