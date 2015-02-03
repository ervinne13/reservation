<html>
    <head>
        <meta charset="UTF-8">
        <title>{{env("APP_TITLE_TEXT")}}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!--Favicon-->
        <link rel="shortcut icon" href="{{ asset('favicon/favicon-graduation-cap.ico') }}">

        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/css/app.css")}}" rel="stylesheet" type="text/css" />
        <meta name="_token" content="{{csrf_token()}}">

    </head>
    <body>
        <div class="wrapper">

            <div class="content-wrapper">
                @include('pages.sales-invoices.print')
            </div>

            <!-- REQUIRED JS SCRIPTS -->

            <!-- jQuery -->
            <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.3.min.js") }}"></script>
            <!-- Bootstrap 3.3.2 JS -->
            <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>

            <script src="{{ asset ("/bower_components/sweetalert2/dist/sweetalert2.min.js") }}" type="text/javascript"></script>
            <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.min.js") }}" type="text/javascript"></script>
            <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript"></script>

            <script src="{{ asset ("/vendor/underscore/underscore.js") }}" type="text/javascript"></script>
            <script src="{{ asset ("/vendor/autoNumeric/autoNumeric.js") }}" type="text/javascript"></script>

            <script src="{{ asset ("/js/utilities.js") }}" type="text/javascript"></script>
            <script src="{{ asset ("/js/globals.js") }}" type="text/javascript"></script>

            <!-- Optionally, you can add Slimscroll and FastClick plugins.
                  Both of these plugins are recommended to enhance the
                  user experience -->

            <script type="text/javascript">
var baseURL = '{{ URL::to("/") }}';
var _token = $('meta[name="_token"]').attr('content');
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
});

$(function () {
    window.print();
});
            </script>

    </body>
</html>