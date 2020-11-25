@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body')@stop

@section('body')

    <nav class="main-header navbar ml-0 p-0
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">
        {{-- Navbar brand logo --}}
        @include('adminlte::partials.common.brand-logo-xs')
    </nav>

    <div class="{{ ($auth_type ?? 'login') . '-page' }}">
        <div class="{{ $auth_type ?? 'login' }}-box">

            {{-- Card Box --}}
            <div class="{{ config('adminlte.classes_auth_card') }}">

                {{-- Card Header --}}
                @hasSection('auth_header')
                    <div class="mb-5 {{ config('adminlte.classes_auth_header') }}">
                        <h3 class="card-title float-none text-left text-xl">
                            @yield('auth_header')
                        </h3>
                    </div>
                @endif

                {{-- Card Body --}}
                <div class="{{ config('adminlte.classes_auth_body') }}">
                    @yield('auth_body')
                </div>

                {{-- Card Footer --}}
                @hasSection('auth_footer')
                    <div class="{{ config('adminlte.classes_auth_footer', '') }}">
                        @yield('auth_footer')
                    </div>
                @endif

            </div>

        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
