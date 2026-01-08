<?php
namespace App\Modules\TechnicianManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\TechnicianManage\Models\Technician;
use App\Modules\ServiceCenterManage\Models\ServiceCenter;
use App\Models\City;
use App\Models\District;

class TechnicianLogic 
{
        
    public function __construct()
    {
        
    }

    public function searchTechnicianData($param)
    {

        $res = Technician::whereNull('deleted_at')->with(['serviceCenter']);

        if(isset($param->keyword)){
            $res = $res->where('name','LIKE','%'.$param->keyword.'%')->orWhere('code','LIKE','%'.$param->keyword.'%');
        }

        if(isset($param->center)){
            $res = $res->where('service_center_id',$param->center);
        }

        $res = $res->get();

        return $res;
    }

    public function getTechnicianById($param)
    {

        $technician = Technician::where('id',$param->id)->with(['serviceCenter'])->first();

        if($technician){
            return $technician;
        }else{
            return [];
        }
    }

    public function getAllServiceCenters()
    {

        $centers = ServiceCenter::all();

        if($centers){
            return $centers;
        }else{
            return [];
        }
    }

    public function getAllTechnicians()
    {

        $technicians = Technician::all();

        if($technicians){
            return $technicians;
        }else{
            return [];
        }
    }

    public function uploadTechnicianData($param)
    {   
        $result = [];

        DB::transaction(function () use($param,&$result){

            $path = $param->file('input-b2')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

		    $user = \Auth::user();

		    foreach ($data as $row) {

                if($row!=null){
                    $technician = Technician::where('name',$row['technician_name'])->first();

                    $service_center = ServiceCenter::where('name',$row['service_center'])->first();

                    if($technician){
                        $technician->code       = $row['technician_code'];
                        $technician->name       = $row['technician_name'];
                        $technician->service_center_id    = $service_center->id;
                        $technician->contact_no = $row['contact_no'];
                        $technician->email      = $row['email'];
                        $technician->address    = $row['address'];
                        
                        if($technician->save()){
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            array_push($result,['row'=>$row,'status'=>'failed','erros'=>[],'error_count'=>1]);
                        }

                    }else{
                        $res = Technician::create([
                            'code'       => $row['technician_code'],
                            'name'       => $row['technician_name'],
                            'service_center_id'    => $service_center->id,
                            'contact_no' => $row['contact_no'],
                            'email'      => $row['email'],
                            'address'    => $row['address'],
                        ]);

                        if($res){
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            array_push($result,['row'=>$row,'status'=>'failed','erros'=>[],'error_count'=>1]);
                        }
                    }
                }else{
                     array_push($result,['row'=>'n/a','status'=>'failed','erros'=>[],'error_count'=>0]);
                }
		    }
			
		});
		
		return response()->json($result);
    }

    public function editTechnicianData($param)
    {
        
        try {
            DB::transaction(function () use($param,&$response){
                $user = \Auth::user();

                $technician = Technician::find($param->edit_technician_id);

                if($technician){

                    $technician->service_center_id    = $param->technician_center;
                    $technician->code       = $param->technician_code;
                    $technician->name       = $param->technician_name;
                    $technician->contact_no = $param->technician_contact;
                    $technician->email      = $param->technician_email;
                    $technician->address    = $param->technician_address;

                    if($technician->save()){
                        $response['status_code']   = 200;
                        $response['user_message']  = "Success";
                    }
                }
            });
        } catch (Exception $e) {
            $response['status_code']   = 500;
            $response['user_message']  = "Error Occured";
            $response['debug_message'] = $e->getMessage();

        } 
        return $response;
    }
   
}
