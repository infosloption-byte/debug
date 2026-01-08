<?php
namespace App\Modules\LocationManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\LocationManage\Models\LocationType;

class LocationTypeLogic 
{
        
    public function __construct()
    {
        
    }

    public function getLastLocationType()
	{
		return LocationType::whereNull('deleted_at')->orderBy('id','DESC')->limit(1)->first();
	}

    public function getAllLocationTypes()
	{
		return LocationType::whereNull('deleted_at')->with(['parent','employeeType','createdby'])->get();
	}

	public function getLocationType($id)
	{
		return LocationType::where('id',$id)->with(['parent','employeeType'])->first();
	}
   
}
