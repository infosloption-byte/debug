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

   <div ng-app="ngApp" ng-controller="WorkController"> 
        <div class="detail-header">
            <div class="card">
                <div class="body">
                    <div class="row ">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
                            <p class="float-left" style="padding-left: 10px">
                                <a href="{{url('warehouse/show')}}/@{{item.id}}" title="View details" style="color: black">
                                    <span style="font-size: 20px">Work Request Management</span>
                                </a><br>
                                <small>Create and manage work requests</small><br>
                                    
                            </p> 
                        </div>
                       
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <ul class="nav nav-tabs-new2" style="margin-top: 6px">
                                <li class="nav-item inlineblock">
                                    <a class="nav-link show" href="{{url('workrequest/index')}}" aria-expanded="true">List</a>
                                </li>
                                <li class="nav-item inlineblock">
                                    <a class="nav-link active show" href="{{url('workrequest/index')}}" aria-expanded="true">Create</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                            <span class="input-group-btn">
                                
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="card">
                <div class="body pt-0 pl-0 pr-0">
                    <form action="" method="POST" role="form" id="form-create">
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Asset Category</label>
                                    <select name="_main_category" id="_main_category" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Category -</option>
                                        @foreach($data['main_categories'] as $main_category)
                                            <option value="{{$main_category['id']}}">{{$main_category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Asset Modal</label>
                                    <select name="_category" id="_category" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Category -</option>
                                        <option ng-repeat="category in categories" value="@{{category.id}}">@{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Work Type</label>
                                      <select name="_work_type" id="_work_type" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Work Type -</option>
                                        @foreach($data['work_types'] as $work_type)
                                            <option value="{{$work_type->id}}">{{$work_type->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                       
                            
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Select Asset</label>
                                    <select name="_asset" id="_asset" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Asset -</option>
                                        <option ng-repeat="asset in assets" value="@{{asset.id}}">@{{asset.serial_no}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="work_title" name="work_title" placeholder="Enter work title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="work_remark" id="work_remark" placeholder="Enter remark"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary float-right">Send</button>
                            </div>
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
            $scope.filter  = {};
            $scope.categories  = [];
            $scope.assets  = [];

            $('#_main_category').change(function(){
                $.ajax({
                    url: "{{url('category/getCategoriesByMainId')}}",
                    type: 'GET',
                    data: {id: $(this).val()},
                    success: function (data) {
                        $scope.categories = data;
                        $scope.$apply();

                        $scope.loadAssets({main_id : $(this).val()});
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            });

            $('#_category').change(function(){
                $scope.loadAssets({cat_id : $(this).val()});
            });

            $scope.loadAssets = function(param){
                $.ajax({
                    url: "{{url('asset/getAssetsByCategoryId')}}",
                    type: 'GET',
                    data: param,
                    success: function (data) {
                        $scope.assets = data;
                        $scope.$apply();
                    },
                    error:function(data) {
                      $('.dialog-loader').hide();
                    }
                });
            }

            $("form#form-create").submit(function(e) {
                e.preventDefault();    
                var formData = new FormData(this);
                $('.dialog-loader').show();

                $.ajax({
                    url: "{{url('/workrequest/create')}}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('.dialog-loader').hide();
                        if(data.status==1){
                            swal('Done!','Work submitted','success');
                            location.reload();
                        }else{
                            swal('Error!','Work not submitted','error');
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

        });

    </script>
@stop