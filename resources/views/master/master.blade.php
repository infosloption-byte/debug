<!doctype html>
<html lang="en">


<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Jan 2019 13:59:43 GMT -->
<head>
<title>Ink | Admin</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">


<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/fontawesome/css/all.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/chartist/css/chartist.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/toastr/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.css')}}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('assets/admin_panel/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/css/loading.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/icons/flaticon.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/icons/system/style.css')}}">
<style type="text/css">
    @media (max-width: 768px){
        .breadcrumb{
            float: left!important;
        }

        
    }

    .sidebar-nav .metismenu a {
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
        color: #17191c;
        font-size: 14px;
        position: relative;
        padding: 13px 13px;
        outline-width: 0;
    }


    .flaticons:before{
        font-size: 20px !important;
        margin: 0;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }
     
    ::-webkit-scrollbar-track {
        background-color: #ebebeb;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 5px;
        border-radius: 5px;
        background: #6d6d6d; 
    }
</style>

@yield('css')


</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper"  id="loader">
    <div class="loader">
        <div class="m-t-30"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <!-- NAVIGATION BAT -->
    @include('includes.navbar')
    <!-- NAVIGATION BAT -->

    <!-- SIDEBAR -->
    @include('includes.sidebar')
    <!-- //SIDEBAR -->
    

    <div id="main-content">
        <div class="container-fluid">
            @yield('content')            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="{{asset('assets/admin_panel/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/vendorscripts.bundle.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/toastr/toastr.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/chartist.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/knob.bundle.js')}}"></script>
<script src="{{asset('assets/admin_panel/bundles/mainscripts.bundle.js')}}"></script>

    <script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
    <script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/js/fileinput.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/dialog.js')}}"></script>
    <script src="{{asset('assets/dist/moment/moment.js')}}"></script>
    <script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>
    <script src="{{asset('assets/dist/segmented-js/segment.js')}}"></script>
    <script src="{{asset('assets/dist/classie/classie.js')}}"></script>
    <script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
    <script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-0.14.3.min.js')}}"></script>
    <script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-tpls-0.14.3.min.js')}}"></script>
    <script src="{{asset('assets/dist/angular/angular/angular-sanitize.min.js')}}"></script>
    <script src="{{asset('assets/dist/ng-pagination/dist/paging.js')}}"></script>

<script type="text/javascript">
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("[rel=tooltip]").tooltip({html:true});

    // toastr.options.closeButton = true;
    // toastr.options.positionClass = 'toast-bottom-right';    
    // toastr['success']('Hello, welcome to Lucid, a unique admin Template.');


</script>

@yield('js')

</body>

</html>
