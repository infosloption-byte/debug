<?php
namespace App\Modules\DealerManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\DealerManage\Models\Dealer;
use App\Models\City;
use App\Models\District;

class DealerLogic 
{
        
    public function __construct()
    {
        
    }

    public function searchDealerData($param)
    {

        $res = Dealer::whereNull('deleted_at')->with(['city']);

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

    public function getDealerById($param)
    {

        $dealer = Dealer::where('id',$param->id)->with(['city'])->first();

        if($dealer){
            return $dealer;
        }else{
            return [];
        }
    }

    public function getAllDealers($param)
    {

        $dealers = Dealer::whereNull('deleted_at')->orderBy('name','ASC')->get();

        if($dealers){
            return $dealers;
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

    public function uploadDealerData($param)
    {   
        $result = [];

        DB::transaction(function () use($param,&$result){

            $path = $param->file('input-b2')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

		    $user = \Auth::user();

		    foreach ($data as $row) {

                if($row!=null){
                    $dealer = Dealer::where('name',$row['dealer_name'])->first();

                    $city = City::where('name',$row['city'])->first();

                    if($dealer){
                        $dealer->code       = $row['dealer_code'];
                        $dealer->name       = $row['dealer_name'];
                        $dealer->city_id    = $city->id;
                        $dealer->contact_no = $row['contact_no'];
                        $dealer->email      = $row['email'];
                        $dealer->address    = $row['address'];
                        
                        if($dealer->save()){
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            array_push($result,['row'=>$row,'status'=>'failed','erros'=>[],'error_count'=>1]);
                        }

                    }else{
                        $res = Dealer::create([
                            'code'       => $row['dealer_code'],
                            'name'       => $row['dealer_name'],
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

    public function editDealerData($param)
    {
        
        try {
            DB::transaction(function () use($param,&$response){
                $user = \Auth::user();

                $dealer = Dealer::find($param->edit_dealer_id);

                if($dealer){

                    $dealer->code       = $param->dealer_code;
                    $dealer->name       = $param->dealer_name;
                    $dealer->city_id    = $param->dealer_city;
                    $dealer->contact_no = $param->dealer_contact;
                    $dealer->email      = $param->dealer_email;
                    $dealer->address    = $param->dealer_address;

                    if($dealer->save()){
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
