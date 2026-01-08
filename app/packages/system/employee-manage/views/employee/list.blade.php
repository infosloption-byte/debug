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

	#largeModalUpload .tooltip {
	  font-size: 12px;
	  font-style: normal;
	  font-weight: normal;
	  line-height: 1.42857143;
	  text-align: left;
	  text-align: start;
	  text-decoration: none;
	  text-shadow: none;
	  text-transform: none;
	  letter-spacing: normal;
	  word-break: normal;
	  word-spacing: normal;
	  word-wrap: normal;
	  white-space: normal;
	  /* ... */
	}
	#largeModalUpload  .tooltip-inner {
	  padding: 3px 8px;
	  color: #fff;
	  text-align: center;
	  background-color: #000;
	  border-radius: 4px;
	}

	.more .fancy-checkbox input[type="checkbox"]+span:before {
		display: none;
	}

	.more .fancy-checkbox input[type="checkbox"]+span {
		color: blue;
		text-decoration: underline;
	}

	.devi{
		margin-top: 1rem;
	    margin-bottom: 1rem;
	    border: 0;
	    border-top: 1px solid rgba(0,0,0,.1);
	    position: absolute;
	    left: 70px;
	    top: 0;
	    width: 85%
	}

	.fa-check-circle{
		color: green;
	}

	.pointer{
		cursor: pointer;
	}

	.shadow{
	 -moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
	}

	.collapsing {
	  	position: relative;
	    height: 0;
	    overflow: hidden;
	    transition: height .0001s ease;
	}

	.borderless td, .borderless th {
    border: none;
}

