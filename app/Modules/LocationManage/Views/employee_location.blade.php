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
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                            <li class="nav-item inlineblock">
                                <a class="nav-link show" href="{{url('location/list')}}" aria-expanded="true">Locations</a>
                            </li>
                            <li class="nav-item inlineblock">
                                <a class="nav-link active show" href="{{url('location/assignEmployeeToLocationView')}}" aria-expanded="true">Assign Rep</a>
                            </li>
                            <li class="nav-item inlineblock">
                                <a class="nav-link show" href="{{url('location/type/list')}}" aria-expanded="true">Types</a>
                            </li>                                
                        </ul>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-sm">Export Excel</button>
                            <button type="button" class="btn btn-default btn-sm">Find</button>
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
                    <div class="body pl-10 pr-10 pt-10">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                <div class="form-group">
                                    <select name="department" id="department" class="form-control select2"> 
                                        <option value="">--Select Department--</option>
                                        <option ng-repeat="department in departments" value="@{{department.id}}">
                                            @{{department.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                <div class="form-group">
                                    <select name="department" id="department" class="form-control select2"> 
                                        <option value="">--Select Hierarchy--</option>
                                        <option ng-repeat="department_hierarchy in department_hierarchies" value="@{{department_hierarchy.id}}">
                                            @{{department_hierarchy.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                <div class="form-group">
                                    <select name="employee" id="employee" class="form-control select2"> 
                                        <option value="">--Select Employee--</option>
                                        <option ng-repeat="employee in employees" value="@{{employee.id}}">
                                            @{{employee.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                                <div class="form-group">
                                    <select name="location_type" id="location_type" class="form-control select2"> 
                                        <option value="">--Select Location Type--</option>
                                        <option ng-repeat="location_type in location_types" value="@{{location_type.id}}">
                                            @{{location_type.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                                <div class="form-group">
                                    <select name="location" id="location" class="form-control select2"> 
                                        <option value="">--Select Location--</option>
                                        <option ng-repeat="location in locations" value="@{{location.id}}">
                                            @{{location.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button class="btn btn-primary float-right"><i class="fa fa-save"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </div>
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

        $scope.departments = [];
        $scope.department_hierarchies = [];
        $scope.location_types = [];
        $scope.locations = [];

        $.ajax({
            url: "{{url('/department/getDepartments')}}",
            type: 'GET',
            success: function (data) {
                $scope.departments = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $('#department').on('change',function(){
            tmp = $(this).val();
            $.ajax({
                url: "{{url('/hierarchy/getAllHierarchyByDepartment')}}",
                type: 'GET',
                data: {id: tmp},
                success: function (data) {
                    $scope.department_hierarchies = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        });
        
    });//end controller

</script>
@stop