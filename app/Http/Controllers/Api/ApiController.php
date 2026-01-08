<?php

namespace App\Http\Controllers\Api;

use DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use System\Department\Models\Department;
use System\Employee\Models\Employee;

use App\Modules\AssetManage\Models\Asset;
use App\Modules\ComplainManage\Models\Complain;
use App\Modules\JobManage\Models\Job;

class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ApiController Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles REST api requests from mobile application.
    |
    */

    /**
     * Create a new controller instance. 
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function auth(Request $request)
    {   
        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $response['status_code'] = 200;
                $response['user_message'] = "Login successful";
                $response['debug_message'] = "Login successful";
                $user = Auth::user();
                $response['user'] = User::selectRaw("users.id as user_id,users.*,employee.*,department.name as department_name,
                    concat('".url('storage/')."',users.image) as image_url")
                ->leftjoin('employee','employee.id','=','users.employee_id')->leftjoin('department','department.id','=','employee.department_id')->find($user->id);
               
            }else{
                $response['status_code'] = 500;
                $response['user_message'] = "Username or password invalid";
                $response['debug_message'] = "Username or password invalid";
            }
             return response()->json($response);
        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['user_message'] = "Unexpected Error Occured";
            $response['debug_message'] = $e->getMessage();
            $response['user'] = null;
            return response()->json($response);
        }
    }

    public function auth1(Request $request)
    {   
        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $response['status_code'] = 200;
                $response['user_message'] = "Login successful";
                $response['debug_message'] = "Login successful";
                $user = Auth::user();
                $response['user'] = User::selectRaw("users.id as user_id,users.*,employee.*,department.name as department_name,
                    concat('".url('storage/')."',users.image) as image_url")
                ->leftjoin('employee','employee.id','=','users.employee_id')->leftjoin('department','department.id','=','employee.department_id')->find($user->id);
               
            }else{
                $response['status_code'] = 500;
                $response['user_message'] = "Username or password invalid";
                $response['debug_message'] = "Username or password invalid";
            }
             return response()->json($response);
        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['user_message'] = "Unexpected Error Occured";
            $response['debug_message'] = $e->getMessage();
            $response['user'] = null;
            return response()->json($response);
        }
    }

    public function getAssetData(Request $request)
    {
        $serial_no = $request->id;
        
        $details = Asset::with(['supplier','barcode.barcodetype'])->where('serial_no',$serial_no)->first();

        $job = Job::whereIn('asset_id',function($qry)use($serial_no){
            $qry->select('id')->from('assets')->where('serial_no',$serial_no);
        })->orderBy('created_at','DESC')->first();

        if($details){
            return response()->json([
                'id' => $details->id,
                'asset_no' => $details->asset_no,
                'serial_no' => $details->serial_no,
                'location' => 'Kaluthara Branch Office',
                'assign_to' => 'Gayan Sandakelum',
                'deployed_date' => '2019-12-12',
                'last_service_at' => '2018-12-20',
                'last_service_cost' => '22,000.00',
                'last_audit_date' => '2019-10-12',
                'audit_result' => 'No Issues',
            ]);

        }else{
            return response()->json([]);
        }
    }

    public function createComplain(Request $param)
    {

        $asset = Asset::where('asset_no',$param->asset_id)->first();

        $complain = Complain::create([
            'asset_id'      => $asset->id,
            'title'         => $param->title,
            'remark'        => $param->remark,
            'status'        => 0,
            'resource'      => 'mobile',
            'created_by'    => 1
        ]);

        if($complain){
            
            $complain->code = "CM/".str_pad($complain->id,6,0,STR_PAD_LEFT)."";
            $complain->save();

            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }   
    }

    public function getComplainList(Request $param)
    {
        $complains = Complain::whereNull('deleted_at')->with(['asset'])->get();
        return response()->json($complains);
    }

    public function getAssetDataTest($param)
    {
        $data = Asset::where('serial_no',$param)->first();

        $data['location'] = 'Kaluthara Branch Office';
        $data['assign_to'] = 'Gayan Sandakelum';
        $data['deployed_date'] = '2019-12-12';
        $data['last_service_at'] = '2018-12-20';
        $data['last_service_cost'] = '22,000.00';
        $data['last_audit_date'] = '2019-10-12';
        $data['audit_result'] = 'No Issues';

        return response()->json([$data]);
    }
}