<!doctype html>
<html lang="en">


<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/page-lockscreen.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Jan 2019 14:00:32 GMT -->
<head>
<title>Ink | Admin</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


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
<link rel="stylesheet" href="{{asset('assets/dist/ng-clock/dist/angular-clock.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin_panel/icons/flaticon.css')}}">
<link rel="stylesheet" href="{{asset('assets/dist/animations/font-awesome-animation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/icons/system/style.css')}}">

<style type="text/css">
    .avatar{
        border: 1px solid #ddd;
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin-top: 20px;
    }

    .tag{
        border:none;color:white;margin-top: -20px;
    }

    .auth-box{
        min-width: 100%;
    }

    .details{
        background: #fff;
        min-height: 100%;
        height: 100vh; /* For 100% screen height */
        padding:20px;
    }

    .user{
        color: #000;
    }

    .logo img{
        width: 80px;
        padding-top: 20px;
    }

    .bg{
        padding: 50px;
    }

    .navbar-fixed-top .navbar-brand .avatar {
        width: 35px;
        height: 35px;
        margin-top: 0;
        padding:0;
    }

    .vr{
            border-right: 1px solid #efefef;
    margin-right: 20px;
    padding-bottom: 8px;
    padding-top: -2px;
    }

    .navbar-fixed-top .navbar-right {
         width: auto; 
    }

    .name{
        font-size: 12px;
    }

    .widget-clock .time {
        font-size: 1em;
        margin: 0;
    }

    .bg{
        background:url("{{url('assets/admin_panel/images/bg_test.jpg')}}") no-repeat top left fixed;
        
    }

    .parent {
        display: table;
        height: 100vh;
    }

    .child {
        display: table-cell;
        vertical-align: middle;
    }

    .g-icon{
        width: 90px !important;
        height: 90px !important;
        border-radius: 20px;
        margin-bottom:100px;
    }

    .flaticons{
        color: #fff;
        line-height: 90px;
    }
    
    .title{
        font-weight: 900;
        color: #fff;
    }

    .title h6{

        font-size: 13px !important;
        left: 0px;
        width: 100%;
    }


    .counter{
        color: white;
        border-radius: 100%;
        width: 25px;
        height: 25px;
        display: inline-block;
        border: none;
        position: absolute;
        /* left: 0; */
        right: -12px;
        top: -7px;
        line-height: 14px;
    }


    .counter small{
       font-size: 12px;
       line-height: 17px;    
       position: relative;
        left: -1px;
    }

    .navbar-fixed-top {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: #fff;
        z-index: 99;
        box-shadow: 0 1px 5px 0 rgba(84, 84, 84, 0.6);
    }

    .g-icon:hover .flaticons:before {
        -webkit-animation: tada 2s linear infinite;
        animation: tada 2s linear infinite;
    }

    .navbar-fixed-top .navbar-brand img {
        width: 120px;
        vertical-align: top;
        margin-top: 7px;
    }

    [class^="icn-"], [class*=" icn-"] {
      font-size: 45px;
      line-height: 100px;
    }

</style>
</head>

