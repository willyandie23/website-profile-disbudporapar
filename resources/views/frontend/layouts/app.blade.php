<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>DISBUDPORAPAR</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('frontend/css/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/owlcarousel/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        {{-- <link href="css/bootstrap.min.css" rel="stylesheet"> --}}
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
        @stack('css')

        <!-- Template Stylesheet -->
        {{-- <link href="css/style.css" rel="stylesheet"> --}}
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
        @stack('styles')

    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @if ($navbar)
            <!-- Navbar -->
            @include('frontend.layouts.navbar')
        @endif

        @yield('content')

        @if ($navbar)
            <!-- Navbar -->
            @include('frontend.layouts.footer')
        @endif
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By WS  Distributed By <a class="border-bottom text-white" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/js/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owlcarousel/owl.carousel.min.js') }}"></script>
    {{-- <script src="lib/wow/wow.min.js"></script> --}}
    {{-- <script src="lib/easing/easing.min.js"></script> --}}
    {{-- <script src="lib/waypoints/waypoints.min.js"></script> --}}
    {{-- <script src="lib/counterup/counterup.min.js"></script> --}}
    {{-- <script src="lib/owlcarousel/owl.carousel.min.js"></script> --}}
    
    <!-- Template Javascript -->
    {{-- <script src="js/main.js"></script> --}}
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/identities',
                type: 'GET',
                success: function(response) {
                    if (response.success && response.data) {
                        if (response.data.site_logo) {
                            $('#site_logo').attr('src', response.data.site_logo).show();
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching Identities data:', xhr.responseText);
                    Swal.fire('Error!', 'Failed to load Identities data.', 'error');
                }
            });
        });
    </script>
    @stack('scripts')    
    </body>

</html>