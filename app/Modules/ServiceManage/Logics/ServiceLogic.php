<?php
namespace App\Modules\ServiceManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;

use App\Modules\ComplainManage\Models\Complain;
use App\Modules\JobManage\Models\Job;

use App\Modules\ServiceManage\Models\Service;
use App\Modules\ServiceManage\Models\ServiceType;
use App\Modules\ServiceManage\Models\ServiceProvider;

class ServiceLogic
{
	public function searchServiceData($param)
    {

    	$res = Service::whereNull('deleted_at')->with(['job.technician', 'serviceType', 'serviceProvider', 'asset', 'technician', 'createdBy.employee']);

        if(isset($param->service_code)){
            $res = $res->where('code','like','%'.$param->service_code.'%');
        }

    	$res = $res->paginate(20);

    	return $res;
    }

    public function getServiceTypes($param)
    {
    	$types = ServiceType::all();

        return response()->json($types);
    }

    public function getServiceProviders($param)
    {
        $providers = ServiceProvider::all();

        return response()->json($providers);
    }

    public function completeService($param)
    {
        $service = Service::find($param->service_id);

        if($service){
            $service->provider_remark = $param->done_remark;
            $service->cost = $param->service_cost;
            $service->manhour = $param->service_man_hour;
            $service->status = 1;
            $service->completed_by = \Auth::user()->id;
            $service->completed_at = date('Y-m-d H:i:s');

            if($service->save()){

                $job = Job::find($service->job_id);

                $job->status = JOB_PENDING;
                $job->save();

                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 0]);
            }
        }
    }
}