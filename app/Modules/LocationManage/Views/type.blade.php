@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">

<style type="text/css">
    .table-btn{
        background: #1e9cff  !important;
    }

    .table-btn .fas{

        font-size: 12px !important;
        color: white  !important;
    }

    .repeat:hover {
        background-color:#EFEFEF;
    }
    #scrollArea {
        height: 200px;
        overflow: auto;
    }
    .switch.switch-sm{
        width: 30px;
        height: 16px;
    }
    .switch :checked + span {

        border-color: #689A07;
        -webkit-box-shadow: #689A07 0px 0px 0px 21px inset;
        -moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
        box-shadow: #689A07 0px 0px 0px 21px inset;
        -webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        -moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        -o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        background-color: #689A07;

    }

    .bootstrap-tagsinput.error{
        border-color: #d96557;
    }

    .dualmultiselect h4{
            font-size: 17px;
    font-weight: 600;
    padding: 0;
    margin: 0 0 10px -2px;
    }

    .c_list .avatar {
        width: 45px;
         box-shadow: none; 
        border: 1px solid #dedede;
        padding: 3px;
    }
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="LocationTypeController" ng-init="loadData()"> 
    
    <div class="detail-header">
        <div class="card">
            <div class="body">
                <div class="row ">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                        <p class="float-left" style="padding-left: 10px">
                            <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                <span style="font-size: 20px">Location Manager</span>
                            </a><br>
                            <small>Create and manage location hierarchy</small><br>
                                
                        </p> 
                    </div>
                    @foreach($sub_data as $key=>$counts)
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left">
                            <div class="float-left">
                                <p>
                                    <small class="text-muted">{{$key}}</small><br>
                                    <strong>{{$counts}}</strong>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="" method="POST" role="form">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                       <input type="text" id="search_keyword" name="search_keyword" class="form-control show-tick ms" placeholder="Search keyword..." ng-model="keyword">
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
                                <a class="nav-link  show" href="{{url('location/list')}}" aria-expanded="true">Locations</a>
                            </li>
                            <li class="nav-item inlineblock">
                                <a class="nav-link  active show" href="{{url('location/type/list')}}" aria-expanded="true">Types</a>
                            </li>                                
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-sm">Export Excel</button>
                            <button type="button" class="btn btn-default btn-sm" ng-click="find()">Find</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="body pl-0 pr-0 pt-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover m-b-0 c_list">
                                <thead>
                                    <tr>
                                        <th width="6%">#</th>
                                        <th>Type Name</th> 
                                        <th>Under</th>  
                                        <th>Employee Hierarchy</th>  
                                        <th>Created By</th>
                                        <th>Created at</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <tr ng-repeat="location_type in location_types track by $index">
                                            <td>
                                                #@{{$index+1}}
                                            </td>
                                            <td>
                                                <h6 class="mb-0"><a href="">@{{location_type.name}}</a></h6>
                                                <span>#@{{location_type.code}}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success" ng-show="location_type.parent!=null">@{{location_type.parent.name}}</span>
                                                <span class="badge badge-success" ng-show="location_type.parent==null">MAIN LOCATION</span>
                                            </td>
                                            <td>@{{location_type.employee_type.name}}</td>
                                            <td>@{{location_type.createdby.name}}</td>
                                            <td>@{{location_type.created_at}}</td>
                                            <td width="5%">
                                                <button type="button" class="btn btn-outline-info btn-edit" title="Edit" ng-click="editLocationType(location_type.id)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" data-type="confirm" class="btn btn-outline-danger js-sweetalert btn-delete" data-id="@{{location_type.id}}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="zoom">
        <a class="zoom-fab zoom-btn-md " style="background: black;color:white" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="New Location Type" id="btn-add">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <div class="modal fade" id="largeModalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Add New Location</h4>
                </div>
                <form action="" method="POST" role="form" id="role-form-add">
                    {{csrf_field()}}
                    <div class="modal-body"> 

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="" class="required">Parent Location</label>
                                <input type="text" class="form-control" name="parent" id="parent" value="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Location Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Location Name">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Employee Type</label>
                                <select name="emp_type" id="emp_type" class="select2-container form-control show-tick ms select2">
                                    <option value="">- Select Employee Type -</option>
                                    @foreach($emp_types as $emp_type)
                                        <option value="{{$emp_type['id']}}">{{$emp_type['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="largeModalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Update Location Type</h4>
                </div>
                <form action="" method="POST" role="form" id="role-form-edit">
                    {{csrf_field()}}
                    <div class="modal-body"> 

                        <input type="hidden" name="location_type_id" id="inputlocation_type_id" class="form-control" value="@{{edit.id}}">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="" class="required">Location Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Location Type Name"
                                ng-model="edit.name">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Parent</label>
                                <input type="text" readonly="true" class="form-control" name="parent" placeholder="Parent"
                                ng-model="edit.parent.name">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Employee Type</label>
                                <select name="edit_emp_type" id="edit_emp_type" class="select2-container form-control show-tick ms select2">
                                    <option value="">- Select Employee Type -</option>
                                    <option ng-repeat="emp_hierarchy in emp_hierarchies" value="@{{emp_hierarchy.id}}">@{{emp_hierarchy.name}}</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
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
<script src="{{asset('/assets/js/dialog.js')}}"></script>
<script type="text/javascript">

 $(document).ready(function(){

        $(".select2").select2();
 });

 //initialize angular app
var app = angular.module("ngApp",[]);

//controller
app.controller("LocationTypeController", function($scope,$http){

    $scope.edit = {};
    $scope.parent = [];
    $scope.location_types = [];
    $scope.emp_hierarchies = [];

    $.ajax({
        url: '{{url('hierarchy/getDistributionHierarchy')}}',
        type: 'get',
        success: function(response){
            $scope.emp_hierarchies  = response;
            $scope.$apply();

            console.log($scope.emp_hierarchies);
            $('.dialog-loader').hide();
        },
        error: function(Response){               
        }
    });

    $scope.loadData = function(){
        $.ajax({
            url: '{{url('location/type/getLocationTypes')}}',
            type: 'get',
            success: function(data){
                $scope.location_types = data;
                $scope.$apply();
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    }

    $('#btn-add').on('click',function() 
    {
        $('#largeModalAdd').modal('show');
        $.ajax({
            url: '{{url('location/type/getParentType')}}',
            type: 'get',
            success: function(response){
                $scope.parent  = response;
                $("#parent").val(response.name);
                $("#parent").focus();
                $scope.$apply();
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    });

    $("form#role-form-add").submit(function(e) 
    {
        e.preventDefault();    
        var formData = new FormData(this);
        formData.append('parent',$scope.parent.id);

        $('.dialog-loader').show();

        $.ajax({
            url: "{{url('/location/type/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
                $('.dialog-loader').hide();

                if(data.success){
                    swal({
                        title: "Success!",
                        text: data.message,
                    });
                    location.reload();

                }else{
                    $('.dialog-loader').hide();
                    swal({
                        title: "Error!",
                        text: data.message,
                    });
                }

            },
            error:function(data) {
                $('.dialog-loader').hide();
                swal({
                    title: "Error!",
                    text: "Error adding new location type.",
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $scope.editLocationType = function(type_id) 
    {
        $('#largeModalEdit').modal('show');
        $('.dialog-loader').show();
        
        $.ajax({
            url: '{{url('location/type/getLocationTypeById')}}',
            type: 'get',
            data:{'id':type_id},
            success: function(response){
                $scope.edit  = response;
                $scope.$apply();
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    }

    $('.btn-delete').on('click',function() 
    {
        var id = $(this).data('id');

        showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function(isConfirm) {
            if(isConfirm){
                $.ajax({
                    url: '{{url('location/type/delete')}}',
                    type: 'POST',
                    data:{'location_type_id':id,'releated':false},
                    success: function(response){
                        if(response.success){
                            swal("Deleted","All records deleted ", "success");
                            location.reload();
                        }else{
                            if(response.error.code=="5000"){
                                swal("Releated Data", response.error.message, "error");
                            }
                        }
                    },
                    error: function(response){
                        
                    }
                });
            }
        });
    });

    $("form#role-form-edit").submit(function(e) 
    {
        e.preventDefault();    
        var formData = new FormData(this);
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/location/type/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
                if(data.success){
                    swal({
                        title: "Success!",
                        text: data.message,
                    });
                    location.reload();

                }else{
                    $('.dialog-loader').hide();
                    swal({
                        title: "Error!",
                        text: data.message,
                    });
                }
            },
            error:function(data) {
                $('.dialog-loader').hide();
                swal({
                    title: "Error!",
                    text: "Error updating location type.",
                });
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