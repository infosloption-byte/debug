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
    <div ng-app="ngApp" ng-controller="MaterialRequestController" ng-init="loadRequestData();"> 
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
                                    <a class="nav-link active show" href="{{url('material/index')}}" aria-expanded="true">Request List</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show" href="{{url('material/list')}}" aria-expanded="true">Materials</a>
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
                                    <th>Job</th>
                                    <th>Technician</th>
                                    <th>Asset</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Action</th>
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
                                            @{{detail.job.code}}
                                        </span>
                                    </td>
                                    <td>
                                        @{{detail.technician.first_name}} @{{detail.technician.last_name}}
                                    </td>
                                    <td>@{{detail.asset.serial_no}}</td>
                                    <td>@{{detail.request_remark}}</td>
                                    <td>
                                        <span class="badge badge-warning" ng-show="detail.status==0">PENDING</span>
                                        <span class="badge badge-info" ng-show="detail.status==1">PROVIDED</span>
                                        <span class="badge badge-success" ng-show="detail.status==2">REJECTED</span>
                                    </td>
                                    <td>
                                        @{{detail.created_by.employee.first_name}} @{{detail.created_by.employee.last_name}}
                                        <br>
                                        @{{detail.created_at | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td>
                                        <span ng-show="detail.status==0" class="badge badge-success float-center" title="Click Approve Materials" style="margin-right: 10px;background: #3c89da;cursor: pointer;" ng-click="approveMaterials(detail.id)">
                                            <i class="fa fa-check-square" style="color: #fff"></i>
                                        </span>

                                        <span ng-show="detail.status==0" class="badge badge-danger float-center" title="Click reject request" style="margin-right: 10px;background: #DE4848;cursor: pointer;" ng-click="rejectRequest(detail.id)">
                                            <i class="fa fa-window-close" style="color: #fff"></i>
                                        </span>

                                        <span class="badge badge-info float-center" title="View Details" style="margin-right: 10px;cursor: pointer;" ng-click="showDetails(detail.details)">
                                            <i class="fa fa-eye"></i>
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

        <div class="modal fade" id="modal-material">
            <div class="modal-dialog modal-lg">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Request Materials</h4>
                    </div>
                    <form method="POST" role="form" id="form-service-create">
                        <input type="hidden" name="job_id_mat" id="job_id_mat">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">#</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="material in materials">
                                                    <td class="text-center">@{{$index+1}}</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            @{{material.material.code}}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @{{material.material.name}}
                                                    </td>
                                                    <td>@{{material.qty}}</td>
                                                    <td>@{{material.price}}</td>
                                                    <td>@{{material.qty*material.price}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            $scope.materials  = [];

            $scope.loadRequestData = function(){
                $.ajax({
                    url: "{{url('/material/get-request-data')}}",
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
                    url: "{{url('/material/get-request-data')}}/?page="+page,
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

            $scope.showDetails = function (materials) {
                $scope.materials = materials;
                $('#modal-material').modal('show');
            }

            $scope.approveMaterials = function (request_id) {
                $.ajax({
                    url: "{{url('/material/approve')}}/"+request_id,
                    type: 'POST',
                    success: function (data) {
                        $('.dialog-loader').hide();
                        console.log(data);
                        if(data.status==1){
                            swal('Done!','Request Approved','success');
                            location.reload();
                        }else{
                            swal('Error!','Request connot complete','error');
                        }
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

            $scope.rejectRequest = function (request_id) {
                $.ajax({
                    url: "{{url('/material/reject')}}/"+request_id,
                    type: 'POST',
                    success: function (data) {
                        $('.dialog-loader').hide();
                        console.log(data);
                        if(data.status==1){
                            swal('Done!','Request Rejected','success');
                            location.reload();
                        }else{
                            swal('Error!','Request connot reject','error');
                        }
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

    </script>
@stop