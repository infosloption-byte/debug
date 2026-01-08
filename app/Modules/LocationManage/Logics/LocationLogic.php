<?php
namespace App\Modules\LocationManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use System\Employee\Models\Employee;
use System\Hierarchy\Models\Hierarchy;

use App\Modules\LocationManage\Models\LocationEmployee;
use App\Modules\LocationManage\Models\LocationSalesRep;
use App\Modules\LocationManage\Models\LocationType;
use App\Modules\LocationManage\Models\Location;

class LocationLogic 
{
        
    public function __construct()
    {
        
    }

    public function getAllLocationTypes()
	{
		return LocationType::all();
	}

    public function getAllLocationsByType($type_id)
	{
		
		$location = Location::where('location_type_id',$type_id)->with(['parentLocation','locationType','createdBy'])->get();

		return $location;
	}

    public function getAllParentLocationsByType($type_id)
	{
		
		$location = Location::whereIn('location_type_id',function($q)use($type_id){
			$q->select('parent_id')->from('location_type')->where('id',$type_id);
		})->get();

		return $location;
	}

    public function getAllLocations()
	{
		return Location::all();
	}

	public function getLocation($id)
	{
		return Location::where('id',$id)->with(['employee','rep'])->first();
	}

	public static function getLocationByCode($code)
	{
		return Location::where('code',$code)->first();
	}

	public function getLocationHierarchy($type_id,$keyword)
	{
		$nodes = Location::where('location_type_id',$type_id);

		if($keyword){
			$nodes = $nodes->where('name','like','%'.$keyword.'%');
		}

		$nodes = $nodes->with(['employee.employee','employee.employeeType'])->get();

		$tree = [];
		
		foreach ($nodes as $value) {
			$root = Location::selectRaw('*,(select name from location_type where location_type.id=location_type_id) as loc_type')->whereDescendantOrSelf($value)->get()->toTree();

			array_push($tree, $root[0]);
		}

		$tree = $this->loadTree($tree);

		return response()->json($tree);
	}

	public function loadTree($array)
	{
		foreach ($array as $value1) {
			$tp1 = $this->getAssignedEmployeeOfLocation($value1);

			$value1['employee_name'] = $tp1[0];
			$value1['employee_type'] = $tp1[1];

			if(count($value1->children)>0){

				foreach ($value1->children as $value2) {
					$tp2 = $this->getAssignedEmployeeOfLocation($value2);

					$value2['employee_name'] = $tp2[0];
					$value2['employee_type'] = $tp2[1];

					if(count($value2->children)>0){

						foreach ($value2->children as $value3) {
							$tp3 = $this->getAssignedEmployeeOfLocation($value3);

							$value3['employee_name'] = $tp3[0];
							$value3['employee_type'] = $tp3[1];

							if(count($value3->children)>0){

								foreach ($value3->children as $value4) {
									$tp4 = $this->getAssignedEmployeeOfLocation($value4);
									$value4['employee_name'] = $tp4[0];
									$value4['employee_type'] = $tp4[1];
								}
							}
						}
					}
				}
			}

		}

		return $array;
	}

	public function getAssignedEmployeeOfLocation($location)
	{
		$type = LocationType::find($location->location_type_id);

		$employee_type = $type->employee_type_id;

		$tmp1 = Hierarchy::find($employee_type);

		$tmp = LocationEmployee::where('location_id',$location->id)->first();

		if($tmp){
			$emp = Employee::find($tmp->employee_id);
		}else{
			$emp = [];
		}

		if($emp){
			return [
				$emp->first_name.' '.$emp->last_name,
				$tmp1->name
			];
		}else{
			return ['',''];
		}
	}

	public static function getLocationFlatHierarchy()
	{
		$nodes = Location::get()->toTree();

	    $tree = [];

		$traverse = function ($categories, $prefix = '-') use (&$traverse,&$tree) {
		    foreach ($categories as $category) {
		    	$name = $prefix.' '.$category->name;
		        $tree[$category->id] = $name;

		        $traverse($category->children, $prefix.'-');
		    }
		};

		$traverse($nodes);

		return $tree;
	}

	public static function getLocationFlatHierarchyObject()
	{
		$nodes = Location::get()->toTree();

	    $tree = [];

		$traverse = function ($categories, $prefix = '-') use (&$traverse,&$tree) {
		    foreach ($categories as $category) {
		    	$name = $prefix.' '.$category->name;
		        $tree[] = ['id'=>$category->id,'name'=>$name];

		        $traverse($category->children, $prefix.'-');
		    }
		};

		$traverse($nodes);

		return $tree;
	}

	public static function getAllSubLocationIds($location_id)
	{
		return $nodes = Location::whereDescendantOrSelf($location_id)->get()->pluck('id');
	}

	public static function getEmployeesByLocationType($loc_type_id)
	{
		$type = LocationType::find($loc_type_id);

		$employee_type = $type->employee_type_id;

		$tmp = Hierarchy::find($employee_type);
		
		$employees = Employee::whereIn('employee_type_id',function($q)use($type){
			$q->select('employee_type_id')->from('location_type')->where('id',$type->id);
		})->get();

		return $employees;
	}

	public static function getSalesRep()
	{
		$sales_reps = Employee::whereIn('employee_type_id',function($q){
			$q->select('id')->from('department_employee_hierarchy')->where('name','like','%Sales Rep');
		})->get();

		return $sales_reps;
	}

	public static function updateLocationDetails($request)
	{
		DB::transaction(function () use($request){
			$user = \Auth::user();

			$location = Location::find($request->location_id);

			if($location){
				if($request->main_location=="0"){
					$location->name = $request->name;
					$location->description = $request->desc;
					$location->save();	
					$location->makeRoot()->save();
				}else{
					$main_location = Location::find($request->main_location);
					$location->name = $request->name;
					$location->description = $request->desc;
					$location->save();	

					$location->appendToNode($main_location)->save();
				}

				$type = LocationType::find($request->edit_location_type);

				$is_exist = LocationEmployee::where('location_id',$request->location_id)->first();

				if($is_exist){
					LocationEmployee::where('location_id',$request->location_id)->delete();
				}
				
				if(is_numeric($request->edit_employee) && $request->edit_employee!='' && $request->edit_employee!=0){
					LocationEmployee::create([
						'location_id' => $request->location_id,
						'employee_id' => $request->edit_employee,
						'location_type_id' => $request->edit_location_type,
						'employee_type_id' => $type->employee_type_id,
						'created_by' => $user->id
					]);
				}

				return response()->json(['status'=>1]);

			}else{
				return response()->json(['status'=>0]);
			}
			
		});

		return response()->json(['status'=>1]);
	}
   
}
