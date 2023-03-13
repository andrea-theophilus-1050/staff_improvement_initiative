<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/short-icon.jpg') }}" />

    <link rel="stylesheet" href="{{ asset('css/custom-scrollbar/style.css') }}">
</head>

<body>
    <div class="container-scroller">
        @include('partials._navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            @if (Auth::user()->role_id == 1)
                @include('partials._sidebar_admin_role')
            @elseif (Auth::user()->role_id == 2)
                @include('partials._sidebar_qaleaders_role')
            @elseif (Auth::user()->role_id == 3)
                @include('partials._sidebar_qacoordinators_role')
            @elseif (Auth::user()->role_id == 4)
                @include('partials._sidebar_staff_role')
            @endif

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('partials._footer')
                <!-- partial -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="mdi mdi-arrow-up-bold"></i></button>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->

    <script>
        // Get the button:
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button:
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document:
        function topFunction() {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            if (scrollTop > 0) {
                window.requestAnimationFrame(topFunction);
                window.scrollTo(0, scrollTop - scrollTop / 8);
            }
        }
    </script>
</body>

</html>
