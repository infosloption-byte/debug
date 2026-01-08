@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-tree-table/tree-grid.css')}}">

<style type="text/css">
    .table{
        background: #fff !important;
    }

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

    .table td {
        padding: 5px 10px 5px 10px;
    }

    .table{
        font-size: small;
    }
</style>
@stop

@section('content')

<div ng-app="ngApp" ng-controller="LocationController" ng-init="loadLocationData(1)"> 
    
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
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select name="loc_type" id="loc_type" class="select2-container form-control show-tick ms select2">
                                            <option value="">- Select Location Type -</option>
                                            @foreach($loc_types as $loc_type)
                                                <option @if(isset($old['loc_type']) && $old['loc_type']==$loc_type['id'])selected @endif value="{{$loc_type['id']}}">{{$loc_type['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                       <input type="text" id="search_keyword" name="search_keyword" class="form-control show-tick ms" placeholder="Search keyword..." ng-model="keyword">
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
                                <a class="nav-link active show" href="{{url('location/list')}}" aria-expanded="true">Locations</a>
                            </li>
                            <li class="nav-item inlineblock">
                                <a class="nav-link show" href="{{url('location/type/list')}}" aria-expanded="true">Types</a>
                            </li>                                
                        </ul>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-sm" ng-click="repAssingView()">Rep Location</button>
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
                    <div class="body pr-0 pl-0 pt-0">
                        <tree-grid tree-data="tree_data" col-defs = "col_defs" aa = "branch_edit"></tree-grid>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="zoom">
      <a class="zoom-fab zoom-btn-md " style="background: black;color:white" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="New Location" id="btn-add"><i class="fas fa-plus"></i></a>
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
                                <label for="" class="required">Location Type</label>
                                <select name="location_type" id="location_type" class="form-control show-tick ms select2">
                                    <option value="0">- Type -</option>
                                    <option ng-value="location_type.id" ng-repeat="location_type in location_types">@{{location_type.name}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Location Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Location Name">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="required">Parent Location</label>
                                <select name="parent_location" id="parent_location" class="form-control show-tick ms select2">
                                    <option value="0">- Select Parent Location -</option>
                                    <option ng-value="location.id" ng-repeat="location in locations">@{{location.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Description</label>
                                <input type="text" class="form-control" name="desc" placeholder="Description">
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
                    <h4 class="title" id="largeModalLabel">Update Location</h4>
                </div>
                <form action="" method="POST" role="form" id="role-form-edit">
                    {{csrf_field()}}
                    <div class="modal-body"> 

                        <input type="hidden" name="location_id" id="inputlocation_id" class="form-control" value="@{{edit.id}}">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="" class="required">Location Name</label>
                                <input type="text" class="form-control" name="name" placeholder="location Name"
                                ng-model="edit.name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="required">Location Type</label>
                                <select name="edit_location_type" id="inputlocationtype" class="form-control show-tick ms select2">
                                    <option>- Select Location Type -</option>
                                    <option ng-value="location_type.id"
                                            ng-repeat="location_type in location_types"
                                            ng-selected="location_type.id==edit.location_type_id">@{{location_type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="" class="required">Parent Location</label>
                                <select name="main_location" id="inputlocation" class="form-control show-tick ms select2">
                                    <option value="0">- Main -</option>
                                    <option ng-value="location.id"
                                            ng-repeat="location in locations_filter"
                                            ng-selected="location.id==edit.parent_id">@{{location.name}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="" class="required">Employee</label>
                                <select name="edit_employee" id="inputeditemployee" class="form-control show-tick ms select2">
                                    <option>--- Select Employee ---</option>
                                    <option ng-value="employee.id"
                                            ng-repeat="employee in employees"
                                            ng-selected="employee.id==edit.employee.employee_id">@{{employee.first_name +" "+ employee.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" ng-show="edit.location_type_id==4">
                                <label for="" class="required">Sales Rep</label>
                                <select name="edit_rep" id="inputeditrep" class="form-control show-tick ms select2">
                                    <option>--- Select Employee ---</option>
                                    <option ng-value="rep.id"
                                            ng-repeat="rep in reps"
                                            ng-selected="rep.id==edit.rep.employee_id">@{{rep.first_name+" "+rep.last_name}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Description</label>
                                <input type="text" class="form-control" name="desc" placeholder="Description"
                                ng-model="edit.description">
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
<script src="{{asset('/assets/dist/ng-tree-table/tree-grid-directive.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>
<script type="text/javascript">

 $(document).ready(function(){

    $(".select2").select2({
        width: 'resolve'
    });
    
 });

 //initialize angular app
var app = angular.module("ngApp",['treeGrid']);

//controller
app.controller("LocationController", function($scope,$http,$log){

    $scope.edit = {};
    $scope.locations = [];
    $scope.locations_filter = [];
    $scope.location_types = [];
    $scope.employees = [];
    $scope.reps = [];
    $scope.branch_edit = {};

    $scope.col_defs = [
        {  field: "code",displayName: "Code" },
        {  field: "loc_type",displayName: "Type" },
        {  field: "description",displayName: "Description" },
        {  field: "employee_type",displayName: "Employee Type" },
        {  field: "employee_name",displayName: "Employee" },
    ];

    $scope.tree_data = [
        {'name':"",'code':'','description':'','location_type':'','employee_type':'','employee_name':''}
    ];

    $.ajax({
        url: '{{url('location/getLocationHierarchy')}}',
        type: 'get',
        data : {type_id: 1},
        success: function(response){
            $scope.tree_data  = response;
            $scope.$apply();
            $('.dialog-loader').hide();
        },
        error: function(response){               
        }
    });

    $.ajax({
        url: '{{url('location/getLocationFlatHierarchyObject')}}',
        type: 'get',
        success: function(response){
            $scope.locations_filter  = response;
            $scope.$apply();
            $('.dialog-loader').hide();
        },
        error: function(Response){               
        }
    });

    $.ajax({
        url: '{{url('location/getLocationTypes')}}',
        type: 'get',
        success: function(response){
            $scope.location_types  = response;
            $scope.$apply();
            $('.dialog-loader').hide();
        },
        error: function(Response){               
        }
    });

    $scope.loadData = function(type_id,keyword)
    {
        $.ajax({
            url: '{{url('location/getLocationHierarchy')}}',
            type: 'get',
            data: {type_id: type_id,keyword:keyword},
            success: function(response){
                $scope.tree_data = response;
                $scope.$apply();
                $('.dialog-loader').hide();
            },
            error: function(response){               
            }
        });
    }

    $('#btn-add').on('click',function() 
    {
        $('#largeModalAdd').modal('show');
    });

    $scope.find = function(){
        type_id = $('#loc_type').val();
        $scope.loadData(type_id,$scope.keyword);
    };

    $scope.loadEmployees = function(loc_type){
        $.ajax({
            url: '{{url('location/getEmployeesByLocationType')}}',
            type: 'get',
            data:{'location_type':loc_type},
            success: function(response){
                $scope.employees = response;
                $scope.$apply();
                $('#inputeditemployee').trigger('change');
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    }

    $scope.loadReps = function(){
        $.ajax({
            url: '{{url('location/getSalesReps')}}',
            type: 'get',
            success: function(response){
                $scope.reps = response;
                $scope.$apply();
                $('#inputeditrep').trigger('change');
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    }

    $('#location_type').on('change',function() 
    {
        type_id = $(this).val();
        $.ajax({
            url: '{{url('location/getParentLocationsByType')}}',
            type: 'get',
            data: {type_id: type_id},
            success: function(response){
                $scope.locations  = response;
                $scope.$apply();
                $('.dialog-loader').hide();
            },
            error: function(response){               
            }
        });
    });

    $("form#role-form-add").submit(function(e) 
    {
        e.preventDefault();    
        var formData = new FormData(this);
        $('.dialog-loader').show();

        $.ajax({
            url: "{{url('/location/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
                $('.dialog-loader').hide();
                swal({
                    title: "Success!",
                    text: "New location addedd successfuly.",
                });
                location.reload();

            },
            error:function(data) {
                $('.dialog-loader').hide();
                swal({
                    title: "Error!",
                    text: "Error adding new location.",
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $scope.$watch('branch_edit', function()
    {
        if($scope.branch_edit.id != undefined){
            var id = $(this).data('id');
            $('.dialog-loader').show();
            
            $.ajax({
                url: '{{url('location/getLocation')}}',
                type: 'get',
                data:{'id':$scope.branch_edit.id},
                success: function(response){
                    $scope.edit  = response;
                    $scope.$apply();
                    $('.select2').trigger('change');
                    $scope.loadEmployees($scope.edit.location_type_id);
                    $scope.loadReps();
                    $('.dialog-loader').hide();
                    $('#largeModalEdit').modal('show');
                },
                error: function(Response){               
                }
            });
        }
    });

    $('.btn-edit').on('click',function() 
    {
        $('#largeModalEdit').modal('show');
        var id = $(this).data('id');
        $('.dialog-loader').show();
        
        $.ajax({
            url: '{{url('location/getlocation')}}',
            type: 'get',
            data:{'id':$scope.branch_edit},
            success: function(response){
                $scope.edit  = response;
                $scope.$apply();
                $('.select2').trigger('change');
                $('.dialog-loader').hide();
            },
            error: function(Response){               
            }
        });
    });

    $('.btn-delete').on('click',function() 
    {
        var id = $(this).data('id');

        showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function(isConfirm) {
            if(isConfirm){
                $.ajax({
                    url: '{{url('location/delete')}}',
                    type: 'POST',
                    data:{'location_id':id,'releated':false},
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
            url: "{{url('/location/checkLocationAssignedDetails')}}",
            type: 'get',
            data: {
                emp : $('#inputeditemployee').val(),
                loc : $('#inputlocation_id').val()
            },
            success: function (data) {
                if(data.emp_status && data.loc_status){
                    $.ajax({
                        url: "{{url('/location/update')}}",
                        type: 'POST',
                        dataType : 'json',
                        data: formData,
                        success: function (data) {
                            $('.dialog-loader').hide();
                            swal({
                                title: "Success!",
                                text: "New location update successfuly.",
                            });
                            
                            $.ajax({
                                url: '{{url('location/getLocationFlatHierarchyObject')}}',
                                type: 'get',
                                success: function(response){
                                    $scope.locations_filter  = response;
                                    $scope.$apply();
                                    $('.dialog-loader').hide();
                                },
                                error: function(Response){               
                                }
                            });
                        },
                        error:function(data) {
                            $('.dialog-loader').hide();
                            swal({
                                title: "Error!",
                                text: "Error updating location.",
                            });
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                }else{
                    showConfirmMessage('Override','This Location or Employee already assigned. Do you want to Override','Override','error',function(isConfirm) {
                        if(isConfirm){
                            $.ajax({
                                url: "{{url('/location/update')}}",
                                type: 'POST',
                                dataType : 'json',
                                data: formData,
                                success: function (data) {
                                    $('.dialog-loader').hide();
                                    swal({
                                        title: "Success!",
                                        text: "New location update successfuly.",
                                    });
                                    $.ajax({
                                        url: '{{url('location/getLocationFlatHierarchyObject')}}',
                                        type: 'get',
                                        success: function(response){
                                            $scope.locations_filter  = response;
                                            $scope.$apply();
                                            $('.dialog-loader').hide();
                                        },
                                        error: function(Response){               
                                        }
                                    });
                                },
                                error:function(data) {
                                    $('.dialog-loader').hide();
                                    swal({
                                        title: "Error!",
                                        text: "Error updating location.",
                                    });
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }
                    });
                }
            },
            error:function(data) {
                $('.dialog-loader').hide();
                swal({
                    title: "Error!",
                    text: "Error updating location.",
                });
            }
        });
        return false;
    });   
    
});//end controller

</script>
@stop