<?php
namespace App\Modules\WorkRequestManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;

use App\Modules\WorkRequestManage\Models\Work;
use App\Modules\JobManage\Models\Job;

class WorkLogic 
{
	public function searchWorkData($param)
    {

    	$res = Work::selectRaw('*,0 as more')->whereNull('deleted_at')->with(['asset', 'createdBy.employee', 'approvedBy.employee', 'rejectedBy.employee','workType']);

        if(isset($param->reference_no)){
            $res = $res->where('code','like','%'.$param->reference_no.'%');
        }

    	$res = $res->paginate(9);

    	return $res;
    }

    public function createWork($param)
    {
        $work = Work::create([
            'asset_id'      => $param->_asset,
            'title'         => $param->work_title,
            'remark'        => $param->work_remark,
            'status'        => 0,
            'created_by'    => \Auth::user()->id
        ]);

        if($work){
            
            $work->code = "CM/".str_pad($work->id,6,0,STR_PAD_LEFT)."";
            $work->save();

            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
            
    }

    public function approveWork($param)
    {
    	$work = Work::find($param->id);

    	if($work){
    		$work->status = 1;
    		$work->approved_by = \Auth::user()->id;
    		$work->approved_at = date('Y-m-d H:i:s');

    		if($work->save()){
    			return response()->json(['status' => 1]);
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }

    public function rejectWork($param)
    {
    	$work = Work::find($param->id);

    	if($work){
    		$work->status = 2;
    		$work->rejected_by = \Auth::user()->id;
    		$work->rejected_at = date('Y-m-d H:i:s');

    		if($work->save()){
    			return response()->json(['status' => 1]);
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }

    public function createJob($param)
    {
    	$work = Work::find($param->work_id);

    	if($work){
    		$work->status = 3;
    		if($work->save()){
    			$job = Job::create([
    				'work_id' 	=> $param->work_id,
    				'asset_id' 		=> $work->asset_id,
    				'technician_id' => $param->technician,
    				'remark' 		=> $param->remark,
    				'created_by'    => \Auth::user()->id
    			]);

                $job->code = "JB/".str_pad($job->id,6,0,STR_PAD_LEFT)."";
                $job->save();

    			if($job){
    				return response()->json(['status' => 1]);
    			}else{
    				return response()->json(['status' => 0]);
    			}
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }
        
}