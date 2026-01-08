@extends('master.master')

@section('css')

<style type="text/css">
    .excercise{
        background: #FCFDFA !important;
    }
    .hydrated{
        background: #F6F2FF !important;
    }
    .breakfast{
        background: #47DD9C !important;
    }
    input.largerCheckbox
    {
        width: 30px;
        height: 30px;
    }
    .detail-card{
        min-height: 280px;
    }
    .text-light h6{
        font-size: 13px;
    }
    .val-text{
    	position: absolute;
    	right: 10px;
    	bottom: 10px;
    	color: #fff;
    }
    .chart-div{
    	position: absolute;
    	left: 20px;
    	bottom: 10px;
    }
    .list-name {
    	color: #000;
    	font-weight: bold !important;
    }
    .val {
    	font-weight: 900 !important;
    	color: #000;
    }
    .social_media_table td{
    	padding-top: 8px;
    	padding-bottom: 8px; 
    }
    .social_media_table .text-muted{
    	color: #bdbdbd !important;
    }
    .conversion-arrow{
    	font-size: 40px;
    	padding-top: 10px;
    	color: #4caf4f;
    }
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="DashboardController">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> My Dashboard
                </h2>
            </div>            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li style="display: inline;" class="breadcrumb-item">Dashboard</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #007bff">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>Total Assets</h6>
                        <h5>
                            <strong>
                                @{{asset_data.total_asset | shortNumber}}
                            </strong>
                        </h5>
                    </div>
                    <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">

                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #8565ff">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>Assigned Assets</h6>
                        <h5>
                            <strong></strong>
                        </h5>
                    </div>
                     <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">
                        
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #fdd835">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>Not-Assigned</h6>
                        <h5>
                            <strong></strong>
                        </h5>
                    </div>
                    <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">
                        
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #ff1744">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>Complained</h6>
                        <h5>
                            <strong></strong>
                        </h5>
                    </div>
                     <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">
                        
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #9e9e9e">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>Jobs</h6>
                        <h5>
                            <strong></strong>
                        </h5>
                    </div>
                     <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">
                        
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card text-center " style="background: #2eacb3">
                <div class="body">
                    <div class="p-0 text-light">
                        <h6>In-Service</h6>
                        <h5>
                            <strong></strong>
                        </h5>
                    </div>
                    <hr class="m-t-2 m-b-2">
                    <small class="text-small text-left" style="color: #fff">
                        
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="card">
                <div class="body text-center">
                    <h5>Main Categories</h5>
                    <small>Over all</small>
                    <div class="table-responsive social_media_table" style="height: 255px;padding-top: 18px">
                        <table class="table table-hover">   
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="list-name">
                                            <strong></strong>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="val"></span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-success"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="card">
                <div class="body text-center">
                    <h5>Asset Summery</h5>
                    <small>Over all</small>
                    <div class="table-responsive social_media_table" style="height: 255px;padding-top: 18px">
                        <table class="table table-hover">   
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="list-name">
                                            <strong></strong>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="val"></span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-success"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="card">
                <div class="body text-center">
                    <h5>Main Categories</h5>
                    <small>Over all</small>
                    <div class="table-responsive social_media_table" style="height: 255px;padding-top: 18px">
                        <table class="table table-hover">   
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="list-name">
                                            <strong></strong>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="val"></span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-success"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="body">
                    <h5>Trend Analysis of Complains</h5>
                    <small>Last 12 Months</small>
                    <hr>
                     <div id="chartdiv" style="width: 100%; height: 362px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('js')
<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/dialog.js')}}"></script>

<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/jquery-sparkline/js/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{asset('assets/dist/amcharts/amcharts.js')}}"></script>
<script src="{{asset('assets/dist/amcharts/amcharts/pie.js')}}"></script>
<script src="{{asset('assets/dist/amcharts/serial.js')}}"></script>

<script type="text/javascript">

	$('.knob2').knob({
        'format' : function (value) {
            return value + '%';
        }
    });

	$('.chart.chart-bar').sparkline(undefined, {
        type: 'bar',
        barColor: '#fff',
        negBarColor: '#fb4364',
        barWidth: '6px',
        height: '20px'
    });

	var app = angular.module("ngApp",['angularMoment']);

    app.filter( 'shortNumber', function() {
        return function( number ) {
            if (number) {
                abs = Math.abs( number );
                if ( abs >= Math.pow( 10, 12 ) ) {
                    // trillion
                    number = ( number / Math.pow( 10, 12 ) ).toFixed( 1 ) + "T";
                } else if ( abs < Math.pow( 10, 12 ) && abs >= Math.pow( 10, 9 ) ) {
                    // billion
                    number = ( number / Math.pow( 10, 9 ) ).toFixed( 1 ) + "B";
                } else if ( abs < Math.pow( 10, 9 ) && abs >= Math.pow( 10, 6 ) ) {
                    // million
                    number = ( number / Math.pow( 10, 6 ) ).toFixed( 1 ) + "M";
                } else if ( abs < Math.pow( 10, 6 ) && abs >= Math.pow( 10, 3 ) ) {
                    // thousand
                    number = ( number / Math.pow( 10, 3 ) ).toFixed( 1 ) + "K";
                }
                return number;
            }else{
                return 0;
            }
        };
    });

    //controller
    app.controller("DashboardController", function($scope,$http){
        $scope.asset_data = [];

        $scope.loadAssetData = function(){
            $.ajax({
                url: "{{url('/asset/get-asset-data')}}",
                type: 'GET',
                data: $scope.filter,
                success: function (data) {
                    $scope.asset_data = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        };
    });

</script>
@stop
