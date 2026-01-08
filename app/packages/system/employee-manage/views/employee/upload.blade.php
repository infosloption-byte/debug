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
	}
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="EmployeeController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	               </a>Employee Management</a>
	               
	           </h2>
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12 ">
	            <div class="row">
	                <ul class="breadcrumb float-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
	                    <li class="breadcrumb-item">Employee Management</li>
	                    <li class="breadcrumb-item active">Employee Upload</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Employee Upload</h2>
	                <ul class="header-dropdown">

	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                	
		            </div>
		            
	            </div>
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

<script type="text/javascript">

 $(document).ready(function(){

 		$(".select2").select2();
 });

 //initialize angular app
var app = angular.module("ngApp",['dualmultiselect','angularImgFallback']);

//controller
app.controller("EmployeeController", function($scope,$http){

	$scope.edit = {};
	$scope.departments = [];
	$scope.supervisors = [];
	$scope.loading = false;

	$scope.addRoles = {
		labelAll: 'All Items',
		labelSelected: 'Selected Items',
		helpMessage: 'Select roles to assign , search roles from below',
		/* angular will use this to filter your lists */
		orderProperty: 'name',
		/* this contains the initial list of all items (i.e. the left side) */
		items: [],
		/* this list should be initialized as empty or with any pre-selected items */
		selectedItems: [] 
	};	

	$scope.editRoles = {
		labelAll: 'All Items',
		labelSelected: 'Selected Items',
		helpMessage: 'Select roles to assign , search roles from below',
		/* angular will use this to filter your lists */
		orderProperty: 'name',
		/* this contains the initial list of all items (i.e. the left side) */
		items: [],
		/* this list should be initialized as empty or with any pre-selected items */
		selectedItems: [] 
	};	


	$('#btn-add').on('click',function() {
 		$('#largeModalAdd').modal('show');

        $scope.addRoles.items = [] ;
        $scope.addRoles.selectedItems = [] ;
 		 $.ajax({
	        url: '{{url('employee/getroles')}}',
	        type: 'get',
	        success: function(reponse){
	            $scope.addRoles.items  = reponse;
	            $scope.$apply();


	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });	
 	});


	$('.btn-edit').on('click',function() {
		$('#largeModalEdit').modal('show');
		$('#supervisor_loading').show();
		$('#department_loading').show();
		$scope.loading = true;

		var id = $(this).data('id');
		$scope.editRoles.items = [] ;
        $scope.editRoles.selectedItems = [] ;
		$scope.edit = {};
		$scope.edit.user_id =0;

		$.ajax({
	        url: '{{url('employee/getDepartments')}}',
	        type: 'get',
	        success: function(reponse){
	            $scope.departments  = reponse;
	            $scope.$apply();
	  			$('#department_loading').hide();

	  			$.ajax({
			        url: '{{url('employee/getSupervisors')}}',
			        type: 'get',
			        success: function(reponse){
			            $scope.supervisors  = reponse;
			            $scope.$apply();
			  			$('#supervisor_loading').hide();
			  			

			  			$.ajax({
					        url: '{{url('employee/getemployee')}}',
					        type: 'get',
					        data:{'id':id},
					        success: function(reponse){

					        	$scope.loading = false;		
							        	
					            $scope.edit  = reponse.employee;
					            $scope.editRoles.items  = reponse.roles;
					            $scope.edit.is_user = reponse.employee.user?true:false;
					            $scope.edit.can_edit_user = reponse.employee.user?true:false;

					            if(reponse.employee.user){
					            	$scope.editRoles.selectedItems  = reponse.employee.user.roles;
					            	$scope.edit.username  = reponse.employee.user.username;
					            	$scope.edit.user_id  = reponse.employee.user.id;
					            }else{
									$scope.edit.user_id =0;
					            }
					            
					            $scope.$apply();
					            $('.select2').trigger('change');


					  			$('.dialog-loader').hide();
					        },
					        error: function(Response){               
					        }
					    });
			        },
			        error: function(Response){               
			        }
			    });	

	        },
	        error: function(Response){               
	        }
	    });


	});



	$("form#role-add-form").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this); 
        formData.append('roles',angular.toJson($scope.addRoles.selectedItems));

        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/employee/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "New Employee addedd successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error adding new employee.",
		      });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $("form#role-edit-form").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this); 
        formData.append('roles',angular.toJson($scope.editRoles.selectedItems));

        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/employee/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "Employee updated successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error occured while updating employee.",
		      });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $('.btn-delete').on('click',function() {
 		 var id = $(this).data('id');

 		showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function(isConfirm) {
 			if(isConfirm){
 				$.ajax({
		        url: '{{url('employee/delete')}}',
		        type: 'POST',
		        data:{'id':id,'releated':false},
		        success: function(response){
		            if(response.success){
						swal("Deleted","All records deleted ", "success");
						location.reload();
		            }else{
		            	if(response.error.code=="5000"){
		            		showCancelMessage("Releated Data", response.error.message, "error",function(isConfirm) {
		            			if (isConfirm) {
						            $.ajax({
								        url: '{{url('employee/deleteWithRelations')}}',
								        type: 'POST',
								        data:{'id':id,'releated':false},
								        success: function(response){
								            if(response.success){
												showWithTitleMessage("Deleted", "All data has been deleted with relations");
												location.reload();
								            }else{
								            	showWithTitleMessage("Cancelled", "Clear Related data");
								            }
								        },
								        error: function(reponse){
										    
										}
								    });	
						        } else {
						            showWithTitleMessage("Cancelled", "Clear Related data");
						        }
		            		});
			            }
		            }
		        },
		        error: function(reponse){
				    
				}
		    });
 			}
 		});

 		

 	});

   
  	
});//end controller




</script>
@stop
