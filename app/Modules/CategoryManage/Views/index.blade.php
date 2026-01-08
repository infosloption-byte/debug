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
<div ng-app="ngApp" ng-controller="CategoryController" ng-init="loadCategoryData()"> 

    <div class="detail-header">
        <div class="card">
            <div class="body">
                <div class="row ">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                        <p class="float-left" style="padding-left: 10px">
                            <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                <span style="font-size: 20px">Category Management</span>
                            </a><br>
                            <small>Create and manage product categories</small><br>
                                
                        </p> 
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                        <div class="float-left">
                            <p><small class="text-muted">Products</small><br>
                                <strong>{{$counts['products']}}</strong></p>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                        <div class="float-left">
                            <p><small class="text-muted">Main Categories</small><br><strong>{{$counts['main_categories']}}</strong></p>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="float-left">
                            <p><small class="text-muted">Categories</small><br>{{$counts['categories']}}</p>
                            
                        </div>  
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="float-left">
                            <p><small class="text-muted">Brands</small><br>{{$counts['brands']}}</p>
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="" method="POST" role="form">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="Find!" 
                                        ng-model="filter.keyword">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select name="main_category" id="main_category" class="select2-container form-control show-tick ms select2" ng-model="filter.main_category">
                                            <option value="">- Select Main Category -</option>
                                            @foreach($main_categories as $main_category)
                                                <option value="{{$main_category['id']}}">{{$main_category['name']}}</option>
                                            @endforeach
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
                                <a class="nav-link show" href="{{url('asset/index')}}" aria-expanded="true">Assets</a>
                            </li>
                            <li class="nav-item inlineblock">
                                <a class="nav-link active show" href="{{url('category/index')}}" aria-expanded="true">Categories</a>
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
         <div class="card ">
            <div class="body pt-0 pl-0 pr-0">
                <div class="table-responsive">
                    <table class="table m-b-0 c_list table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th>Main Category</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Service By</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="detail in details.data">
                                <td class="text-center">@{{$index+1}}</td>
                                <td>
                                    <span class="badge badge-warning">@{{detail.main_category.name}}</span>
                                </td>
                                <td>
                                   @{{detail.code}}
                                </td>
                                <td>@{{detail.name}}</td>
                                <td>@{{detail.preventive_service_by}} / Month</td>
                                <td>@{{detail.created_by.employee.first_name}} @{{detail.created_by.employee.last_name}}</td>
                                <td>@{{detail.created_at | amDateFormat:'MMM DD, YYYY'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <paging
                    page="details.current_page" 
                    page-size="details.per_page" 
                    total="details.total"
                    show-prev-next="true"
                    show-first-last="true"
                    ul-class="pagination"
                    paging-action="find(filter,page)">
              </div>  
        </div>
    </div>

    <div class="zoom">
        <a class="zoom-fab zoom-btn-md " style="background: black;color:white;" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload new category" id="btn-upload"><i class="fas fa-upload"></i></a>
    </div>

    <div class="modal fade" id="modal-upload">
        <div class="modal-dialog modal-lg">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header text-left">
                    <h4 class="modal-title">Upload Categories</h4>
                </div>
                <form method="POST" role="form" id="form-upload">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Select File (Download sample 
                                        <i style="cursor: pointer;" title="Download sample file" class="fa fa-download text-warning"></i></label>)
                                    <div class="input-group">
                                        <input id="fileToUpload" type="file" name="files" class="file-upload none" ng-model="file"> 
                                        <input type="text" class="form-control" id="file_prev" disabled="" value="@{{file}}">
                                        <div class="input-group-append">                                            
                                            <button type="button" class="btn btn-outline-secondary"  id="btn-edit-basic" 
                                                    onclick="document.getElementById('fileToUpload').click()">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="!up_loading">
                            <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Errors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="upload_result in upload_results">
                                        <td>@{{$index+1}}</td>
                                        <td>@{{upload_result.row.category_name?upload_result.row.category_name:'--'}}</td>
                                        <td ng-show="upload_result.status=='failed'" style="color: red">@{{upload_result.status}}</td>
                                        <td ng-show="upload_result.status=='empty'" style="color: red">empty row</td>
                                        <td ng-show="upload_result.status=='success'" style="color: green">@{{upload_result.status}}</td>
                                        <td ng-show="upload_result.status=='update'" style="color: green">@{{upload_result.status}}</td>
                                        <td ng-hide="upload_result.status=='empty'">
                                            <a href="javascript:void(0);" style="color: red;text-decoration: underline;"
                                                uib-tooltip-html="upload_result.erros"
                                                tooltip-placement="top"
                                                >@{{upload_result.error_count}}
                                            </a>
                                        </td>
                                        <td ng-show="upload_result.status=='empty'" style="color: red">
                                            Empty row
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    $(document).ready(function(){
        $(".select2").select2({
            width: 'resolve'
        });
        
        $('#btn-upload').on('click',function(){
            $('#modal-upload').modal('show');
        });

        $('.fa-download').click(function(){
            window.location.href = '{{asset('assets/sample_excel/upload_category.xlsx')}}';
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

    app.controller("CategoryController", function($scope,$http){

        $scope.details= null;
        $scope.filter= {};
        $scope.upload_results   = [];
        $scope.up_loading       = true;

        $scope.loadCategoryData = function(){
            $.ajax({
                url: "{{url('/category/get-category-data')}}",
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
                url: "{{url('/category/get-category-data')}}/?page="+page,
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

        $("form#form-upload").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('/category/upload')}}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('.dialog-loader').hide();
                    $scope.upload_results = data.res;
                    $scope.up_loading = false;
                    $scope.$apply();
                    $scope.loadCategoryData();
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