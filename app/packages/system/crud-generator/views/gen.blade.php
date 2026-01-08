@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">

<style type="text/css">
	
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="NgController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	               </a>CRUD Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row float-right">
	                <div class="col-md-12 ">
	                	<ul class="breadcrumb ">
		                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
		                    <li class="breadcrumb-item">CRUD Management</li>
		                    <li class="breadcrumb-item active">CRUD</li>
		                </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	 <!-- crud:generate Test --fields="title#string; content#text; category#select#options=technology,tips,health" --view-path=test --controller-namespace=Test --route-group=test -->

	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12">
	        <div class="card">
	        	<form action="" method="POST" role="form">
	        		{!! csrf_field() !!}
		        	<div class="body">
		        		
		        		<p>Module Config</p>
		        		<hr>
		        		<div class="row">
		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>Module Name</label>
		        				<input type="text" name="module" id="input" class="form-control" >
		        			</div>

		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>Namespace</label>
		        				<input type="text" name="namespace" id="input" class="form-control" >
		        			</div>

		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>Route Prefix</label>
		        				<input type="text" name="prefix" id="input" class="form-control" >
		        			</div>

		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>View Path</label>
		        				<input type="text" name="view_path" id="input" class="form-control" >
		        			</div>

		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>Model</label>
		        				<input type="text" name="model" id="input" class="form-control" >
		        			</div>

		        			<!-- <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		        				<label>Create Table</label>
		        				<div class="checkbox">
		        					<label>
		        						<input type="checkbox" value="1" name="create_table">
		        						Yes / No
		        					</label>
		        				</div>
		        			</div> -->

		        		</div>

		        		<hr style="border-color: #fff">
		        		<p>Module Fields</p>
		        		<hr>
		        		
		        		<div class="row" ng-repeat="field in fields" style="margin-top: 10px">
		        			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		        				<label>Field</label>
		        				<input type="text" name="fields[]" id="input" class="form-control" >
		        			</div>
		        			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		        				<label>Type</label>
		        				<select name="types[]" id="input" class="form-control">
		        					<option value="string">string</option>
		        					<option value="text">text</option>
		        					<option value="select">select</option>
		        					<option value="integer">integer</option>
		        				</select>
		        			</div>
		        			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		        				<label>Options</label>
		        				<input type="text" name="options[]" id="input" class="form-control" >
		        			</div>
		        			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
		        				<button type="button" class="btn btn-default" style="margin-top: 28px"
		        				ng-click="add()">+</button>
		        				<button type="button" class="btn btn-default" style="margin-top: 28px"
		        				ng-click="remove($index)">-</button>
		        			</div>
		        		</div>

		       			<hr>
		        		<div class="row" s>
		        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
				        		<button type="submit" class="btn btn-primary">Submit</button>
				        	</div>
		        		</div>

		        	</div>


		        	
	        	</form>
	        </div>
	    </div>
	</div>




</div>

@stop


@section('js')

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>
<script src="{{asset('assets/dist/ng-image/angular.img-fallback.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular-bootstrap/ui-bootstrap-tpls-0.14.3.min.js')}}"></script>
<script src="{{asset('assets/dist/angular/angular/angular-sanitize.min.js')}}"></script>

<script type="text/javascript">

 $(document).ready(function(){

 		$(".select2").select2();

 		@if(session('success'))
            toastr.success('Module Successfully Added.', 'Good Job!');
        @elseif(session('error'))
            toastr.error('Problem occured with adding Module.', 'Oh Snap!');
        @endif
 	
 });

 //initialize angular app
var app = angular.module("ngApp",['dualmultiselect','angularImgFallback']);


//controller
app.controller("NgController", function($scope,$http,$sce){

	$scope.fields = [{}];


	$scope.add = function() {
		$scope.fields.push({});
	}

	$scope.remove = function($index) {
		$scope.fields.splice(-1,$index);
	}


  	
});//end controller




</script>
@stop