<body class="theme-orange bg" ng-app="ngApp" ng-controller="HomeController" >

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand hidden-sm   ">
                <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="{{url('/')}}" class="center-block">
                        <strong style="color: #000"><span style="color: red">Debug</span></strong>
                    </a>

                        <span class="vr"></span> 

                        <span class="name">
                            <img image="{{asset('storage')}}{{$user->image}}" 
                             image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  
                             class="rounded-circle avatar " 
                             data-title="{{$user->name}}" 
                             style="border:1px solid #ddd">

                        </span>
                     </div>
                </div> 

            </div>
            
            <div class="navbar-right">               

                <div id="navbar-menu">

                    <ul class="nav navbar-nav">                        
                        <li>
                            <ds-widget-clock theme="dark" show-digital="true" show-secs="true" digital-format="'hh:mm:ss a'"></ds-widget-clock>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot" style="background-color:#de2fc0"></span>
                            </a>
                            <ul class="dropdown-menu notifications animated shake">
                                <li class="header"><strong>You have 4 new Notifications</strong></li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-info text-warning"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Campaign <strong>Holiday Sale</strong> is nearly reach budget limit.</p>
                                                <span class="timestamp">10:00 AM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>                               
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-like text-success"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Your New Campaign <strong>Holiday Sale</strong> is approved.</p>
                                                <span class="timestamp">11:30 AM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                 <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-pie-chart text-info"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Website visits from Twitter is 27% higher than last week.</p>
                                                <span class="timestamp">04:00 PM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-info text-danger"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Error on website analytics configurations</p>
                                                <span class="timestamp">Yesterday</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="footer"><a href="javascript:void(0);" class="more">See all notifications</a></li>
                            </ul>
                            </li>
                        <li><a href="{{url('logout')}}" class="icon-menu"><i class="icon-login"></i></a></li>                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="parent container">
        <div class="child">
            <div class="" >
                <div class="row ">    
                    <div class="col-6 col-md-2 col-sm-6 col-lg-2 mx-auto" >
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('/dashboard')}}">
                                <div class="g-icon"  style="background: #007bff">
                                    <!-- <span class="counter badge " style="background: #000"><p>5</p></span> -->
                                    <i class="flaticons icn-search-delivery-service-tool "></i>
                                    <div class="title">
                                        <h6>My<br>Dashboard</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-6 col-md-2 col-sm-6 col-lg-2">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('/asset/index')}}">
                                <div class="g-icon text-center" style="background:  #ffc107">
                                    
                                    <span class="flaticons icn-barscode-with-a-magnifier-business-symbol"></span>
                                    <div class="title">
                                        <h6>Asset<br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-6 col-md-2 col-sm-6 col-lg-2">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('inquiry/index')}}">
                                <div class="g-icon text-center" style="background: #8565ff">
                                    <span class="flaticons icn-telephone"></span>
                                    <div class="title">
                                        <h6>Inquiry<br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                        
                    <div class="col-6 col-md-2 col-sm-4 col-lg-2 text-center align-self-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('location/list')}}">
                                <div class="g-icon text-center" style="background: #ff5326">
                                    <span class="flaticons icn-international-delivery"></span>
                                    <div class="title text-center">
                                        <h6>Location<br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('job/index')}}">
                                <div class="g-icon text-center" style="background: #4b3b8a">
                                    <span class="flaticons icn-boxes-piles-stored-inside-a-garage-for-delivery"></span>
                                    <div class="title text-center">
                                        <h6>Job <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('service/index')}}">
                                <div class="g-icon text-center" style="background: #31b96f">
                                    <span class="flaticons icn-person-standing-beside-a-delivery-box"></span>
                                    <div class="title text-center">
                                        <h6>Service <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('dealer/index')}}">
                                <div class="g-icon text-center" style="background: #0e24a0">
                                    <span class="flaticons icn-person-standing-beside-a-delivery-box"></span>
                                    <div class="title text-center">
                                        <h6>Dealer <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('technician/index')}}">
                                <div class="g-icon text-center" style="background: #b125d0">
                                    <span class="flaticons icn-weight-tool"></span>
                                    <div class="title text-center">
                                        <h6>Technician <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('warranty/index')}}">
                                <div class="g-icon text-center" style="background: #272727">
                                    <span class="flaticons icn-protection-symbol-of-opened-umbrella-silhouette-under-raindrops"></span>
                                    <div class="title text-center">
                                        <h6>Warranty <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="{{url('customer/index')}}">
                                <div class="g-icon text-center" style="background: #9e9e9e">
                                    <span class="flaticons flaticon-sun-black-shape"></span>
                                    <div class="title text-center">
                                        <h6>Customer <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="javascript::void(0)">
                                <div class="g-icon text-center" style="background: #0fb78c">
                                    <span class="flaticons icn-triangular-arrows-sign-for-recycle"></span>
                                    <div class="title text-center">
                                        <h6>Report <br>Manager</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                     <div class=" col-6 col-md-2 col-sm-6 col-lg-2  text-center">
                        <div class="row justify-content-center " align="center">
                            <a href="javascript::void(0)">
                                <div class="g-icon text-center" style="background: #ff2f3e">
                                    <span class="flaticons icn-hours-delivery"></span>
                                    <div class="title text-center">
                                        <h6>Help &<br>Feedback</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



	
</body>

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>
<script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
<script src="{{asset('assets/dist/ng-clock/dist/angular-clock.min.js')}}"></script>

<script type="text/javascript">
  var app = angular.module("ngApp",['angularImgFallback','ds.clock']);
    //controller


    app.controller("HomeController", function($scope,$http){
     
        
            
    });  

</script>
<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/page-lockscreen.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Jan 2019 14:00:32 GMT -->
</html>
