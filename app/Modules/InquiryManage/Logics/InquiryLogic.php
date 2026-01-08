<?php
namespace App\Modules\InquiryManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;

use App\Modules\InquiryManage\Models\Inquiry;
use App\Modules\JobManage\Models\Job;

class InquiryLogic 
{
	public function searchInquiryData($param)
    {

    	$res = Inquiry::selectRaw('*,0 as more')->whereNull('deleted_at')->with(['asset.category','asset.maincategory', 'createdBy.employee', 'approvedBy.employee', 'rejectedBy.employee','inquiryType']);

        if(isset($param->reference_no)){
            $res = $res->where('code','like','%'.$param->reference_no.'%');
        }

        if(isset($param->inquiry_type)){
            $res = $res->where('inquiry_type_id',$param->inquiry_type);
        }

        if(isset($param->main_category)){
            $res = $res->whereIn('asset_id',function($qry)use($param){
                $qry->select('id')->from('assets')->where('main_category_id',$param->main_category);
            });
        }

        if(isset($param->category)){
            $res = $res->whereIn('asset_id',function($qry)use($param){
                $qry->select('id')->from('assets')->where('category_id',$param->category);
            });
        }

    	$res = $res->orderBy('created_at','DESC')->paginate(9);

    	return $res;
    }

    public function createInquiry($param)
    {
        $inquiry = Inquiry::create([
            'asset_id'      => $param->_asset,
            'title'         => $param->inquiry_title,
            'remark'        => $param->inquiry_remark,
            'status'        => 0,
            'created_by'    => \Auth::user()->id
        ]);

        if($inquiry){
            
            $inquiry->code = "CM/".str_pad($inquiry->id,6,0,STR_PAD_LEFT)."";
            $inquiry->save();

            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
            
    }

    public function approveInquiry($param)
    {
    	$inquiry = Inquiry::find($param->id);

    	if($inquiry){
    		$inquiry->status = 1;
    		$inquiry->approved_by = \Auth::user()->id;
    		$inquiry->approved_at = date('Y-m-d H:i:s');

    		if($inquiry->save()){
    			return response()->json(['status' => 1]);
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }

    public function rejectInquiry($param)
    {
    	$inquiry = Inquiry::find($param->id);

    	if($inquiry){
    		$inquiry->status = 2;
    		$inquiry->rejected_by = \Auth::user()->id;
    		$inquiry->rejected_at = date('Y-m-d H:i:s');

    		if($inquiry->save()){
    			return response()->json(['status' => 1]);
    		}else{
    			return response()->json(['status' => 0]);
    		}
    	}
    }

    public function createJob($param)
    {
    	$inquiry = Inquiry::find($param->inquiry_id);

    	if($inquiry){
    		$inquiry->status = 3;
    		if($inquiry->save()){
    			$job = Job::create([
    				'inquiry_id' 	=> $param->inquiry_id,
    				'asset_id' 		=> $inquiry->asset_id,
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