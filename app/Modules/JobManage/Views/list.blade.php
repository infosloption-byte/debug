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
    <div ng-app="ngApp" ng-controller="JobController" ng-init="loadJobData();"> 
        <div class="detail-header">
            <div class="card">
                <div class="body">
                    <div class="row ">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                            <p class="float-left" style="padding-left: 10px">
                                <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                    <span style="font-size: 20px">Job Management</span>
                                </a><br>
                                <small>Create and manage jobs</small><br>
                                    
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
                                    <a class="nav-link active show" href="{{url('job/index')}}" aria-expanded="true">List</a>
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
                                    <th>Job No</th>
                                    <th>Inquiry</th>
                                    <th>Asset</th>
                                    <th>Inquiry Detail</th>
                                    <th>Technician</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Start</th>
                                    <th>Stopped</th>
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
                                            @{{detail.inquiry.code}}
                                        </span>
                                    </td>
                                    <td>@{{detail.asset.asset_no}}</td>
                                    <td>@{{detail.inquiry.remark}}</td>
                                    <td>
                                        @{{detail.technician.name}}
                                    </td>
                                    <td>@{{detail.remark}}</td>
                                    <td>
                                        <span class="badge badge-warning" ng-show="detail.status==0">PENDING</span>
                                        <span class="badge badge-info" ng-show="detail.status==3">In Service</span>
                                        <span class="badge badge-success" ng-show="detail.status==1">JOB DONE</span>
                                    </td>
                                    <td>
                                        <span ng-show="detail.start_at==Null" class="badge badge-info float-center" title="Click to start job" style="margin-right: 10px;background: #3c89da;cursor: pointer;" ng-click="startClock(detail)">
                                            <i class="fa fa-play-circle" style="color: #fff"></i>
                                        </span>
                                        <span ng-show="detail.start_at!=Null" class="badge badge-info float-center" style="margin-right: 10px;background: #3c89da;cursor: pointer;color: #fff">
                                            @{{detail.start_at | amDateFormat:'MMM DD, YYYY'}}<br>
                                            @{{detail.start_at | amDateFormat:'H : i : s'}}
                                        </span>
                                    </td>
                                    <td>
                                        <span ng-show="detail.start_at==Null && detail.stopped_at==Null" class="badge badge-default float-center" title="Click to stop disabled" style="margin-right: 10px;cursor: pointer;">
                                            <i class="fa fa-stop-circle"></i>
                                        </span>
                                        <span ng-show="detail.start_at!=Null && detail.stopped_at==Null" class="badge badge-danger float-center" title="Click to start job" style="margin-right: 10px;background: #DE4848;cursor: pointer;" ng-click="stopClock(detail)">
                                            <i class="fa fa-stop-circle" style="color: #fff"></i>
                                        </span>
                                        <span ng-show="detail.start_at!=Null && detail.stopped_at!=Null" class="badge badge-danger float-center" style="margin-right: 10px;background: #DE4848;cursor: pointer;color: #fff">
                                            @{{detail.stopped_at | amDateFormat:'MMM DD, YYYY'}}<br>
                                            @{{detail.stopped_at | amDateFormat:'H : i : s'}}
                                        </span>
                                    </td>
                                    <td>
                                        @{{detail.created_by.employee.first_name}} @{{detail.created_by.employee.last_name}}
                                        <br>
                                        @{{detail.created_at | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td>
                                        <span ng-show="detail.status==0" class="badge badge-info float-center" title="Click send to service" style="margin-right: 10px;background: #3c89da;cursor: pointer;" ng-click="createService(detail)">
                                            <i class="fa fa-crosshairs" style="color: #fff"></i>
                                        </span>

                                        <span ng-show="detail.status==1" class="badge badge-default float-center" title="Service Disabled" style="margin-right: 10px;">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>

                                        <span ng-show="detail.status==0" class="badge badge-success float-center" title="Click to finish job" style="margin-right: 10px;background: #22af46;cursor: pointer;" ng-click="doneJob(detail)">
                                            <i class="fa fa-check" style="color: #fff"></i>
                                        </span>

                                        <span ng-show="detail.status!=0" class="badge badge-default float-center" title="Click Disabled" style="margin-right: 10px;cursor: pointer;">
                                            <i class="fa fa-check"></i>
                                        </span>

                                        <span class="badge badge-primary float-center" title="Click to request materials" style="margin-right: 10px;cursor: pointer;background: #01B2C6;color: #ffffff" ng-click="requestMaterial(detail)">Materials
                                        </span>
                                        <span class="badge badge-warning float-center" title="Click to request materials" style="margin-right: 10px;cursor: pointer;background: #F3AD06;color: #ffffff" ng-click="viewDetails(detail)">View
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
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">#</th>
                                                    <th>Material</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="material in materials.data">
                                                    <td class="text-center">@{{$index+1}}</td>
                                                    <td>
                                                        @{{material.name}}
                                                        <br>
                                                        <span class="badge badge-info">
                                                            @{{material.code}}
                                                        </span>
                                                    </td>
                                                    <td>@{{material.price}}</td>
                                                    <td>
                                                        <span class="badge badge-success float-center" title="Add to cart" style="margin-right: 10px;cursor: pointer;" ng-click="addToCart(material)"><i class="fa fa-plus"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <paging page="materials.current_page" page-size="materials.per_page" total="materials.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="findMaterials(filter,page)">
                                    </div>  
                                </div>
                                <div class="col-md-5">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="40%">Material</th>
                                                    <th width="60%">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="cart_item in cart_items">
                                                    <td>@{{cart_item.code}}</td>
                                                    <td>
                                                        <input type="text" id="cart_item_@{{cart_item.id}}" ng-keyup="setQuantity(cart_item.id)" class="form-control" placeholder="Qty">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <textarea class="form-control" id="request_remark" name="request_remark" placeholder="Enter Remark"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="saveRequest()">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-service">
            <div class="modal-dialog modal-md">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Create Service</h4>
                    </div>
                    <form method="POST" role="form" id="form-service-create">
                        <input type="hidden" name="job_id" id="job_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Job</label>
                                        <input type="text" class="form-control" id="_jb_code" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Asset</label>
                                        <input type="text" class="form-control" id="_asst_id" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Service Type</label>
                                        <select class="form-control select2" name="service_type" id="service_type">
                                            <option value="0">--Select Service Type--</option>
                                            <option ng-repeat="service_type in service_types" value="@{{service_type.id}}">@{{service_type.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 div-provider" style="display: none">
                                    <div class="form-group">
                                        <label>Service Provider</label>
                                        <select class="form-control select2" name="service_provider" id="service_provider">
                                            <option value="0">--Select Service Provider--</option>
                                            <option ng-repeat="service_provider in service_providers" value="@{{service_provider.id}}">@{{service_provider.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Service Cost</label>
                                        <input type="text" class="form-control" name="service_cost" id="service_cost" placeholder="Enter cost amount">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Service M/Hour</label>
                                        <input type="text" class="form-control" name="service_manhour" id="service_manhour" placeholder="Enter total man hour">
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

        <div class="modal fade" id="modal-job-done">
            <div class="modal-dialog modal-md">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Complete Job</h4>
                    </div>
                    <form method="POST" role="form" id="form-job-done">
                        <input type="hidden" name="done_job_id" id="done_job_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Technician Remark</label>
                                        <textarea class="form-control" name="done_remark" placeholder="Enter Remark"></textarea>
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

        <div class="modal fade" id="modal-view-detail">
            <div class="modal-dialog modal-lg">
                <div class="dialog-loader">
                    <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
                </div>
                <div class="modal-content">
                    <div class="modal-header text-left">
                        <h4 class="modal-title">Job History - @{{job_detail.code}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="body pt-0 pl-0 pr-0">
                                <div class="row" style="padding-left: 20px;padding-right: 20px">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <table>
                                            <tr>
                                                <td>Inquiry</td>
                                                <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                                <td>@{{job_detail.inquiry.code}}</td>
                                            </tr>
                                            <tr>
                                                <td>Asset</td>
                                                <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                                <td>@{{job_detail.asset.asset_no}}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <table>
                                            <tr>
                                                <td>Technician</td>
                                                <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                                <td>@{{job_detail.technician.name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td style="padding-left: 15px;padding-right: 15px"> - </td>
                                                <td>
                                                    <span class="badge badge-warning" ng-show="job_detail.status==0">PENDING</span>
                                                    <span class="badge badge-info" ng-show="job_detail.status==3">In Service</span>
                                                    <span class="badge badge-success" ng-show="job_detail.status==1">JOB DONE</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <hr style="margin-left: 20px;margin-right: 20px">
                                <div class="row" style="padding-left: 20px;padding-right: 20px;">
                                    <div class="col-md-6" style="text-align: left">
                                        Material Requests
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <span class="badge badge-info">@{{job_detail.material_request.code}}</span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" style="height: auto!important">
                                            <table class="table m-b-0 c_list table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Code</td>
                                                        <td>Name</td>
                                                        <td>Price</td>
                                                        <td>Qty</td>
                                                        <td>Amount</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="mat_req in job_detail.material_request.details">
                                                        <td>@{{mat_req.material.code}}</td>
                                                        <td>@{{mat_req.material.name}}</td>
                                                        <td>@{{mat_req.price}}</td>
                                                        <td>@{{mat_req.qty}}</td>
                                                        <td>@{{mat_req.price*mat_req.qty}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-left: 20px;margin-right: 20px">
                                <div class="row" style="padding-left: 20px;padding-right: 20px;">
                                    <div class="col-md-6" style="text-align: left">
                                        Service Details
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <span class="badge badge-info">@{{job_detail.service.code}}</span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" style="height: auto!important">
                                            <table class="table m-b-0 c_list table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Code</td>
                                                        <td>Remark</td>
                                                        <td>Type</td>
                                                        <td>Ser. Provider</td>
                                                        <td>Provider Remark</td>
                                                        <td>Cost</td>
                                                        <td>Man Hour</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="service in job_detail.services">
                                                        <td>@{{service.code}}</td>
                                                        <td>@{{service.remark}}</td>
                                                        <td>@{{service.service_type.name}}</td>
                                                        <td>@{{service.service_provider.name}}</td>
                                                        <td>@{{service.provider_remark}}</td>
                                                        <td>@{{service.cost}}</td>
                                                        <td>@{{service.manhour}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        app.controller("JobController", function($scope,$http){
            $scope.details = null;
            $scope.service_types = null;
            $scope.service_providers = null;
            $scope.filter  = {};
            $scope.job_detail  = [];

            $scope.cart_items  = [];

            $.ajax({
                url: "{{url('/service/get-service-types')}}",
                type: 'GET',
                success: function (data) {
                    $scope.service_types = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            $.ajax({
                url: "{{url('/service/get-service-providers')}}",
                type: 'GET',
                success: function (data) {
                    $scope.service_providers = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            $scope.loadJobData = function(){
                $.ajax({
                    url: "{{url('/job/get-job-data')}}",
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
                    url: "{{url('/job/get-job-data')}}/?page="+page,
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

            $scope.requestMaterial = function (job) {
                $.ajax({
                    url: "{{url('/material/material-data')}}",
                    type: 'GET',
                    data: $scope.filter,
                    success: function (data) {
                        $scope.materials = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });

                $('#job_id_mat').val(job.id);
                $('#modal-material').modal('show');
            }

            $scope.findMaterials = function(){
                $.ajax({
                    url: "{{url('/material/material-data')}}/?page="+page,
                    type: 'GET',
                    data: $scope.filter,
                    success: function (data) {
                        $scope.materials = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            };

            $scope.addToCart = function(material){
                tmp = 0;
                $.each($scope.cart_items,function(k,vl){
                    if(material.code==vl.code){
                        tmp++;
                    }
                });
                if(tmp==0){
                    material['qty'] = 0;
                    $scope.cart_items.push(material);
                }

            }

            $scope.setQuantity = function(mat_id){
                $.each($scope.cart_items,function(k,vl){
                    if(mat_id == vl.id){
                        vl.qty = $('#cart_item_'+mat_id).val();
                    }
                });
            }

            $scope.saveRequest = function(){
                jb_id = $('#job_id_mat').val();
                request_remark = $('#request_remark').val();

                var formData = new FormData();
                formData.append('job_id',jb_id);
                formData.append('remark',request_remark);
                formData.append('materials',angular.toJson($scope.cart_items));

                $.ajax({
                    url: "{{url('/job/save-material-request')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        console.log(data);
                        if(data.status==1){
                            swal('Done!','Material request placed','success');
                            $scope.loadJobData();
                            location.reload();
                        }else{
                            swal('Error!','Material request faild','error');
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

            $('#service_type').on('change',function(){
                if($("#service_type option:selected").text()=='External'){
                    $('.div-provider').css('display','inline-block');
                }else if($("#service_type option:selected").text()=='Internal'){
                    $('.div-provider').css('display','none');
                }
            });

            $scope.createService = function (job) {
                $('#job_id').val(job.id);
                $('#_jb_code').val(job.code);
                $('#_asst_id').val(job.asset.asset_no);
                $('#modal-service').modal('show');
            }

            $("form#form-service-create").submit(function(e) {
                e.preventDefault();    
                var formData = new FormData(this);
                $('.dialog-loader').show();

                $.ajax({
                    url: "{{url('/job/create-service')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        if(data.status==1){
                            swal('Done!','Asset send to service','success');
                            $scope.loadJobData();
                            location.reload();
                        }else{
                            swal('Error!','Asset not send to service','error');
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

            $scope.doneJob = function (job) {
                $('#done_job_id').val(job.id);
                $('#modal-job-done').modal('show');
            }

            $("form#form-job-done").submit(function(e) {
                e.preventDefault();    
                var formData = new FormData(this);
                $('.dialog-loader').show();

                $.ajax({
                    url: "{{url('/job/finish-job')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        if(data.status==1){
                            swal('Done!','Job Done','success');
                            $scope.loadJobData();
                            location.reload();
                        }else{
                            swal('Error!','Job connot complete','error');
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

            $scope.viewDetails = function(job){
                $scope.job_detail = job;

                console.log($scope.job_detail);

                $('#modal-view-detail').modal('show');
            }

            $scope.startClock = function(job){
                $.ajax({
                    url: "{{url('/job/start-clock')}}/"+job.id,
                    type: 'POST',
                    success: function (data) {
                        $('.dialog-loader').hide();
                        if(data.status==1){
                            swal('Done!','Clock started','success');
                            $scope.loadJobData();
                            // location.reload();
                        }else{
                            swal('Error!','Job cannot start','error');
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

            $scope.stopClock = function(job){
                $.ajax({
                    url: "{{url('/job/stop-clock')}}/"+job.id,
                    type: 'POST',
                    success: function (data) {
                        $('.dialog-loader').hide();
                        if(data.status==1){
                            swal('Done!','Clock stopped','success');
                            $scope.loadJobData();
                            // location.reload();
                        }else{
                            swal('Error!','Job cannot stop','error');
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