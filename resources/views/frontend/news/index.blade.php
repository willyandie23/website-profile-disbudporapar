@extends('frontend.layouts.app')

@push('css')
    <style>
        .navbar-light.opaque .navbar-nav .nav-link{
            background: var(--bs-light) !important;
            color: var(--bs-dark);
        }

        .main-content {
            position:static;
            color: var(--bs-dark);
            padding-top: 90px; Tingkatkan untuk layar besar
        }

        @media (min-width: 992px) {
            .navbar-light {
                position: absolute;
                width: 100%;
                top: 0;
                left: 0;
                border-top: 0;
                border-right: 0;
                border-bottom: 1px solid;
                border-left: 0;
                border-style: dotted;
                z-index: 999;
            }

            .navbar-light.opaque {
                background: var(--bs-light) !important;
            }

            .sticky-top.navbar-light {
                position: fixed;
                background: var(--bs-light);
                border: none;
            }

        }
    </style>
@endpush

@section('content')
    <div class="main-content">

    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush