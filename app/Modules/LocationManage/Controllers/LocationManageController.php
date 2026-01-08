<?php
namespace App\Modules\LocationManage\Controllers;

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

use System\Department\Models\Department;

use System\UserRoles\BusinessLogic\UserRoleLogic;
use App\Modules\LocationManage\Models\Location;
use App\Modules\LocationManage\Models\LocationEmployee;
use App\Modules\LocationManage\Models\LocationType;
use App\Modules\LocationManage\Logics\LocationLogic;

class LocationManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Location Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $roleLogic;
	protected $locationLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,LocationLogic $locationLogic)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->locationLogic = $locationLogic;
	}

	/**
	 * Show the location list screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		$locations  =  Location::where('location_type_id',1)->with(['parentLocation','locationType','ancestors'=>function($aa){
			$aa->withDepth();
		}])->get();
		
		$loc_types = LocationType::all();

		$sub_data = [];

		foreach ($loc_types as $value) {
			$sub_data[$value->name] = Location::where('location_type_id',$value->id)->count();
		}

		return view('LocationManage::index',compact('locations','loc_types','sub_data'));
	}

	public function getLocations()
	{
		$response = $this->locationLogic->getAllLocations();
		return response()->json($response);
	}

	public function getLocationTypes(Request $request)
	{
		$response = $this->locationLogic->getAllLocationTypes($request);
		return response()->json($response);
	}

	public function getParentLocationsByType(Request $request)
	{
		$response = $this->locationLogic->getAllParentLocationsByType($request->type_id);
		return response()->json($response);
	}

	public function getLocationsByType(Request $request)
	{
		$response = $this->locationLogic->getAllLocationsByType($request->type_id);
		return response()->json($response);
	}

	public function getLocation(Request $request)
	{
		$response = $this->locationLogic->getLocation($request->id);
		return response()->json($response);
	}

	public function getEmployeesByLocationType(Request $request)
	{
		$response = $this->locationLogic->getEmployeesByLocationType($request->location_type);
		return response()->json($response);
	}

	public function getSalesRep(Request $request)
	{
		$response = $this->locationLogic->getSalesRep();
		return response()->json($response);
	}

	public function create(Request $request)
	{

		DB::transaction(function () use($request){
			$user = \Auth::user();

			if($request->parent_location=="0"){
				$location = Location::create([
					'location_type_id' => $request->location_type,
					'name'         => $request->name,
					'description'  => $request->desc,
					'code'         => '',
					'status'       => 1,
					'created_by'   => $user->id
				]);

				$location->code = "LOC/".str_pad($location->id,6,0,STR_PAD_LEFT)."";
				$location->save();	

				$location->makeRoot()->save();
			}else{

				$parent_location = Location::find($request->parent_location);

				$location = Location::create([
					'location_type_id' => $request->location_type,
					'name'         => $request->name,
					'description'  => $request->desc,
					'code'         => '',
					'status'       => 1,
					'created_by'   => $user->id
				]);

				$location->code = "LOC/".str_pad($location->id,6,0,STR_PAD_LEFT)."";

				$location->parent_type_id = $parent_location->location_type_id;
				$location->save();

				$location->appendToNode($parent_location)->save();
			}	
			
			
		});
		return response()->json(['status'=>1]);
	}

	public function checkLocationAssignedDetails(Request $request)
	{
			
		$employee_status = LocationEmployee::where('location_id',$request->loc)->where('employee_id','!=',$request->emp)->first();

		$location_status = LocationEmployee::where('location_id','!=',$request->loc)->where('employee_id',$request->emp)->first();

		$res = [];

		if($employee_status){
			$res['emp_status'] = false;
		}else{
			$res['emp_status'] = true;
		}

		if($location_status){
			$res['loc_status'] = false;
		}else{
			$res['loc_status'] = true;
		}

		return $res;
	}

	public function update(Request $request)
	{	
		$response = $this->locationLogic->updateLocationDetails($request);
		return $response;
	}

	public function delete(Request $request)
	{

		try {
			$location = Location::find($request->location_id);
			if($location){
				$employee = Employee::where('location_id',$request->location_id)->get();
				if(count($employee)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the location, this location releated to an employee(s).Reassign releated data and delete again",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$location){
					$user = \Auth::user();
					$location->delete();
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

	public function getLocationHierarchy(Request $request)
	{
		return $this->locationLogic->getLocationHierarchy($request->type_id,$request->keyword);
	}

	public function getLocationFlatHierarchy(Request $request)
	{
		return $this->locationLogic->getLocationFlatHierarchy();
	}

	public function getLocationFlatHierarchyObject(Request $request)
	{
		return $this->locationLogic->getLocationFlatHierarchyObject();
	}

	public function getAllSubLocationIds(Request $request)
	{
		return $this->locationLogic->getAllSubLocationIds($request->location_id);
	}

	public function checkLoactionIsLastNode(Request $request)
	{
		$lt = LocationType::orderBy('id','DESC')->limit(1)->first();
		
		$selected_location = Location::where('id',$request->location)
			->where('location_type_id',$lt->id)->first();

		if($selected_location){
			return 1;
		}else{
			return 0;
		}
	}

	public function assignEmployeeToLocationView()
	{
		$departments = Department::all();
		return view('LocationManage::employee_location',compact('departments'));
	}

}