<?php
namespace App\Modules\MaterialManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;

use App\Modules\ComplainManage\Models\Complain;
use App\Modules\MaterialManage\Models\Material;
use App\Modules\MaterialManage\Models\MaterialRequest;

use App\Modules\ServiceManage\Models\Service;

class MaterialLogic
{
	public function searchMaterialRequestData($param)
    {

    	$res = MaterialRequest::selectRaw('*,0 as more')->whereNull('deleted_at')->with(['job', 'asset', 'technician', 'createdBy.employee','details.material']);

    	$res = $res->paginate(20);

    	return $res;
    }

    public function searchMaterialData($param)
    {
        $res = Material::whereNull('deleted_at');

    	$res = $res->paginate(20);

    	return $res;
    }

    public function approveMaterialRequest($id)
    {
        $mat_request = MaterialRequest::find($id);

        if($mat_request){
            $mat_request->status = 1;
            $mat_request->save();

            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }

    public function rejectMaterialRequest($id)
    {
        $mat_request = MaterialRequest::find($id);

        if($mat_request){
            $mat_request->status = 2;
            $mat_request->save();

            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
}