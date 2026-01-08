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
    <div ng-app="ngApp" ng-controller="WorkController" ng-init="loadWorkData();"> 
        <div class="detail-header">
            <div class="card">
                <div class="body">
                    <div class="row ">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                            <p class="float-left" style="padding-left: 10px">
                                <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                    <span style="font-size: 20px">Work Management</span>
                                </a><br>
                                <small>Create and manage work requests</small><br>
                                    
                            </p> 
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                            <div class="float-left">
                                <p><small class="text-muted">Work Requests</small><br>
                                    <strong>{{count($data['works'])}}</strong></p>
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
                                    <a class="nav-link active show" href="{{url('workrequest/index')}}" aria-expanded="true">List</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show" href="{{url('workrequest/create')}}" aria-expanded="true">Create</a>
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
                                    <th>Reference No</th>
                                    <th>Work Type</th>
                                    <th>Asset</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Approved</th>
                                    <th>Rejected</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data">
                                    <td class="text-center">@{{$index+1}}</td>
                                    <td>@{{detail.code}}</td>
                                    <td>@{{detail.work_type.type}}</td>
                                    <td>@{{detail.asset.asset_no}}</td>
                                    <td>@{{detail.remark}}</td>
                                    <td>
                                        <span class="badge badge-warning" ng-show="detail.status==0">PENDING</span>
                                        <span class="badge badge-success" ng-show="detail.status==1">APPROVED</span>
                                        <span class="badge badge-danger" ng-show="detail.status==2">REJECTED</span>
                                        <span class="badge badge-info" ng-show="detail.status==3">JOB CREATED</span>
                                    </td>
                                    <td>
                                        @{{detail.created_by.employee.first_name}} @{{detail.created_by.employee.last_name}}
                                        <br>
                                        @{{detail.created_at | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td>
                                        @{{detail.approved_by.employee.first_name}} @{{detail.approved_by.employee.last_name}}
                                        <br>
                                        @{{detail.approved_at | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td>
                                        @{{detail.rejected_by.employee.first_name}} @{{detail.rejected_by.employee.last_name}}
                                        <br>
                                        @{{detail.rejected_at | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td>
                                        <span ng-show="detail.status==0" class="badge badge-success float-center" title="Approve Work" style="margin-right: 10px;background: #22af46;cursor: pointer;" ng-click="approveWork(detail.id)">
                                            <i class="fa fa-check" style="color: #fff"></i>
                                        </span>
                                        <span ng-show="detail.status==0" class="badge badge-danger float-center" title="Reject Work" style="margin-right: 10px;background: #de4848;cursor: pointer;" ng-click="rejectWork(detail.id)">
                                            <i class="fa fa-times" style="color: #fff"></i>
                                        </span>

                                        <span ng-show="detail.status!=0" class="badge badge-default float-center" title="Disabled" style="margin-right: 10px;cursor: pointer;">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <span ng-show="detail.status!=0" class="badge badge-default float-center" title="Disabled" style="margin-right: 10px;cursor: pointer;">
                                            <i class="fa fa-times"></i>
                                        </span>

                                        <span ng-show="detail.status==1" class="badge badge-info float-center" title="Click to create job" style="margin-right: 10px;background: #3c89da;cursor: pointer;" ng-click="createJob(detail)">
                                            <i class="fa fa-crosshairs" style="color: #fff"></i>
                                        </span>

                                        <span ng-show="detail.status!=1" class="badge badge-default float-center" title="Disabled" style="margin-right: 10px;cursor: pointer;">
                                            <i class="fa fa-crosshairs"></i>
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

        <div class="modal fade" id="modal-job">
            <div class="modal-dialog modal-md">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Create Job</h4>
                    </div>
                    <form method="POST" role="form" id="form-job-create">
                        <input type="hidden" name="work_id" id="work_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Asset</label>
                                        <input type="text" class="form-control" id="_asst_id" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Work Type</label>
                                        <input type="text" class="form-control" id="_work_type" disabled="disabled">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Technician</label>
                                        <select class="form-control select2" name="technician">
                                            <option value="0">--Select Technician--</option>
                                            <option value="1">--Super Admin--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea class="form-control" name="remark" placeholder="Enter Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
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

        app.controller("WorkController", function($scope,$http){
            $scope.details = null;
            $scope.filter  = {};

            $scope.loadWorkData = function(){
                $.ajax({
                    url: "{{url('workrequest/get-work-data')}}",
                    type: 'GET',
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
                    url: "{{url('workrequest/get-work-data')}}/?page="+page,
                    type: 'GET',
                    success: function (data) {
                        $scope.details = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            }

            $scope.approveWork = function (id) {
                $.ajax({
                    url: "{{url('workrequest/approve')}}",
                    type: 'POST',
                    data: {'id':id},
                    success: function (data) {
                        $scope.details = data;
                        $scope.$apply();

                        $scope.loadWorkData();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            }

            $scope.rejectWork = function (id) {
                $.ajax({
                    url: "{{url('workrequest/reject')}}",
                    type: 'POST',
                    data: {'id':id},
                    success: function (data) {
                        $scope.details = data;
                        $scope.$apply();

                        $scope.loadWorkData();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            }

            $scope.createJob = function (data) {
                $('#work_id').val(data.id);
                $('#_cmp_code').val(data.code);
                $('#_asst_id').val(data.asset.asset_no);
                $('#_work_type').val(data.workType.type);
                $('#modal-job').modal('show');   
            }

            $("form#form-job-create").submit(function(e) {
                e.preventDefault();    
                var formData = new FormData(this);
                $('.dialog-loader').show();

                $.ajax({
                    url: "{{url('/workrequest/create-job')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        $scope.details = data;
                        $scope.$apply();

                        $scope.loadWorkData();

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