<?php
namespace System\Hierarchy\Http\Controllers;

use DB;
use Response;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\TransactionException;

use App\Models\User;

use System\UserRoles\Models\UserRole;
use System\Permissions\Models\Permission;
use System\Employee\Models\Employee;

use System\Hierarchy\Models\Hierarchy;
use System\Hierarchy\BusinessLogic\HierarchyLogic;
use System\Department\BusinessLogic\DepartmentLogic;

class HierarchyController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Employee Hierarchy Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $hierarchyLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(HierarchyLogic $hierarchyLogic)
	{
		$this->middleware('auth');
		$this->hierarchyLogic = $hierarchyLogic;
	}

	/**
	 * Show the employee hierarchy add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(){
		$hierarchys  = Hierarchy::with(['createdBy','department','parent'])->get();
		return view('Hierarchy::hierarchy.list',compact('hierarchys'));
	}

	public function getDepartments(){
		$response = DepartmentLogic::getAllDepartments();
		return response()->json($response);
	}

	public function getHierarchys(){
		$response = $this->hierarchyLogic->getAllHierarchys();
		return response()->json($response);
	}

	public function getAllHierarchyByDepartment(Request $request){
		$response = $this->hierarchyLogic->getAllHierarchyByDepartment($request->id);
		return response()->json($response);
	}

	public function getHierarchy(Request $request){
		$response = $this->hierarchyLogic->getHierarchy($request->id);
		return response()->json($response);
	}

	public function getDistributionHierarchy(Request $request){
		$response = Hierarchy::whereIn('department_id',function($query){
			$query->select('id')->from('department')->where('name','Distribution');
		})->get();
		return response()->json($response);
	}

	public function getDriverEmployees(Request $request){

		$response = Employee::whereIn('department_id',function($qry){
			$qry->select('department_id')->from('department_employee_hierarchy')->where('name','like','%Driver');
		})->get();

		return response()->json($response);
	}

	public function create(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$hierarchy = Hierarchy::create([
				'department_id' => $request->department,
				'name'         	=> $request->name,
				'parent_id'  	=> $request->parent_level,
				'created_by'   	=> $user->id
			]);			
		});
		return response()->json(['status'=>1]);
	}

	public function update(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$hierarchy = Hierarchy::find($request->hierarchy_id);

			if($hierarchy){
				$hierarchy->department_id 	= $request->department_id;
				$hierarchy->name         	= $request->name;
				$hierarchy->parent_id  		= $request->parent;
				$hierarchy->created_by   	= $user->id;

				$hierarchy->save();
			}else{
				return response()->json(['status'=>0]);
			}
			
		});
		return response()->json(['status'=>1]);
	}

	public function delete(Request $request){

		try {
			$hierarchy = Hierarchy::find($request->hierarchy_id);
			if($hierarchy){
				$employee = Employee::where('type_id',$request->hierarchy_id)->get();
				if(count($employee)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the hierarchy, this hierarchy releated to an employee(s).Reassign releated data and delete again",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$hierarchy){
					$user = \Auth::user();
					$hierarchy->delete();
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
		                'message' => "Cannot find the hierarchy level",
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


}
