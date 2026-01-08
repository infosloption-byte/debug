
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
<div ng-app="ngApp" ng-controller="DealerController" ng-init="find()"> 

    <div class="detail-header">
        <div class="card" style="height: 192px!important;">
            <div class="body">
                <div class="row ">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                        <p class="float-left" style="padding-left: 10px">
                            <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                <span style="font-size: 20px">Dealer Management</span>
                            </a><br>
                            <small>Create and manage dealer</small><br>
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
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" placeholder="Find!" 
                                    ng-model="filter.keyword">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="district" id="district" class="select2-container form-control show-tick ms select2" ng-model="filter.district">
                                        <option value="">- Select District -</option>
                                        <option ng-repeat="district in districts" value="@{{district.id}}">@{{district.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="city" id="city" class="select2-container form-control show-tick ms select2" ng-model="filter.city">
                                        <option value="">- Select City -</option>
                                        <option ng-repeat="city in cities" value="@{{city.id}}">@{{city.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                            <li class="nav-item inlineblock">
                                <a class="nav-link active show" href="{{url('dealer/index')}}" aria-expanded="true">Dealers</a>
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
            <div class="body pt-0 pl-0 pr-0">
                <div class="table-responsive">
                    <table class="table m-b-0 c_list table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Dealer Code</th>
                                <th width="20%">Name</th>
                                <th>City</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th width="20%">Created At</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="detail in details">
                                <td class="text-center p-10">@{{$index+1}}</td>
                                <td>
                                    <span class="badge badge-info">@{{detail.code}}</span>
                                </td>
                                <td>@{{detail.name}}</td>
                                <td>
                                    <span class="badge badge-default">@{{detail.city.name}}</span>
                                </td>
                                <td>@{{detail.contact_no}}</td>
                                <td>@{{detail.email}}</td>
                                <td>@{{detail.address}}</td>
                                <td>@{{detail.created_at | amDateFormat:'MMM DD, YYYY'}}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm" ng-click="editCustomer(detail.id)" 
                                    href="javascript:void(0);" title="Edit Brand">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="zoom">
      <a class="zoom-fab zoom-btn-md " style="background: black;color:white" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload Brands" id="btn-upload"><i class="fas fa-upload"></i></a>
    </div>

    <div class="modal fade" id="modal-upload">
        <div class="modal-dialog modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <form method="POST" role="form" id="form-upload" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title col-md-12 text-left">Upload Dealers</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Select Excel File <i style="cursor: pointer;" title="Download sample file" class="fa fa-download excel-dealer text-warning"></i></label>
                            <input id="input-b2" name="input-b2" type="file" class="file" data-show-preview="false">
                        </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <form method="POST" role="form" id="form-edit" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title col-md-12 text-left">Dealer Edit</h4>
                    </div>
                    <div class="modal-body">
                        <input name="edit_dealer_id" type="hidden" value="@{{edit_dealer.id}}">
                        <div class="form-group">
                            <label for="">Dealer Code</label>
                            <input name="dealer_code" type="text" class="form-control" value="@{{edit_dealer.code}}">
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="dealer_name" type="text" class="form-control" value="@{{edit_dealer.name}}">
                        </div>
                        <div class="form-group">
                            <label for="">District</label>
                            <select name="dealer_district" id="dealer_district" class="select2-container form-control show-tick ms select2">
                                <option value="">- Select District -</option>
                                <option ng-repeat="district in districts" value="@{{district.id}}">@{{district.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">City</label>
                            <select name="dealer_city" id="dealer_city" class="select2-container form-control show-tick ms select2">
                                <option value="">- Select City -</option>
                                <option ng-repeat="city in dealer_cities" value="@{{city.id}}">@{{city.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Contact No</label>
                            <input name="dealer_contact" type="text" class="form-control" value="@{{edit_dealer.contact_no}}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input name="dealer_email" type="text" class="form-control" value="@{{edit_dealer.email}}">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="dealer_address" type="text" class="form-control">@{{edit_dealer.address}}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
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
        
        $('#btn-upload').on('click',function(){
           $('#modal-upload').modal('show');
        });

        $(".excel-dealer").click(function(){
            window.location.href = '{{asset('assets/sample_excel/upload_dealer.xlsx')}}';
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

    app.controller("DealerController", function($scope,$http){

        $scope.details = null;
        $scope.districts = [];
        $scope.cities = [];
        $scope.filter = {};

        $scope.edit_dealer = [];
        $scope.dealer_cities = [];

        $.ajax({
            url: "{{url('/dealer/getAllDistrict')}}",
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
                url: "{{url('/dealer/getAllCitiesByDistrict')}}",
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

        $scope.find = function(){
            $.ajax({
                url: "{{url('/dealer/get-dealer-data')}}",
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

        $scope.editCustomer = function(id){

            $.ajax({
                url: "{{url('/dealer/get-dealer-by-id')}}",
                type: 'GET',
                data: {id: id},
                success: function (data) {
                    if(data){
                        $scope.edit_dealer = data;
                        $scope.$apply();

                        $.ajax({
                            url: "{{url('/dealer/getAllCitiesByDistrict')}}",
                            type: 'GET',
                            data: {dis_id: $scope.edit_dealer.city_id},
                            success: function (data) {
                                $scope.dealer_cities = data;
                                $scope.$apply();
                            },
                            error:function(data) {
                              $('.dialog-loader').hide();
                            }
                        });

                        // console.log($scope.edit_dealer.city.district_id);

                        $('#dealer_district').val($scope.edit_dealer.city.district_id).trigger('change');
                        $('#dealer_city').val($scope.edit_dealer.city_id).trigger('change');

                        $scope.$apply();
                        
                    }else{
                        swal({
                            title: "Warning",
                            text: "Cannot found dealer details",
                        });
                    }
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });            

            $('#modal-edit').modal('show');
        };

        $("form#form-upload").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('/dealer/upload')}}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('.dialog-loader').hide();
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

        $("form#form-edit").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('/dealer/edit')}}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    swal({
                        title: "Done",
                        text: "Dealer updated",
                    });
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
            
    });//end controller

</script>
@stop