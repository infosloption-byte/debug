@extends('master.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/segmented-js/segment.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icons/system/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">

    <style type="text/css">
        .file_input_div {
            margin: auto;
            width: 250px;
            height: 40px;
        }
        .file_input {
            float: left;
        }
        #file_input_text_div {
            width: 200px;
            margin-top: -8px;
            margin-left: 5px;
        }
        .none {
            display: none;
        }
        .goal{
            cursor: pointer;
        }
        .creator img{
            width: 50px;
            height: 50px;
            object-fit: cover;
            float: left;
        }
        .creator .no-image{
            float: left;
            width: 50px;
            height: 50px;
            line-height: 50px;
            border-radius: 0;
        }
        .social_icon.linkedin {
            background: #6f6e6e;
        }

        ul.timeline {
            margin-right: 30px;
            list-style-type: none;
            position: relative;
            height: 420px;
            overflow-y: scroll;
        }
        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }
        ul.timeline > li {
            margin: 20px 0;
            padding-left: 20px;
        }
        ul.timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
        .table-responsive {
            height: auto;
        }

        .detail-header .card {
            height: 140px;
        }

        .content{
            margin-top: 160px;
        }
    </style>
@stop

@section('content')
    <div ng-app="ngApp" ng-controller="AssetController" ng-init="loadAssetData();"> 
        <div class="detail-header">
            <div class="card">
                <div class="body">
                    <div class="row ">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                            <p class="float-left" style="padding-left: 10px">
                                <a href="#" title="View details" style="color: black">
                                    <span style="font-size: 20px">Asset Management</span>
                                </a><br>
                                <small>Create and manage asset categories</small><br>
                                    
                            </p> 
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                                <li class="nav-item inlineblock">
                                    <a class="nav-link active show" href="{{url('asset/index')}}" aria-expanded="true">Assets</a>
                                </li>    
                            </ul>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-sm">Reset</button>
                                <button type="button" class="btn btn-default btn-sm">Export PDF</button>
                                <button type="button" class="btn btn-default btn-sm">Export Excel</button>
                                <button type="button" class="btn btn-default btn-sm" ng-click="find(filter)">Find</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>
                                        {{$details['asset_no']}}
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    @if($details['barcode']!=null)
                                        <?php echo DNS1D::getBarcodeSVG($details['asset_no'], $details['barcode']['barcodetype']['name'],1.5,60) ?>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr style="margin-left: 20px;margin-right: 20px">
                        <div class="body pt-0 pl-0 pr-0">
                            <div class="row" style="padding-left: 20px;padding-right: 20px">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <table>
                                        <tr>
                                            <td>Serial No</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['asset_no']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Main Category</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['maincategory']['name']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Category</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['category']->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Purcahse Date</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['purchased_date']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Purchased Value</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['purchased_value']}}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <table>
                                        <tr>
                                            <td>Warranty Period</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['warranty_period']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Warranty Start</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>
                                                @if($details['warranty_from'])
                                                    {{$details['warranty_from']}}
                                                @else
                                                    <span class="badge badge-danger">Not Activated</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Warranty Cancel</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['warranty_to']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Invoice Number</td>
                                            <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                            <td>{{$details['invoice_number']}} </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr style="margin-left: 20px;margin-right: 20px">
                            <div class="row" style="padding-left: 20px;padding-right: 20px;">
                                <div class="col-md-12">
                                    Supplier Details
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Contact No</td>
                                                    <td>Email</td>
                                                    <td>Address</td>
                                                    <td>City</td>
                                                    <td>Country</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{$details['supplier']['name']}}</td>
                                                    <td>{{$details['supplier']['phone']}}</td>
                                                    <td>{{$details['supplier']['email']}}</td>
                                                    <td>{{$details['supplier']['address']}}</td>
                                                    <td>{{$details['supplier']['city']}}</td>
                                                    <td>{{$details['supplier']['country']}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-left: 20px;margin-right: 20px">
                            <div class="row" style="padding-left: 20px;padding-right: 20px;">
                                <div class="col-md-12">
                                    Asset Details
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list table-bordered">
                                            <thead>
                                                <tr>
                                                    <td style="width: 30%">Field Name</td>
                                                    <td>Value</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($details['fieldValues'] as $sub)
                                                <tr>
                                                    <td>{{$sub['field']->name}}</td>
                                                    <td>{{$sub->value}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h5>Asset History</h5>
                        </div>
                        <hr style="margin-left: 20px;margin-right: 20px">
                        <div class="body pt-0 pl-0 pr-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="timeline">
                                        @foreach($details['transactions'] as $trans)
                                        <li>
                                            <a href="#">{{$trans['assetStatus']['name']}}</a>
                                            <p style="color: #000">
                                                {{date_format($trans['created_at'],'F j, Y g:i a')}}
                                            </p>
                                            <p>{{$trans['remark']}}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')

    <script type="text/javascript">

        $(document).ready(function(){
            $(".select2").select2({
                width: 'resolve'
            });
        });

        var app = angular.module("ngApp",['angularMoment','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);

        app.config(['$tooltipProvider', function ($tooltipProvider) {
            $tooltipProvider.options({
                appendToBody: true, // 
                appendToBody: true, // 
                placement:'bottom' // Set Default Placement
            });
        }]);

        app.controller("AssetController", function($scope,$http){
            $scope.details= null;
            
            $scope.loadAssetData = function(){
                $.ajax({
                    url: "{{url('/asset/get-asset-data')}}",
                    type: 'GET',
                    data: $scope.filter,
                    success: function (data) {
                        $scope.details = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            };

            $scope.find = function (filter,page) {
                $.ajax({
                    url: "{{url('/asset/get-asset-data')}}/?page="+page,
                    type: 'GET',
                    data: $scope.filter,
                    success: function (data) {
                        $scope.details = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            }
        });

    </script>
@stop