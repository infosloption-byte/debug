<?php
namespace App\Modules\JobManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;

use App\Modules\InquiryManage\Models\Inquiry;

use App\Modules\MaterialManage\Models\Material;
use App\Modules\MaterialManage\Models\MaterialRequest;
use App\Modules\MaterialManage\Models\MaterialRequestDetail;

use App\Modules\JobManage\Models\Job;
use App\Modules\ServiceManage\Models\Service;

class JobLogic
{
	public function searchJobData($param)
    {

    	$res = Job::selectRaw('*,0 as more')->whereNull('deleted_at')->with(['inquiry', 'asset', 'technician', 'createdBy.employee','materialRequest.details.material','services.serviceType','services.serviceProvider']);

        if(isset($param->job_no)){
            $res = $res->where('code','like','%'.$param->job_no.'%');
        }

    	$res = $res->paginate(20);

    	return $res;
    }

    public function finishJob($param)
    {
    	$job = Job::find($param->done_job_id);

    	if($job){
    		$job->technician_remark = $param->done_remark;
            $job->status = 1;
    		$job->done_by = \Auth::user()->id;
    		$job->done_at = date('Y-m-d H:i:s');

    		if($job->save()){
    			return response()->json(['status' => 1]);
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }

    public function createService($param)
    {
        $job = Job::find($param->job_id);

        if($job){
            $service = Service::create([
                'job_id' => $job->id,
                'asset_id' => $job->asset_id,
                'service_type_id' => $param->service_type,
                'service_provider_id' => $param->service_provider,
                'remark' => $param->remark,
                'cost' => $param->service_cost,
                'manhour' => $param->service_manhour,
                'created_by' => \Auth::user()->id
            ]);

            if($service){

                $service->code = "SV/".str_pad($service->id,6,0,STR_PAD_LEFT)."";

                $job->status = 3;
                $job->save();
                
                if($service->save()){
                    return response()->json(['status' => 1]);
                }else{
                    return response()->json(['status' => 0]);
                }
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }

    public function saveMaterialRequest($param)
    {
        $job = Job::find($param->job_id);

        $materials = json_decode($param->materials);

        if($job){
            $material_request = MaterialRequest::create([
                'job_id' => $job->id,
                'technician_id' => $job->technician_id,
                'asset_id' => $job->asset_id,
                'request_remark' => $param->remark,
                'created_by' => \Auth::user()->id
            ]);

            if($material_request){

                $material_request->code = "MR/".str_pad($material_request->id,6,0,STR_PAD_LEFT)."";
                
                if($material_request->save()){

                    foreach ($materials as $value) {
                        MaterialRequestDetail::create([
                            'material_request_id' => $material_request->id,
                            'material_id' => $value->id,
                            'qty' => $value->qty,
                            'price' => $value->price
                        ]);
                    }

                    return response()->json(['status' => 1]);
                }else{
                    return response()->json(['status' => 0]);
                }
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }

    public function startJobClock($job_id)
    {
        $job = Job::find($job_id);

        if($job){
            $job->start_at = date('Y-m-d H:i:s');

            if($job->save()){
                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 0]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }

    public function stopJobClock($job_id)
    {
        $job = Job::find($job_id);

        if($job){
            $job->stopped_at = date('Y-m-d H:i:s');

            if($job->save()){
                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 0]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }
}