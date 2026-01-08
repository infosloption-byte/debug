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
    <div ng-app="ngApp" ng-controller="MaterialRequestController" ng-init="loadMaterialData();"> 
        <div class="detail-header">
            <div class="card">
                <div class="body">
                    <div class="row ">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                            <p class="float-left" style="padding-left: 10px">
                                <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                    <span style="font-size: 20px">Material Management</span>
                                </a><br>
                                <small>Create and manage Material Requests</small><br>
                                    
                            </p> 
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                            <div class="float-left">
                                <p><small class="text-muted">Job No</small><br>
                                    <strong>{{count($data['jobs'])}}</strong></p>
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
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="" placeholder="Find!" 
                                            ng-model="filter.keyword">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <select name="main_category" id="main_category" class="select2-container form-control show-tick ms select2" ng-model="filter.main_category">
                                                <option value="">- Select Category -</option>
                                                @foreach($data['main_categories'] as $main_category)
                                                    <option value="{{$main_category['id']}}">{{$main_category['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <select name="main_category" id="main_category" class="select2-container form-control show-tick ms select2" ng-model="filter.main_category">
                                                <option value="">- Select Modal -</option>
                                                @foreach($data['main_categories'] as $main_category)
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
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show" href="{{url('material/index')}}" aria-expanded="true">Request List</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link active show" href="{{url('material/list')}}" aria-expanded="true">Materials</a>
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
            <div class="card">
                <div class="body pt-0 pl-0 pr-0">
                    <div class="table-responsive">
                        <table class="table m-b-0 c_list table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Specs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data">
                                    <td class="text-center">@{{$index+1}}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            @{{detail.code}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-default">
                                            @{{detail.name}}
                                        </span>
                                    </td>
                                    <td>@{{detail.price}}</td>
                                    <td>@{{detail.specs}}</td>
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
            <a class="zoom-fab zoom-btn-md " style="background: black;color:white" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload materials" id="btn-upload">
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
                        <h4 class="modal-title">Upload Materials</h4>
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
                window.location.href = '{{asset('assets/sample_excel/upload_material.xlsx')}}';
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

        app.controller("MaterialRequestController", function($scope,$http){
            $scope.details = null;
            $scope.filter  = {};

            $scope.loadMaterialData = function(){
                $.ajax({
                    url: "{{url('/material/material-data')}}",
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
                    url: "{{url('/material/material-data')}}/?page="+page,
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
                    url: "{{url('/material/upload')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        console.log(data);
                        $scope.$apply();
                        $scope.loadMaterialData();
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