.light{
	color: #b1b1b1;
}
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="EmployeeController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	               </a> <i class="fas fa-bars"></i></a> Employee Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Employee Management</li>
	                    <li class="breadcrumb-item active">Employee List</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<form action="" method="GET" role="form" id="form">
		<div class="row clearfix">
		    <div class="col-lg-12 col-md-12">
		        <div class="card ">
		            <div class="body" style="padding-bottom: 0">
		            	<div class="row" >
		            		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
		            			<div class="input-group">	
		            			 <div class="input-group-prepend">
								    <span class="input-group-text"><i class="icon-magnifier"></i></span>
								  </div>
								  <input value="{{$request->keyword}}" name="keyword" class="form-control" placeholder="Search here..." type="text">
								</div>
		            		</div>
		            		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
		            			<div class="form-group">
									<select name="supervisor" id="supervisor" class="form-control select2"> 
										<option value="">--Select Supervisor--</option>
										@foreach($supervisors as $supervisor)
											<option value="{{$supervisor->id}}" 
												@if($supervisor->id==$request->supervisor)  selected @endif>
												{{$supervisor->first_name}} {{$supervisor->last_name}}
											</option>
										@endforeach
									</select>
								</div>
		            		</div>
		            		<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 ">
		            			<div class="form-group">
									<select name="department" id="department" class="form-control select2"> 
										<option value="">--Select Department--</option>
										@foreach($departments as $department)
											<option value="{{$department->id}}" 
												@if($department->id==$request->department)  selected @endif>
												{{$department->name}}
											</option>
										@endforeach
									</select>
								</div>
		            		</div>
		            		<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 ">
		            			<div class="form-group">
									<select name="type" id="type" class="form-control select2"> 
										<option value="" @if($request->type=='0')  selected @endif>--Select Type--</option>
										<option value="sva" @if($request->type=='sva')  selected @endif>SVA</option>
										<option value="dva" @if($request->type=='dva')  selected @endif>DVA</option>
									</select>
								</div>
		            		</div> 
		            		<div class="col-xs-6 col-sm-6 col-md-1 col-lg-1 ">
		            			<div class="form-group">
									<label class="fancy-checkbox "  style="margin-right: 0;margin-top: 7px;">
	                                    <input class="checkbox" type="checkbox" name="hod" 
	                                    value="1" @if($request->hod)  checked @endif>
	                                    <span>HOD</span>
	                                </label>
								</div>
		            		</div>
		            		<div class="col-xs-6 col-sm-6 col-md-1 col-lg-1">
		            			<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
		            		</div>
		            	</div>

		            </div>
		        </div>
		    </div>
		</div>
	</form>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Employee List ( {{count($employee_list)}} of {{$total}}) <span style="color: #b1b1b1;font-size:11px">(**click on the row to more)</span> </h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Employee" id="btn-add"><i class="fas fa-plus "></i></a></li>
						<!-- CHECK PERM -->

	                    <li><a class="tab_btn table-btn" href="javascript:void(0);" 
	                    	ng-click="upload()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload Excel"><i class="fas fa-upload "></i></a></li>
	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                        	<th>#</th>
		                            <th>Name</th>                                    
		                            <th>#No</th>                                   
		                            <th>Department</th>                                   
		                            <th>Employee Type</th>
		                            <th>Supervisor</th>                                   
		                            <th>Type</th>
		                            <th>Hod</th>
		                            <th>Created at</th>
		                            <th>Role</th>
		                            <th>User</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                        <tbody>
		                        @foreach($employee_list as $employee)	
		                        <tr data-toggle="collapse" data-target="#collapse_{{$employee->id}}" aria-expanded="false" aria-controls="collapseExample" class="pointer" >
                                    <td>
                                    	<img image="{{asset('storage')}}/{{$employee->image}}" 
                                            image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " 
                                            data-title="{{$employee->first_name}} {{$employee->last_name}}" 
                                            data-toggle="tooltip" 
	                        				data-placement="bottom" 
                                            data-title="
		                        				 	{{$employee->first_name}} {{$employee->last_name}} <br> 
		                        				 	@if($employee->department){{'('.$employee->department->name.')'}}@endif"
                                            style="border:1px solid #ddd">
                                    </td>
                                    <td>
                                        <h6 class="mb-0"><a href="">{{$employee->first_name}} {{$employee->last_name}}</a></h6>
                                    </td>
                                    <td>
                                    	<span>#{{$employee->employee_no}}</span>
                                    </td>
                                    <td>
                                    	<span class="badge badge-success">
                                    		@if($employee->department)
                                    			{{$employee->department->name}}
                                    		@endif
                                    	</span>
                                    </td>
                                    <td>
                                    	@if($employee['employeeType'])
                                    	<span class="badge badge-success">
                                    		{{$employee['employeeType']->name}}
                                    	</span>
                                    	@endif
                                    </td>
                                    <td>
                                    	@if($employee->supervisor)
                                    	{{$employee->supervisor->first_name}}
                                    	@endif
                                    </td>
                                    <td><span class="badge badge-danger">{{$employee->type}}</span></td>
                                    <td>
                                    	@if($employee->is_hod)
                                    	<i class="fas fa-check-circle"></i>
                                    	@endif
                                    </td>
                                    <td>{{$employee->created_at->format('Y-m-d')}}</td>
                                    <td>
                                    	@if($employee->user)
	                                    	@foreach($employee->user->roles as $role)
	                                    	<span class="badge badge-danger">{{$role->name}}</span>
	                                    	@endforeach
                                    	@else
                                    		not assigned
                                    	@endif
                                    </td>
                                    <td>
                                    	@if($employee->user)
                                    		<i class="fas fa-check-circle"></i>
                                    	@else
                                    		-
                                    	@endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-edit" title="Edit" data-id="{{$employee->id}}"><i class="fa fa-edit"></i></button>
		                                <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert btn-delete" title="Delete"
		                                data-id="{{$employee->id}}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="collapse shadow" id="collapse_{{$employee->id}}" >
                                	<td colspan="11">
                                		<div>
                                			<span class="float-left"><strong>{{$employee->first_name}} {{$employee->last_name}} ({{$employee->employee_no}})</strong></span>
                                			<span class="float-right"><strong>
                                				@if($employee->is_hod)
		                                    	<span class="badge badge-danger">HOD</span>
		                                    	@endif
                                			</strong></span>
                                		</div>
                                		<div class="clearfix"></div>
                                		<hr>
                                		<table class="borderless float-left">
                                			<tr>
                                				<td width="350px"><span><span class="light">Full Name</span><br><strong>{{$employee->full_name?$employee->full_name:'not mentioned'}}</strong></span></td>
                                				<td width="250px"><span><span class="light">Email</span><br><strong>{{$employee->email?$employee->email:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light">Phone No</span><br><strong>{{$employee->phone?$employee->phone:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light">Join Date</span><br><strong>{{$employee->join_date?$employee->join_date:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light">Birth Day</span><br><strong>{{$employee->birthday?$employee->birthday:'not mentioned'}}</strong></span></td>
                                			</tr>
                                			<tr>
                                				<td width="200px"><span><span class="light">Designation</span><br><strong>{{$employee->designation?$employee->designation:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light">NIC</span><br><strong>{{$employee->nic?$employee->nic:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light">Dimension</span><br><strong>{{$employee->dimension?$employee->dimension:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light"> Sub Dimension</span><br><strong>{{$employee->sub_dimension?$employee->sub_dimension:'not mentioned'}}</strong></span></td>
                                				<td width="200px"><span><span class="light"> Service</span><br><strong>{{$employee->join_date?\Carbon\Carbon::parse($employee->join_date)->diffForHumans(null,true):'not mentioned'}}</strong></span></td>
                                			</tr>
                                			<tr>
                                				<td width="200px"><span><span class="light">Department</span><br><strong>
                                					@if($employee->department)
                                						{{$employee->department->name?$employee->department->name:'not mentioned'}}
                                					@endif
                                				</strong></span></td>
                                			</tr>
                                		</table>
                                	</td>
                                </tr>
                                @endforeach
		                    </tbody>
		                </table>
		            </div>
		            {{$employee_list->appends($request->all())->links("pagination::bootstrap-4") }}
	            </div>
	        </div>
	    </div>

	</div>


	<div class="modal fade" id="largeModalAdd" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
	    	<div class="dialog-loader">
	    		<div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
	    	</div>
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Add New Employee</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-add-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" id="inputfirst_name" placeholder="First Name"
		            			 ng-model="first_name"
		            			 >
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" id="inputlast_name" placeholder="Last Name"
		            			 ng-model="last_name">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Employee No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Employee No"
		            			 ng-model="employee_no">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Phone</label>
		            			<input type="text" class="form-control" name="phone" placeholder="Phone"
		            			ng-model="phone">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Email</label>
		            			<input type="text" class="form-control" name="email" placeholder="Email" ng-model="email">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Supervisor</label>
		            			<select name="supervisor" id="inputDepartment" class="form-control show-tick ms select2" 
		            			ng-model="supervisor">
		            				<option value="0">- No Supervisor -</option>
		            				@foreach($supervisors as $supervisor)
										<option value="{{$supervisor->id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
		            				@endforeach
		            			</select>
		            		</div>
	            		</div>

	            		<div>
	            			<div class="row">
		            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		            				<div class="form-group more">
		            					<hr class="devi">
				            			<label class="fancy-checkbox " ng-init="more=0">
		                                    <input class="checkbox" type="checkbox" name="more" ng-model="more" value="1" >
		                                    <span>More</span>
		                                </label>
				            		</div>
		            			</div>
		            		</div>
	            		</div>

	            		<div class="row" ng-show="more">
	            			<div class="form-group col-md-12">
		            			<label for="">Full Name</label>
		            			<input type="text" class="form-control" name="full_name" placeholder="full_name"
		            			ng-model="full_name">
		            		</div>
	            		</div>

	            		<div class="row" ng-show="more">
	            			<div class="form-group col-md-6">
		            			<label for="">designation</label>
		            			<input type="text" class="form-control" name="designation" placeholder="designation"
		            			ng-model="designation">
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="">NIC</label>
		            			<input type="text" class="form-control" name="nic" placeholder="nic" ng-model="nic">
		            		</div>
	            		</div>
	            		

	            		<div class="row" ng-show="more">

	            			<div class="form-group col-md-3">
		            			<label for="">Join Date</label>
		            			<input type="text" class="form-control" name="join_date" placeholder="join_date"
		            			ng-model="join_date">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Birth Day</label>
		            			<input type="text" class="form-control" name="birthday" placeholder="birthday"
		            			ng-model="birthday">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Dimension</label>
		            			<input type="text" class="form-control" name="dimension" placeholder="Dimension"
		            			ng-model="dimension">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Subdimension</label>
		            			<input type="text" class="form-control" name="subdimension" placeholder="Subdimension" ng-model="subdimension">
		            		</div>
	            		</div>

	            		<div class="row" >
	            			<div class="form-group col-md-4">
		            			<label for="">Department</label>
		            			<select name="employee_department" id="employee_department" class="form-control show-tick ms select2"
		            			ng-model="department" >
		            				<option value="0">- Select Department -</option>
		            				@foreach($departments as $department)
		            					<option value="{{$department->id}}">{{$department->name}}</option>
		            				@endforeach
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Employee Type</label>
		            			<select name="hierarchy" id="hierarchy" class="form-control show-tick ms select2">
		            				<option value="0">- Select Level -</option>
		            				<option ng-repeat="level in department_hierarchys" value="@{{level.id}}">@{{level.name}}</option>
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4">
		            			
		            		</div>
		            		<div class="form-group col-md-4">
		            			<p>Make this employee as HOD</p>
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="is_hod" value="1"
                                    ng-model="is_hod" ng-disabled="!is_user" ng-checked="is_user && 0">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="gender" value="male" type="radio" ng-model="gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="type" value="sva" type="radio" ng-model="type" ><span><i></i>SVA</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="type" value="dva" type="radio" ng-model="type" ><span><i></i>DVA</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            				<div class="form-group 	">
			            			<label class="fancy-checkbox " ng-init="is_user=0">
	                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="is_user" value="1">
	                                    <span>Create User Account (User Account needed to make as HOD)</span>
	                                </label>
			            		</div>
	            			</div>
	            		</div>

	            		<div class="row" ng-show="is_user==1">

	            			<div class="form-group col-md-4">
		            			<label for="">Username</label>
		            			<input type="text" class="form-control" name="username" placeholder="Username" 
		            			ng-model="username" >
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Password</label>
		            			<input type="text" class="form-control" name="password" placeholder="Password">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Conf Password</label>
		            			<input type="text" class="form-control" name="conf_password" placeholder="Conf. Password">
		            		</div>


	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="addRoles"> </dualmultiselect>
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
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Edit Employee</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-edit-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

		            	<input type="hidden" class="form-control" name="employee_id" ng-model="edit.id"
		            	value="@{{edit.id}}">

		            	<input type="hidden" class="form-control" name="user_id" ng-model="edit.user_id"
		            	value="@{{edit.user_id}}">

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" id="inputeditfirst_name" placeholder="First Name"
		            			 ng-model="edit.first_name"
		            			>
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" id="inputeditlast_name" placeholder="Last Name"
		            			 ng-model="edit.last_name">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Employee No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Employee No"
		            			 ng-model="edit.employee_no">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Phone</label>
		            			<input type="text" class="form-control" name="phone" placeholder="Phone"
		            			ng-model="edit.phone">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Email</label>
		            			<input type="text" class="form-control" name="email" placeholder="Email" 
		            			ng-model="edit.email">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Supervisor</label>
		            			<i class="fas fa-spinner fa-spin" id="supervisor_loading"></i>
		            			<select name="supervisor" class="form-control show-tick ms select2" 
		            			ng-model="edit.supervisor_id">
		            				<option value="0">- No Supervisor -</option>
		            				<option value="@{{supervisor.id}}" 
		            				ng-repeat="supervisor in supervisors"
		            				ng-selected="supervisor.id==edit.parent_id">@{{supervisor.first_name}} @{{supervisor.last_name}} @{{edit.parent_id}}</option>
		            			</select>
		            		</div>
	            		</div>

	            		<div>
	            			<div class="row">
		            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		            				<div class="form-group more">
		            					<hr class="devi">
				            			<label class="fancy-checkbox " ng-init="more=0">
		                                    <input class="checkbox" type="checkbox" name="more" ng-model="more" value="1" >
		                                    <span>More</span>
		                                </label>
				            		</div>
		            			</div>
		            		</div>
	            		</div>

	            		<div class="row" ng-show="more">
	            			<div class="form-group col-md-12">
		            			<label for="">Full Name</label>
		            			<input type="text" class="form-control" name="full_name" placeholder="full_name"
		            			ng-model="edit.full_name">
		            		</div>
	            		</div>

	            		<div class="row" ng-show="more">
	            			<div class="form-group col-md-6">
		            			<label for="">designation</label>
		            			<input type="text" class="form-control" name="designation" placeholder="designation"
		            			ng-model="edit.designation">
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="">NIC</label>
		            			<input type="text" class="form-control" name="nic" placeholder="nic" ng-model="edit.nic">
		            		</div>
	            		</div>

	            		<div class="row" ng-show="more">
	            			<div class="form-group col-md-3">
		            			<label for="">Join Date</label>
		            			<input type="text" class="form-control date" name="join_date" placeholder="join_date"
		            			ng-model="edit.join_date">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Birth Day</label>
		            			<input type="text" class="form-control date" name="birthday" placeholder="birthday"
		            			ng-model="edit.birthday">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Dimension</label>
		            			<input type="text" class="form-control" name="dimension" placeholder="Dimension"
		            			ng-model="edit.dimension">
		            		</div>
		            		<div class="form-group col-md-3">
		            			<label for="">Subdimension</label>
		            			<input type="text" class="form-control" name="subdimension" placeholder="Subdimension" 
		            			ng-model="edit.subdimension">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Department</label>
		            				<i class="fas fa-spinner fa-spin" id="department_loading"></i>
		            			<select name="department" id="edit_department" class="form-control show-tick ms select2"
		            			ng-model="edit.department_id" ng-selected="0">
		            				<option value="0" >- Select Department -</option>
		            				<option ng-value="department.id" ng-repeat="department in departments"
		            				ng-selected="department.id==edit.department_id">@{{department.name}}</option>
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4">
	            				<label for="">Employee Type</label>
		            			<select name="employee_type" id="employee_type" class="form-control show-tick ms select2">
		            				<option value="0">- Select Level -</option>
		            				<option ng-repeat="level in edit_department_hierarchys" value="@{{level.id}}" ng-selected="level.id==edit.employee_type_id">@{{level.name}}</option>
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4" ng-show="edit.can_edit_user==0">
		            			<p>Make this employee as HOD</p>
		            			<label class="fancy-checkbox ">
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="edit.is_hod" value="1"ng-disabled="!edit.is_user" ng-checked="edit.is_user && 0">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>

		            		<div class="form-group col-md-4" ng-show="edit.can_edit_user==1">
		            			<p>Update this employee as HOD</p>
		            			<label class="fancy-checkbox ">
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="edit.is_hod" value="1"ng-checked="edit.is_hod==1">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>
		            		
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="gender" value="male" type="radio" ng-model="edit.gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="edit.gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="type" value="sva" type="radio" ng-model="edit.type"><span><i></i>SVA</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="type" value="dva" type="radio" ng-model="edit.type" ><span><i></i>DVA</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-12" ng-show="edit.can_edit_user==0">
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="edit.is_user" value="1">
                                    <span>Create User Account (User Account needed to make as HOD)</span>
                                </label>
		            		</div>
		            		<div class="form-group col-md-12" ng-show="edit.can_edit_user>0">
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="reset_password" 
                                    ng-model="edit.reset_password" value="1">
                                    <span>Tick this if you want to change username and password</span>
                                </label>
		            		</div>
	            		</div>

	            		<div class="row" ng-show="edit.is_user==1">

	            			<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Username</label>
		            			<input type="text" class="form-control" name="username" placeholder="Username" 
		            			ng-model="edit.username" >
		            		</div>
		            		<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Password</label>
		            			<input type="text" class="form-control" name="password" placeholder="Password">
		            		</div>
		            		<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Conf Password</label>
		            			<input type="text" class="form-control" name="conf_password" placeholder="Conf. Password">
		            		</div>

	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="editRoles"> </dualmultiselect>
		            		</div>

	            		</div>



		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary" ng-disabled="loading">SAVE CHANGES</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="largeModalUpload" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Upload Employee</h4>
	            </div>
	            <form action="" method="POST" role="form" id="upload-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

	            		<div class="row">
	            			<div class="form-group col-md-12">
		            			<label for="" class="reuired">file</label>
		            			<input type="file" name="file" >
		            		</div>
	            		</div>

	            		<div ng-show="up_loading">
	            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
	            				<img src="{{asset('assets/admin_panel/images/loader.gif')}}" style="width: 50%">
	            			</div>
	            		</div>


	            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="!up_loading">
	            			<hr>
	            			<table class="table table-hover">
	            				<thead>
	            					<tr>
	            						<th>#</th>
	            						<th>Code</th>
	            						<th>Name</th>
	            						<th>Status</th>
	            						<th>Errors</th>
	            					</tr>
	            				</thead>
	            				<tbody>
	            					<tr ng-repeat="upload_result in upload_results">
	            						<td>@{{$index+1}}</td>
	            						<td>@{{upload_result.row.emp_code?upload_result.row.emp_code:'--'}}</td>
	            						<td>
		            						@{{upload_result.row.first_name?upload_result.row.first_name:'--'}} 
		            						@{{upload_result.row.last_name?upload_result.row.last_name:'--'}}
		            					</td>
	            						<td ng-show="upload_result.status=='failed'" style="color: red">@{{upload_result.status}}</td>
	            						<td ng-show="upload_result.status=='empty'" style="color: red">empty row</td>
	            						<td ng-show="upload_result.status=='success'" style="color: green">@{{upload_result.status}}</td>
	            						<td ng-show="upload_result.status=='update'" style="color: green">@{{upload_result.status}}</td>
	            						<td ng-hide="upload_result.status=='empty'">
		            						<a href="javascript:void(0);" style="color: red;text-decoration: underline;"
		            							uib-tooltip-html="upload_result.erros"
											    tooltip-placement="top"
			            						>@{{upload_result.error_count}}
			            					</a>
		            					</td>
		            					<td ng-show="upload_result.status=='empty'" style="color: red">
		            						empty row
		            					</td>
	            					</tr>
	            				</tbody>
	            			</table>
	            		</div>

	            		
		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary" ng-disabled="up_loading">UPLOAD</button>
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
});

 //initialize angular app
var app = angular.module("ngApp",['dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize']);

app.config(['$tooltipProvider', function ($tooltipProvider) {
    $tooltipProvider.options({
        appendToBody: true, // 
        appendToBody: true, // 
        placement:'bottom' // Set Default Placement
    });
}]);

//controller
app.controller("EmployeeController", function($scope,$http,$sce){

	$scope.edit = {};
	$scope.departments = [];
	$scope.department_hierarchys = [];
	$scope.edit_department_hierarchys = [];
	$scope.supervisors = [];
	$scope.loading = false;
    $scope.up_loading = false;

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

	$scope.upload = function() {
		$('#largeModalUpload').modal('show');	
	}

	$("#employee_department").on('change',function(){
	    $scope.selected_dpt = $(this).val();
		$.ajax({
	        url: '{{url('employee/getEmployeeHierarchy')}}',
	        type: 'get',
	        data: {department_id: $(this).val()},
	        success: function(reponse){
	            $scope.department_hierarchys  = reponse;
	            $scope.$apply();

	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });
	});

	$("#edit_department").on('change',function(){
	    $.ajax({
	        url: '{{url('employee/getEmployeeHierarchy')}}',
	        type: 'get',
	        data: {department_id: $(this).val()},
	        success: function(reponse){
	            $scope.edit_department_hierarchys  = reponse;
	            $scope.$apply();

	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });
	});

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
	        async: false,
	        success: function(reponse){
	            $scope.departments  = reponse;
	            $scope.$apply();
	  			$('#department_loading').hide();
	        },
	        error: function(Response){               
	        }
	    });

	    $.ajax({
	        url: '{{url('employee/getSupervisors')}}',
	        type: 'get',
	        async: false,
	        success: function(reponse){
	            $scope.supervisors  = reponse;
	            $scope.$apply();
	  			$('#supervisor_loading').hide();
	        },
	        error: function(Response){               
	        }
	    });

	    $.ajax({
	        url: '{{url('employee/getemployee')}}',
	        type: 'get',
	        data:{'id':id},
	        async: false,
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
	        },
	        error: function(Response){               
	        }
	    });

	    $.ajax({
	        url: '{{url('employee/getEmployeeHierarchy')}}',
	        type: 'get',
	        data: {department_id: $scope.edit.department_id},
	        success: function(reponse){
	            $scope.edit_department_hierarchys  = reponse;
	            $scope.$apply();
	            $('.select2').trigger('change');
	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });
	});

	$("form#role-add-form").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        formData.append('roles',angular.toJson($scope.addRoles.selectedItems));
        formData.append('fullname',$('#inputfirst_name').val()+" "+$('#inputlast_name').val());

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
        formData.append('fullname',$('#inputeditfirst_name').val()+" "+$('#inputeditlast_name').val());

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

    $("form#upload-form").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        $('.dialog-loader').show();
        
        $scope.upload_results = [];
        $scope.up_loading = true;
        $scope.$apply();
        
        $.ajax({
            url: "{{url('/employee/upload')}}",
            type: 'POST',
            data: formData,
            success: function (data) {
             	$scope.upload_results = data;
             	$scope.up_loading = false;
             	$scope.$apply();
            },
            error:function(data) {
             	
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $('#largeModalUpload').on('hidden.bs.modal', function () {
	 	location.reload();
	})
   
});//end controller

</script>
@stop
