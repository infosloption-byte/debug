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
                                <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                    <span style="font-size: 20px">Asset Management</span>
                                </a><br>
                                <small>Create and manage asset categories</small><br>
                                    
                            </p> 
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                            <div class="float-left">
                                <p><small class="text-muted">Asset</small><br>
                                    <strong>{{count($data['assets'])}}</strong></p>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                            <div class="float-left">
                                <p><small class="text-muted">Main Categories</small><br><strong>{{count($data['main_categories'])}}</strong></p>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="float-left">
                                <p><small class="text-muted">Categories</small><br>{{count($data['categories'])}}</p>
                                
                            </div>  
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <div class="float-left">
                                <p><small class="text-muted">Brands</small><br>{{count($data['brands'])}}</p>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <form action="" method="POST" role="form">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="" placeholder="Find!" 
                                            ng-model="filter.keyword">
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <select name="main_category" id="main_category" class="select2-container form-control show-tick ms select2" ng-model="filter.main_category">
                                                <option value="">- Select Category -</option>
                                                <option ng-repeat="maincategory in main_categories" value="@{{maincategory.id}}">@{{maincategory.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <select name="category" id="category" class="select2-container form-control show-tick ms select2" ng-model="filter.category">
                                                <option value="">- Select Category -</option>
                                                <option ng-repeat="category in categories" value="@{{category.id}}">@{{category.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <select name="dealer" id="dealer" class="select2-container form-control show-tick ms select2" ng-model="filter.dealer">
                                                <option value="">- Select Dealer -</option>
                                                <option ng-repeat="dealer in dealers" value="@{{dealer.id}}">@{{dealer.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                                <li class="nav-item inlineblock">
                                    <a class="nav-link active show" href="{{url('asset/index')}}" aria-expanded="true">Assets</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show" href="{{url('category/index')}}" aria-expanded="true">Categories</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show"  
                                    href="{{url('brand/index')}}" aria-expanded="true">Brands</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                            <span class="input-group-btn">
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
            <div class="card">
                <div class="body pt-0 pl-0 pr-0">
                    <div class="table-responsive">
                        <table class="table m-b-0 c_list table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th>Asset No</th>
                                    <th>Dealer</th>
                                    <th>Category / Brand</th>
                                    <th>Inv / Supplier</th>
                                    <th>Purchased Date</th>
                                    <th>Purchased Value</th>
                                    <th>Warranty</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data">
                                    <td class="text-center">@{{$index+1}}</td>
                                    <td>
                                        @{{detail.asset_no}} <br>
                                        <?php 
                                            echo DNS1D::getBarcodeSVG('SN1229', 'C39',1.5,60);
                                        ?>
                                    </td>
                                    <td>@{{detail.dealer.name}}</td>
                                    <td>
                                        @{{detail.category.name}}<br>
                                        <span class="badge badge-info">
                                        @{{detail.maincategory.name}}
                                        </span>
                                        <span class="badge badge-warning">
                                            @{{detail.brand.name}}
                                        </span>
                                    </td>
                                    <td>
                                        @{{detail.supplier.name}}<br>
                                        <span class="badge badge-danger">
                                        @{{detail.invoice_number}}
                                        </span>
                                    </td>
                                    <td>@{{detail.purchased_date}}</td>
                                    <td>@{{detail.purchased_value}}</td>
                                    <td>@{{detail.warranty_period}} / month</td>
                                    <td>
                                        <span ng-show="detail.warranty_from==NULL" class="badge badge-warning">Not A ctivated</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary float-center" title="View Product" style="margin-right: 10px;background: #01b2c6;cursor: pointer;" ng-click="viewAsset(detail.id)">
                                            <i class="fa fa-eye" style="color: #fff"></i>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <paging page="details.current_page" page-size="details.per_page" total="details.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(filter,page)">
                </div>  
            </div>
        </div>

        <div class="zoom">
            <a class="zoom-fab zoom-btn-md " style="background: black;color:white" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload new category" id="btn-upload">
                <i class="fas fa-upload"></i>
            </a>
        </div>

        <div class="modal fade" id="modal-upload">
            <div class="modal-dialog modal-lg">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Upload assets</h4>
                    </div>
                    <form method="POST" role="form" id="form-upload">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select File (Download sample 
                                            <i style="cursor: pointer;" title="Download sample file" class="fa fa-download text-warning"></i>)
                                        </label>
                                        <div class="input-group">
                                            <input id="fileToUpload" type="file" name="files" class="file-upload none" ng-model="file"> 
                                            <input type="text" class="form-control" id="file_prev" disabled="" value="@{{file}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="btn-edit-basic" onclick="document.getElementById('fileToUpload').click()">
                                                    <i class="fas fa-upload"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
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
    
            $('#btn-upload').on('click',function(){
               $('#modal-upload').modal('show');
            });

            $('.fa-download').click(function(){
                window.location.href = '{{asset('assets/sample_excel/upload_asset.xlsx')}}';
            });

            $('#fileToUpload').change(function(e){
                $('#file_prev').val(e.target.files[0].name);
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
            
            $scope.details  = null;
            $scope.dealers      = [];

            $scope.main_categories  = [];
            $scope.categories   = [];
            
            $scope.filter       = {};

            $.ajax({
                url: "{{url('/dealer/getAllDealers')}}",
                type: 'GET',
                success: function (data) {
                    $scope.dealers = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            $.ajax({
                url: "{{url('/category/getAllMainCategories')}}",
                type: 'GET',
                data: $scope.filter,
                success: function (data) {
                    $scope.main_categories = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            $('#main_category').change(function(){
                $.ajax({
                    url: "{{url('/category/getCategoriesByMainId')}}",
                    type: 'GET',
                    data: {id: $(this).val()},
                    success: function (data) {
                        $scope.categories = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            });
            
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

            $scope.viewAsset = function (id) {
                window.location.href = "{{url('/asset/view')}}/"+id;
            }

            $("form#form-upload").submit(function(e) {
                e.preventDefault();    
                var formData = new FormData(this);
                $('.dialog-loader').show();

                $.ajax({
                    url: "{{url('/asset/upload')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        console.log(data);
                        $scope.$apply();
                        $scope.loadAssetData();
                        location.reload();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                
                return false;
            });
        });

    </script>
@stop


































