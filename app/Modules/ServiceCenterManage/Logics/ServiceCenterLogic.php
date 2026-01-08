<?php
namespace App\Modules\ServiceCenterManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\ServiceCenterManage\Models\ServiceCenter;
use App\Models\City;
use App\Models\District;

class ServiceCenterLogic 
{
        
    public function __construct()
    {
        
    }

    public function searchServiceCenterData($param)
    {

        $res = ServiceCenter::whereNull('deleted_at')->with(['cities.city']);

        if(isset($param->keyword)){
            $res = $res->where('name','LIKE','%'.$param->keyword.'%')->orWhere('code','LIKE','%'.$param->keyword.'%');
        }

        if(isset($param->district)){
            $res = $res->whereIn('city_id',function($qry)use($param)
            {
                $qry->select('id')->from('city')->where('district_id',$param->district);
            });
        }

        if(isset($param->city)){
            $res = $res->where('city_id',$param->city);
        }

        $res = $res->get();

        return $res;
    }

    public function getServiceCenterById($param)
    {

        $center = ServiceCenter::where('id',$param->id)->with(['cities.city'])->first();

        if($center){
            return $center;
        }else{
            return [];
        }
    }

    public function getAllDistrict()
    {

        $districts = District::all();

        if($districts){
            return $districts;
        }else{
            return [];
        }
    }

    public function getAllCitiesByDistrict($param)
    {

        $cities = City::where('district_id',$param->dis_id)->with(['districts'])->get();

        if($cities){
            return $cities;
        }else{
            return [];
        }
    }

    public function uploadServiceCenterData($param)
    {   
        $result = [];

        DB::transaction(function () use($param,&$result){

            $path = $param->file('input-b2')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

		    $user = \Auth::user();

		    foreach ($data as $row) {

                if($row!=null){
                    $center = ServiceCenter::where('name',$row['center_name'])->first();

                    $city = City::where('name',$row['city'])->first();

                    if($center){
                        $center->code       = $row['center_code'];
                        $center->name       = $row['center_name'];
                        $center->city_id    = $city->id;
                        $center->contact_no = $row['contact_no'];
                        $center->email      = $row['email'];
                        $center->address    = $row['address'];
                        
                        if($center->save()){
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            array_push($result,['row'=>$row,'status'=>'failed','erros'=>[],'error_count'=>1]);
                        }

                    }else{
                        $res = ServiceCenter::create([
                            'code'       => $row['center_code'],
                            'name'       => $row['center_name'],
                            'city_id'    => $city->id,
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

    public function editServiceCenterData($param)
    {
        
        try {
            DB::transaction(function () use($param,&$response){
                $user = \Auth::user();

                $center = ServiceCenter::find($param->edit_center_id);

                if($center){

                    $center->code       = $param->center_code;
                    $center->name       = $param->center_name;
                    $center->city_id    = $param->center_city;
                    $center->contact_no = $param->center_contact;
                    $center->email      = $param->center_email;
                    $center->address    = $param->center_address;

                    if($center->save()){
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
