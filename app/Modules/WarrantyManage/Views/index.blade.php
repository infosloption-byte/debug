
@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/segmented-js/segment.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/icons/system/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.min.css')}}">

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


    .card .counter{
       color: white;
        border-radius: 10px;
        width: 60px;
        height: 20px;
        display: inline-block;
        border: none;
        position: absolute;
        left: -16px;
        right: -7px;
        top: -9px;
        line-height: 12px;
    }


    .card .counter small{
       font-size: 12px;
       line-height: 17px;    
       position: relative;
        left: -1px;
    }

    .actions ol {
        width: 100%;
        display: table;
        table-layout: fixed; /* the magic dust that ensure equal width */
        margin:10px 0 0 0;
        padding: 0;
    }

    .actions ol > li {
        display: table-cell;
        text-align: center
    }

    .actions ol > li:before {
        content: '';
        display: block;
        border-left: 1px solid #ececec;
        height: 30px;
        position: absolute;
    }

    .actions ol > li:first-child:before {
        content: none;
    }

    .actions .icn{
        font-size: 25px;
        color: #969696;
    }

    .actions .icn:hover{
        color: #000;
    }

    .detail-header{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;

    }

    .detail-header .card{
        height: 180px;

    }

    .content{
        margin-top: 200px;
    }

    .w img{
        width: 70px;
        height: 70px;
        object-fit: cover;
        float: left;
    }

    .w .no-image{
        float: left;
        width: 70px;
        height: 70px;
        line-height: 70px;
        border-radius: 0;

    }

    .social_icon.linkedin {
        background: #6f6e6e;
    }

    .table-val{
        font-size: 13px;
    }


</style>
@stop


