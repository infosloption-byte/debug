<?php
namespace App\Modules\LocationManage\Controllers;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Sentinel;
use DB;

use App\Models\User;
use System\Employee\Models\Employee;
use System\Permissions\Models\Permission;
use System\UserRoles\Models\UserRole;

use Core\UserRoles\Http\Requests\UserRoleRequest;
use Core\PermissionGroups\Models\PermissionGroup;

use System\Hierarchy\Models\Hierarchy;

use System\UserRoles\BusinessLogic\UserRoleLogic;
use App\Modules\LocationManage\Models\Location;
use App\Modules\LocationManage\Models\LocationType;
use App\Modules\LocationManage\Logics\LocationTypeLogic;

class LocationTypeManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Location Type Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $roleLogic;
	protected $locationTypeLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,LocationTypeLogic $locationTypeLogic)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->locationTypeLogic = $locationTypeLogic;
	}

	/**
	 * Show the location list screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		$locationTypes  =  LocationType::with(['parent','employeeType'])->get();
		
		$sub_data = [];

		foreach ($locationTypes as $value) {
			$sub_data[$value->name] = Location::where('location_type_id',$value->id)->count();
		}

		$emp_types = Hierarchy::whereIn('department_id',function($query){
			$query->select('id')->from('department')->where('name','Distribution');
		})->get();

		return view('LocationManage::type',compact('locationTypes','sub_data','emp_types'));
	}

	public function getParentType()
	{
		$response = $this->locationTypeLogic->getLastLocationType();
		return response()->json($response);
	}

	public function getLocationTypes()
	{
		$response = $this->locationTypeLogic->getAllLocationTypes();
		return response()->json($response);
	}

	public function getLocationType(Request $request)
	{
		$response = $this->locationTypeLogic->getLocationType($request->id);
		return response()->json($response);
	}

	public function create(Request $request)
	{
		$json = [];

		DB::transaction(function () use($request,&$json){
			$user = \Auth::user();

			$emp_type_exist = LocationType::where('employee_type_id',$request->emp_type)->get();

			if(count($emp_type_exist)>0){
				$json = [
		            'success' => false,
		            'code' => 500,
		            'message' => "Cannot creat the location type, this employee type releated to another location type.Reassign again"
		        ];
			}else{
				$locationType = LocationType::create([
					'name'         => $request->name,
					'code'         => '',
					'parent_id'    => $request->parent,
					'employee_type_id' => $request->emp_type,
					'status'       => 1,
					'created_by'   => $user->id
				]);

				$locationType->code = "LOCT/".str_pad($locationType->id,6,0,STR_PAD_LEFT)."";
				$locationType->save();

				$json = [
		            'success' => true,
		            'code' => 200,
		            'message' => "Location type created successfully"
		        ];
			}
			
		});
		return response()->json($json);
	}

	public function update(Request $request)
	{
		$json = [];

		DB::transaction(function () use($request,&$json){
			$user = \Auth::user();

			$locationType = LocationType::find($request->location_type_id);
			if($locationType){

				$emp_type_exist = LocationType::where('id','!=',$locationType->id)
					->where('employee_type_id',$request->edit_emp_type)
					->get();

				if(count($emp_type_exist)>0){
					$json = [
			            'success' => false,
			            'code' 	  => 500,
			            'message' => "Cannot creat the location type, this employee type releated to another location type.Reassign again"
			        ];
				}else{
					$locationType->name = $request->name;
					$locationType->employee_type_id = $request->edit_emp_type;
					$locationType->save();	

					$json = [
			            'success' => true,
			            'code' => 200,
			            'message' => "Location type updated successfully"
			        ];
				}

			}else{
				$json = [
		            'success' => false,
		            'code' => 404,
		            'message' => "Location type cannot found"
		        ];
			}
			
		});
		return response()->json($json);
	}

	public function delete(Request $request)
	{

		try {
			$locationType = LocationType::find($request->location_type_id);
			if($locationType){
				$location = Location::where('location_type_id',$request->location_type_id)->get();
				if(count($location)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the location type, this location type releated to an location(s).Reassign releated data and delete again",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$locationType){
					$user = \Auth::user();
					$locationType->delete();
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
		                'message' => "Cannot find the location",
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