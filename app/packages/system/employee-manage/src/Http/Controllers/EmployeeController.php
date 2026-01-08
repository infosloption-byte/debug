<?php
namespace System\Employee\Http\Controllers;

use System\Permissions\Models\Permission;
use System\UserRoles\Models\UserRole;

use App\Http\Controllers\Controller;
use Core\UserRoles\Http\Requests\UserRoleRequest;
use Core\PermissionGroups\Models\PermissionGroup;

use Illuminate\Http\Request;
use Response;
use Sentinel;
use Carbon\Carbon;
use DB;
use App\Exceptions\TransactionException;
use System\Employee\Models\Employee;
use App\Models\User;

use System\UserRoles\BusinessLogic\UserRoleLogic;
use System\Department\BusinessLogic\DepartmentLogic;
use System\Department\Models\Department;
use System\Hierarchy\Models\Hierarchy;

use Excel;
use Validator;

class EmployeeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Role Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $roleLogic;
	protected $departmentLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,DepartmentLogic $departmentLogic)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->departmentLogic = $departmentLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(Request $request){

		$supervisors =  Employee::all();
		$employee_list =  Employee::with(['employeeType','user.roles','department','supervisor.user']);
		$departments   = $this->departmentLogic->getAllDepartments();

		if($request->keyword){
			$employee_list = $employee_list->where(function($aa) use($request)
			{	
				$aa->where('first_name','LIKE',"%".$request->keyword."%")
					->orWhere('last_name','LIKE',"%".$request->keyword."%")
					->orWhere('email','LIKE',"%".$request->keyword."%")
					->orWhere('phone','LIKE',"%".$request->keyword."%")
					->orWhere('employee_no','LIKE',"%".$request->keyword."%")
					->orWhere('code','LIKE',"%".$request->keyword."%")
					->orWhere('nic','LIKE',"%".$request->keyword."%")
					->orWhere('designation','LIKE',"%".$request->keyword."%");
			});
		}

		if($request->supervisor){
			$employee_list = $employee_list->where('parent_id',$request->supervisor);
		}

		if($request->department){
			$employee_list = $employee_list->where('department_id',$request->department);
		}

		if($request->type){
			$employee_list = $employee_list->where('type',$request->type);
		}

		if($request->hod){
			$employee_list = $employee_list->where('is_hod',$request->hod);
		}

		$total = (clone $employee_list)->count();

		$employee_list = $employee_list->paginate(20);

		return view('Employee::employee.list',compact('employee_list','supervisors','departments','request','total'));
	}

	public function create(Request $request){
		Employee::fixTree();

		DB::transaction(function () use($request,&$employee){
			$user = \Auth::user();

			if($request->supervisor=="0"){
				$employee = Employee::create([
					'first_name'    => $request->first_name,
					'last_name'     => $request->last_name,
					'full_name'     => $request->fullname,
					'email'         => $request->email,
					'phone'         => $request->phone,
					'employee_no'   => $request->employee_no,
					'code'          => '',
					'department_id' => $request->employee_department,
					'employee_type_id' => $request->hierarchy,
					'created_by'    => $user->id,
					'status'        => 1,
					'gender'        => $request->gender,
					'type'          => $request->type,
					'is_hod'        => $request->is_hod?$request->is_hod:0,
					'nic'           => $request->nic,
					'full_name'     => $request->full_name,
					'join_date'     => $request->join_date,
					'birthday'      => $request->birthday,
					'designation'   => $request->designation,
					'dimension'     => $request->dimension,
					'sub_dimension' => $request->sub_dimension

				]);

				$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
				$employee->save();

				$employee->makeRoot()->save();
			}else{

				$supervisor = Employee::find($request->supervisor);

				$employee = Employee::create([
					'first_name'    => $request->first_name,
					'last_name'     => $request->last_name,
					'full_name'     => $request->fullname,
					'email'         => $request->email,
					'phone'         => $request->phone,
					'employee_no'   => $request->employee_no,
					'code'          => '',
					'department_id' => $request->employee_department,
					'employee_type_id' => $request->hierarchy,
					'parent_id'     => $supervisor->id,
					'created_by'    => $user->id,
					'status'        => 1,
					'gender'        => $request->gender,
					'type'          => $request->type,
					'is_hod'        => $request->is_hod,
					'nic'           => $request->nic,
					'full_name'     => $request->full_name,
					'join_date'     => $request->join_date,
					'birthday'      => $request->birthday,
					'designation'   => $request->designation,
					'dimension'     => $request->dimension,
					'sub_dimension' => $request->sub_dimension
				]);

				$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
				$employee->save();
				
			}

			if($request->is_user>0){
				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id
		        ]);

		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$newuser->attachRole($attachrole);
		        }

		        if($request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $newuser->id;
					$department->save();
				}

			}
			
		});

		if($request->supervisor=="0"){
			$supervisor = Employee::find($request->supervisor);
			$employee->appendToNode($supervisor)->save();
		}

		return response()->json(['status'=>1]);
	}

	public function update(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$employee = Employee::find($request->employee_id);

			if($request->supervisor=="0"){
				$employee->first_name    = $request->first_name;
				$employee->last_name     = $request->last_name;
				$employee->full_name     = $request->fullname;
				$employee->email         = $request->email;
				$employee->phone         = $request->phone;
				$employee->employee_no   = $request->employee_no;
				$employee->department_id = $request->department;
				$employee->employee_type_id = $request->employee_type;
				$employee->gender        = $request->gender;
				$employee->type          = $request->type;
				$employee->is_hod        = $request->is_hod;
				$employee->dimension     = $request->dimension;
				$employee->sub_dimension = $request->sub_dimension;
				$employee->nic           = $request->nic;
				$employee->full_name     = $request->full_name;
				$employee->join_date     = $request->join_date;
				$employee->birthday      = $request->birthday;
				$employee->designation   = $request->designation;
				$employee->save();

				$employee->makeRoot()->save();
			}else{

				$supervisor = Employee::find($request->supervisor);

				$employee->first_name    = $request->first_name;
				$employee->last_name     = $request->last_name;
				$employee->full_name     = $request->fullname;
				$employee->email         = $request->email;
				$employee->phone         = $request->phone;
				$employee->employee_no   = $request->employee_no;
				$employee->department_id = $request->department;
				$employee->employee_type_id = $request->employee_type;
				$employee->gender        = $request->gender;
				$employee->type          = $request->type;
				$employee->is_hod        = $request->is_hod;
				$employee->parent_id     = $supervisor->id;
				$employee->dimension     = $request->dimension;
				$employee->sub_dimension = $request->sub_dimension;
				$employee->nic           = $request->nic;
				$employee->full_name     = $request->full_name;
				$employee->join_date     = $request->join_date;
				$employee->birthday      = $request->birthday;
				$employee->designation   = $request->designation;
				$employee->save();

				//$employee->appendToNode($supervisor)->save();

			}


			if($request->is_user>0 && $request->user_id==0){
				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id
		        ]);

		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$newuser->attachRole($attachrole);
		        }

		        if($request->is_hod && $request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $newuser->id;
					$department->save();
				}

			}

			if($request->user_id>0){

				$updateuser = User::find($request->user_id);
				$updateuser->name     = $request->first_name.' '.$request->last_name;
		        $updateuser->email    = $request->email;

		        if($request->reset_password>0){
					$updateuser->username = $request->username;
					$updateuser->password = bcrypt($request->password);
		        }

		        $updateuser->save();

		        $roles = $updateuser->roles()->sync([]);

		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$updateuser->attachRole($attachrole);
		        }

		        if($request->is_hod &&  $request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $updateuser->id;
					$department->save();
				}

			}
			
		});

		return response()->json(['status'=>1]);
	}

	public function getroles(){
		$response = $this->roleLogic->getAllRoles();
		return response()->json($response);
	}

	public function getDepartments(){
		$response = $this->departmentLogic->getAllDepartments();
		return response()->json($response);
	}

	public function getEmployeeHierarchy(Request $request){
		$response = Hierarchy::where('department_id',$request->department_id)->get();
		return response()->json($response);
	}

	public function getSupervisors(){
		$response = $supervisors =  Employee::all();
		return response()->json($response);
	}

	public function getemployee(Request $request){

		$response['roles'] = [];
		$response['employee'] = null;

		$employee = Employee::with(['user.roles'])->find($request->id);
		if($employee){
			$response['employee'] = $employee;
			if($employee->user){
				$response['roles'] = $this->roleLogic->getRolesToEdit($employee->user->id);
			}else{
				$response['roles'] = $this->roleLogic->getAllRoles();
			}
		}
		
		return response()->json($response);
	}

	public function delete(Request $request){

		try {
			$employee = Employee::find($request->id);
			if($employee){
				$user = User::where('employee_id',$request->id)->get();
				if(count($user)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the employee, this employee releated to user.Would you like to delete all related data",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$employee){
					$user = \Auth::user();
					$employee->delete();
					$json = [
			            'success' => true,
			            'error' => [
			                'code' => 200,
			                'message' => "deleted successfully",
			            ],
			        ];
			        return response()->json($json);
				
				});
			}else{
				$json = [
		            'success' => false,
		            'error' => [
		                'code' => 404,
		                'message' => "Cannot find the employee",
		            ],
		        ];
		        return response()->json($json);
			}
		} catch (Exception $e) {
			$json = [
	            'success' => false,
	            'error' => [
	                'code' => $e->getCode(),
	                'message' => $e->getMessage(),
	            ],
	        ];
		}

		$json = [
            'success' => true,
            'error' => [
                'code' => 400,
                'message' => "Deleted",
            ],
        ];
        return response()->json($json);

	}

	public function deleteWithRelations(Request $request){

		try {
			$employee = Employee::find($request->id);
			if($employee){
				$user = User::where('employee_id',$request->id)->first();
				DB::transaction(function () use($request,$employee,$user){
					$roles = $user->roles()->sync([]);
					$user->delete();
					$employee->delete();

					$employee->delete();
					$json = [
			            'success' => true,
			            'error' => [
			                'code' => 200,
			                'message' => "deleted with all relations,User,Role and employee",
			            ],
			        ];
			        return response()->json($json);
				
				});
			}else{
				$json = [
		            'success' => false,
		            'error' => [
		                'code' => 404,
		                'message' => "Cannot find the employee",
		            ],
		        ];
		        return response()->json($json);
			}
		} catch (Exception $e) {
			$json = [
	            'success' => false,
	            'error' => [
	                'code' => $e->getCode(),
	                'message' => $e->getMessage(),
	            ],
	        ];
		}

		$json = [
            'success' => true,
            'error' => [
                'code' => 400,
                'message' => "Deleted",
            ],
        ];
        return response()->json($json);

	}

	public function upload(Request $request){
		
		$result = [];

		DB::transaction(function () use($request,&$result,&$data){
			$path = $request->file('file')->getRealPath();
			$data = Excel::load($path, function($reader) {
				$reader->formatDates(true, 'Y-m-d');
			})->get()->toArray();

			$user = \Auth::user();
			foreach ($data as $key => $value) {
				if($value!=null){

					$a = Employee::where('employee_no',$value['emp_code'])->first();
					if($a){
						$validator = Validator::make($value,[
							"emp_code"    => "required|unique:employee,employee_no,".$a->id,
							"first_name"  => "required",
							"last_name"   => "required",
							// "email"       => "required|unique:employee,email",
							// "phone_no"    => "required",
							"supervisor_code"  => "required|exists:employee,employee_no",
							"department"  => "required|exists:department,code",
							// "type"        => "required",
							// "gender"      => "required",
							// "join_date"   => "required|date_format:Y-m-d",
							// "birthday"    => "required|date_format:Y-m-d",
							// "role"        => "required|exists:roles,name",
							"username"    => "required"
						]);
					}else{
						$validator = Validator::make($value,[
							"emp_code"    => "required|unique:employee,employee_no",
							"first_name"  => "required",
							"last_name"   => "required",
							// "email"       => "required|unique:employee,email",
							// "phone_no"    => "required",
							// "supervisor_code"  => "required|exists:employee,employee_no",
							"department"  => "required|exists:department,code",
							// "type"        => "required",
							// "gender"      => "required",
							// "join_date"   => "required|date_format:Y-m-d",
							// "birthday"    => "required|date_format:Y-m-d",
							// "role"        => "required|exists:roles,name",
							// "username"    => "required"
						]);
					}

					if($value['emp_code']==null){
						//array_push($result,['row'=>'n/a','status'=>'empty','erros'=>[],'error_count'=>0]);
					}elseif ($validator->fails()){
						array_push($result,['row'=>$value,'status'=>'failed',
							'erros'=>implode( "<br>", $validator->messages()->all()),
							'error_count'=>count($validator->messages()->all())]);
					}else{
						
						$department = Department::where('code',$value['department'])->first();
						if($department){

							$emp_type = Hierarchy::where('department_id',$department->id)->where('name',$value['employee_type'])->first();

							if($emp_type){

								$emp = Employee::where('employee_no',$value['emp_code'])->first();

								if(!$emp){
									//NEW
									if($value['supervisor_code']=='no'){
										$employee = Employee::create([
											'first_name'    => $value['first_name'],
											'last_name'     => $value['last_name'],
											'email'         => $value['email'],
											'phone'         => $value['phone_no'],
											'employee_no'   => $value['emp_code'],
											'employee_type_id'   => $emp_type->id,
											'code'          => '',
											'department_id' => $department->id,
											'created_by'    => $user->id,
											'status'        => 1,
											'gender'        => $value['gender'],
											'dimension'     => $value['dimension'],
											'sub_dimension' => $value['sub_dimension'],
											'nic'           => $value['nic'],
											'full_name'     => $value['full_name'],
											'join_date'     => $value['join_date'],
											'birthday'      => $value['birthday'],
											'designation'   => $value['designation']
										]);

										$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
										$employee->save();

										$employee->makeRoot()->save();
									}else{
										$supervisor = Employee::where('employee_no',$value['supervisor_code'])->first();

										$employee = Employee::create([
											'first_name'    => $value['first_name'],
											'last_name'     => $value['last_name'],
											'email'         => $value['email'],
											'phone'         => $value['phone_no'],
											'employee_type_id'   => $emp_type->id,
											'employee_no'   => $value['emp_code'],
											'code'          => '',
											'department_id' => $department->id,
											'created_by'    => $user->id,
											'status'        => 1,
											'gender'        => $value['gender'],
											'type'          => $value['type'],
											'dimension'     => $value['dimension'],
											'sub_dimension' => $value['sub_dimension'],
											'nic'           => $value['nic'],
											'full_name'     => $value['full_name'],
											'join_date'     => $value['join_date'],
											'birthday'      => $value['birthday'],
											'designation'   => $value['designation']
										]);

										$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
										$employee->save();

										$employee->appendToNode($supervisor)->save();
									}

									if(strtolower(preg_replace('/\s+/', '', $value['username']))!='no'){
										$newuser = User::create([
								            'name' => $value['first_name'].' '.$value['last_name'],
								            'username' => $value['username'],
								            'email' => $value['email'],
								            'password' => bcrypt('123'),
								            'employee_id' => $employee->id
								        ]);

								        $attachrole = UserRole::whereRaw("UPPER(name) ='". strtoupper($value['role'])."'")->first();
										$newuser->attachRole($attachrole);
									}

									array_push($result,['row'=>$value,'status'=>'success','erros'=>$value['username'],'error_count'=>0]);

								}else{
									$emp->first_name       = $value['first_name'];
									$emp->last_name        = $value['last_name'];
									$emp->email            = $value['email'];
									$emp->phone            = $value['phone_no'];
									$emp->employee_no      = $value['emp_code'];
									$emp->employee_type_id = $emp_type->id;
									$emp->code             = '';
									$emp->department_id    = $department->id;
									$emp->created_by       = $user->id;
									$emp->status           = 1;
									$emp->gender           = $value['gender'];
									$emp->dimension        = $value['dimension'];
									$emp->sub_dimension    = $value['sub_dimension'];
									$emp->nic              = $value['nic'];
									$emp->full_name 	   = $value['full_name'];
									$emp->join_date 	   = $value['join_date'];
									$emp->birthday         = $value['birthday'];
									$emp->designation      = $value['designation'];
									$emp->type      	   = $value['type'];

									$emp->save();
									// if($value['supervisor_code']=='no'){
									// 	$emp->makeRoot()->save();
									// }else{
									// 	$supervisor = Employee::where('employee_no',$value['supervisor_code'])->first();
									// 	$emp->appendToNode($supervisor)->save();
									// }

									// $usr = User::where('employee_id',$emp->id)->first();

									// if($usr){
									// 	$usr->name        = $value['first_name'].' '.$value['last_name'];
									//     $usr->username    = $value['username'];
									//     $usr->email       = $value['email'];
									//     $usr->employee_id = $emp->id;
									//     $usr->save();

									//     $roles = $usr->roles()->sync([]);

								 //        $attachrole = UserRole::whereRaw("UPPER(name) ='". strtoupper($value['role'])."'")->first();
									// 	$usr->attachRole($attachrole);
									// }

									// $emp->code = "EMP/".str_pad($emp->id,6,0,STR_PAD_LEFT)."";
									// $emp->save();

									array_push($result,['row'=>$value,'status'=>'update','erros'=>$value['username'],'error_count'=>0]);
							
								}
							}else{
								array_push($result,['row'=>$value,'status'=>'failed','erros'=>['Department has not employee type ('.$value['employee_type'].')'],'error_count'=>0]);		
							}
						}else{
							array_push($result,['row'=>$value,'status'=>'failed','erros'=>['Department cannot found ('.$value['department'].')'],'error_count'=>0]);
						}
					} 
				}else{
					array_push($result,['row'=>'n/a','status'=>'failed','erros'=>[],'error_count'=>0]);
				}

			}

		});

		return $result;
	}

	public function uploadTest(Request $request){
		
		$result = [];

		// DB::transaction(function () use($request,&$result,&$data){
			$path = $request->file('file')->getRealPath();
			$data = Excel::load($path, function($reader) {
				$reader->formatDates(true, 'Y-m-d');
			})->get()->toArray();

			$user = \Auth::user();
			foreach ($data as $key => $value) {
					
			}

		// });

		return $result;
	}

}