@section('content')
<div ng-app="ngApp" ng-controller="WarrantyController" ng-init=""> 

    <div class="detail-header">
        <div class="card" style="height: 192px!important;">
            <div class="body">
                <div class="row ">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                        <p class="float-left" style="padding-left: 10px">
                            <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                <span style="font-size: 20px">Warranty Management</span>
                            </a><br>
                            <small>Activate and de-activate warranty</small><br>
                        </p> 
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                        <div class="float-left">
                            <p>
                                <small class="text-muted">Products</small><br>
                                <strong>{{$counts['products']}}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                        <div class="float-left">
                            <p>
                                <small class="text-muted">Main Categories</small><br>
                                <strong>{{$counts['main_categories']}}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="float-left">
                            <p>
                                <small class="text-muted">Categories</small><br>{{$counts['categories']}}
                            </p>
                        </div>  
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="float-left">
                            <p>
                                <small class="text-muted">Brands</small><br>{{$counts['brands']}}
                            </p>
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" placeholder="Find!" 
                                    ng-model="filter.keyword">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                            <li class="nav-item inlineblock">
                                <a class="nav-link active show" href="{{url('warranty/index')}}" aria-expanded="true">Warranty</a>
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
         <div class="card ">
            <form method="POST" role="form" id="form-activate">
                <div class="body pt-4 pl-4 pr-4">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <select name="dealer" id="dealer" class="select2-container form-control show-tick ms select2" ng-model="filter.dealer">
                                    <option value="">- Select Dealer -</option>
                                    <option ng-repeat="dealer in dealers" value="@{{dealer.id}}">@{{dealer.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
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
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            <button type="button" class="btn btn-default btn-sm float-right mb-2" ng-click="find(filter)">Find</button>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <h4 id="selected_customer_name"></h4>
                            <input type="hidden" id="selected_customer_id" name="selected_customer_id">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <button type="button" class="btn btn-warning btn-sm float-right mb-2 btn-customer" id="btn-customer">Select Customer</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-b-0 c_list table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="5%" class="text-center">Action</th>
                                    <th>Asset No</th>
                                    <th>Category</th>
                                    <th>Main Category</th>
                                    <th>Brand</th>
                                    <th>Purchased Value</th>
                                    <th>Warranty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data track by $index">
                                    <td class="text-center">@{{$index+1}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="asset-box" id="asset-box-@{{$index+1}}" value="@{{detail.id}}">
                                    </td>
                                    <td>
                                        @{{detail.asset_no}}
                                    </td>
                                    <td>
                                        @{{detail.category.name}}
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                        @{{detail.maincategory.name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            @{{detail.brand.name}}
                                        </span>
                                    </td>
                                    <td>@{{detail.purchased_value}}</td>
                                    <td>@{{detail.warranty_period}} / month</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <paging page="details.current_page" page-size="details.per_page" total="details.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(filter,page)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-danger btn-sm float-right mb-2 btn-activate">Activate</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="modal fade" id="modal-customer">
        <div class="modal-dialog modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                
                <div class="modal-header">
                    <h4 class="modal-title col-md-12 text-left">Select Customer</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">District</label>
                                <select name="district" id="district" class="select2-container form-control show-tick ms select2" ng-model="filter.district">
                                    <option value="">- Select District -</option>
                                    <option ng-repeat="district in districts" value="@{{district.id}}">@{{district.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">City</label>
                                <select name="city" id="city" class="select2-container form-control show-tick ms select2" ng-model="filter.city">
                                    <option value="">- Select City -</option>
                                    <option ng-repeat="city in cities" value="@{{city.id}}">@{{city.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table m-b-0 c_list table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="customer in customers track by $index">
                                        <td><input type="radio" name="customer_radio" id="cust_ckbx_@{{$index+1}}" data-cust="@{{customer.id}}"></td>
                                        <td>@{{customer.code}}</td>
                                        <td>@{{customer.name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" ng-click="selectCustomer()"><i class="fa fa-save"></i> Select</button>
                </div>
            </div>
        </div>
    </div>
    
</div>
@stop

@section('js')

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

<script type="text/javascript">

    $(document).ready(function(){

        $(".select2").select2({
            width: 'resolve'
        });

        $('#btn-customer').on('click',function(){
           $('#modal-customer').modal('show');
        });
            
    });

    var app = angular.module("ngApp",['angularMoment','angularImgFallback','ui.bootstrap','ngSanitize']);
    //controller

    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    app.controller("WarrantyController", function($scope,$http)
    {
        $scope.dealers      = [];
        $scope.main_categories  = [];
        $scope.categories   = [];
        $scope.details = [];
        $scope.filter       = {};

        $scope.districts = [];
        $scope.cities = [];
        $scope.customers = [];

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

        $.ajax({
            url: "{{url('/service-center/getAllDistrict')}}",
            type: 'GET',
            success: function (data) {
                $scope.districts = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $('#district').change(function(){
            $.ajax({
                url: "{{url('/service-center/getAllCitiesByDistrict')}}",
                type: 'GET',
                data: {dis_id: $(this).val()},
                success: function (data) {
                    $scope.cities = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        });

        $('#city').change(function(){
            $.ajax({
                url: "{{url('/customer/get-customer-by-city')}}",
                type: 'GET',
                data: {id: $(this).val()},
                success: function (data) {
                    $scope.customers = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
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

        $scope.find = function (filter,page) {
            $.ajax({
                url: "{{url('/asset/get-asset-data-to-activate')}}/?page="+page,
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

        $scope.selectCustomer = function()
        {
            sel_cust_id = $('input[name="customer_radio"]:checked').data('cust');
            console.log(sel_cust_id);
            $('#modal-customer').modal('hide');

            $.each($scope.customers, function(key,value)
            {
                if(value.id == sel_cust_id){
                    $('#selected_customer_name').text(value.code+ "/" +value.name);
                    $('#selected_customer_id').val(value.id);
                }
            });
        }

        $("form#form-activate").submit(function(e) {
            e.preventDefault();

            if($('#dealer').val()=='' || $('#dealer').val()=='0'){
                swal({
                    title: "Warning",
                    text: "Select dealer to activate asset",
                });

                return false;
            }

            if($('#selected_customer_id').val()=='' || $('#selected_customer_id').val()=='0'){
                swal({
                    title: "Warning",
                    text: "Select customer to activate asset",
                });

                return false;
            }

            assets = [];

            $.each($("input[name='asset-box']:checked"), function(){
                assets.push($(this).val());
            });

            if(assets.length == 0 || assets.length == ''){
                swal({
                    title: "Warning",
                    text: "Select asset to activate",
                });

                return false;
            }

            var formData = new FormData(this);
            $('.dialog-loader').show();

            formData.append('assets',assets);

            $.ajax({
                url: "{{url('/warranty/activate')}}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('.dialog-loader').hide();
                    if(data.msg == 'success'){
                        swal({
                            title: "Success",
                            text: "Warranty Activated. Installation inquiries generated",
                        });
                        location.reload();
                    }else{
                        swal({
                            title: "Error",
                            text: "Cannot activate warranty. Try Again",
                        });
                    }
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
    });//end controller

</script>
@stop