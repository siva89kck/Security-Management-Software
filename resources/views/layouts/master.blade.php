<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template">
  <meta name="keywords"
    content="admin template, ra-admin admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="la-themes">
  <link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
  <title>Dashboard | RSS Security Services</title>

  <!--font-awesome-css-->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

  <!-- Animation css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/animation/animate.min.css') }}">

<!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

<!-- Weather icon css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/weather/weather-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/weather/weather-icons-wind.css') }}">

<!-- Flag Icon css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/flag-icons-master/flag-icon.css') }}">

<!-- Tabler icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/tabler-icons/tabler-icons.css') }}">

<!-- Prism css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/prism/prism.min.css') }}">

<!-- Apexcharts css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">

<!-- Glight css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/glightbox/glightbox.min.css') }}">

<!-- Slick css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

<!-- Data Table css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">

<!-- Bootstrap css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">

<!-- Vector map css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/vector-map/jquery-jvectormap.css') }}">

<!-- Simplebar css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/simplebar/simplebar.css') }}">

<!-- App css -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- Responsive css -->
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

<!-- list page inactive active js code -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- DataTables + Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- jQuery + DataTables + Buttons JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<style>
    #employees-table_wrapper .dt-buttons
    {
        float: right!important;
        padding: 1rem 1.25rem !important;
    }

/* Default sorting arrow both */
table.dataTable thead .sorting {
  background-image: url('https://cdn.datatables.net/1.13.6/images/sort_both.png');
  background-repeat: no-repeat;
  background-position: center right;
}

/* Ascending arrow */
table.dataTable thead .sorting_asc {
  background-image: url('https://cdn.datatables.net/1.13.6/images/sort_asc.png');
  background-repeat: no-repeat;
  background-position: center right;
}

/* Descending arrow */
table.dataTable thead .sorting_desc {
  background-image: url('https://cdn.datatables.net/1.13.6/images/sort_desc.png');
  background-repeat: no-repeat;
  background-position: center right;
}

/* Optional – header padding so arrow not overlap */
table.dataTable thead th {
  padding-right: 25px; /* arrow க்கு இடம் */
}

</style>

</head>

<body>
  <div class="app-wrapper">

    <div class="loader-wrapper">
      <div class="loader_16"></div>
    </div>
     {{--Left side bar navigation  --}}
    @include('layouts/menu')
    {{--Left side bar navigation  end --}}

    <div class="app-content">
      <div class="">

        <!-- Header Section starts -->
        @include('layouts/topmenu')
        <!-- Header Section ends -->

        <!-- Body main section starts -->
        <main>
          <div class="container-fluid">

            @yield('content')

          </div>
        </main>
      </div>
    </div>
    <!-- Body main section ends -->


    <!-- tap on top -->
    <div class="go-top">
      <span class="progress-value">
        <i class="ti ti-arrow-up"></i>
      </span>
    </div>

    <!-- Footer Section starts-->
    <footer>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9 col-12">
            <ul class="footer-text">
              <li>
                <p class="mb-0">Copyright © 2025 RSS Security Services. All rights reserved</p>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </footer>
    <!-- Footer Section ends-->
  </div>

  <!-- modal -->

  {{-- <div class="modal" tabindex="-1" id="welcomeCard" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content welcome-card">

        <div class="modal-body p-0">
          <div class="text-center position-relative welcome-card-content z-1 p-3">
            <div class="text-end">
              <i class="ti ti-x fs-5 text-dark f-w-600" data-bs-dismiss="modal"></i>
            </div>
            <h2 class="f-w-600"><span>Welcome !</span>👋 </h2>
            <h6 class="f-s-15 text-dark f-w-500 mx-0 mx-sm-5"> Start Multipurpose, clean modern responsive bootstrap 5 admin template </h6>

            <div>
              <img src="{{ asset('assets/images/modals/welcome-1.png') }}" alt="img" class=" img-fluid">
            </div>
            <div class="mt-3 mb-4">
              <button type="button" class="btn btn-primary text-white btn-lg" data-bs-dismiss="modal">Let's
                Started <i class="ti ti-chevrons-right"></i> </button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div> --}}

  <!--customizer-->
  {{-- <div id="customizer"></div> --}}

<!-- Latest jQuery -->
{{-- <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/datatable/jquery-3.5.1.js') }}"></script> --}}

<!-- Bootstrap js -->
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

<!-- Simple bar js -->
<script src="{{ asset('assets/vendor/simplebar/simplebar.js') }}"></script>

<!-- Phosphor js -->
<script src="{{ asset('assets/vendor/phosphor/phosphor.js') }}"></script>

<!-- Vector map plugin js -->
<script src="{{ asset('assets/vendor/vector-map/jquery-jvectormap-2.0.5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/vector-map/jquery-jvectormap-world-mill.js') }}"></script>

<!-- Slick js -->
<script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

<!-- Cleave js -->
<script src="{{ asset('assets/vendor/cleavejs/cleave.min.js') }}"></script>

<!-- Apexcharts js -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

<!-- Data table js -->
{{-- <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script> --}}
<!-- js-->
  <script src="{{ asset('assets/js/data_table.js') }}"></script>

<!-- Glightbox js -->
<script src="{{ asset('assets/vendor/glightbox/glightbox.min.js') }}"></script>

<!-- Customizer js -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>

<!-- Ecommerce js -->
<script src="{{ asset('assets/js/ecommerce_dashboard.js') }}"></script>

<!-- Prism js -->
<script src="{{ asset('assets/vendor/prism/prism.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/script.js') }}"></script>


</body>

</html>
