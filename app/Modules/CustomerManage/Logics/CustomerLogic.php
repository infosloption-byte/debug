<?php
namespace App\Modules\CustomerManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\CustomerManage\Models\Customer;
use App\Models\City;
use App\Models\District;

class CustomerLogic 
{
        
    public function __construct()
    {
        
    }

    public function searchCustomerData($param)
    {

        $res = Customer::whereNull('deleted_at')->with(['city']);

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

    public function getCustomerById($param)
    {

        $customer = Customer::where('id',$param->id)->with(['city'])->first();

        if($customer){
            return $customer;
        }else{
            return [];
        }
    }

    public function getAllCustomers($param)
    {

        $customers = Customer::whereNull('deleted_at')->orderBy('name','ASC')->get();

        if($customers){
            return $customers;
        }else{
            return [];
        }
    }

    public function getCustomerByCity($param)
    {

        $customers = Customer::where('city_id',$param->id)->orderBy('name','ASC')->get();

        if($customers){
            return $customers;
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

    public function uploadCustomerData($param)
    {   
        $result = [];

        DB::transaction(function () use($param,&$result){

            $path = $param->file('input-b2')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

		    $user = \Auth::user();

		    foreach ($data as $row) {

                if($row!=null){
                    $customer = Customer::where('name',$row['customer_name'])->first();

                    $city = City::where('name',$row['city'])->first();

                    if($customer){
                        $customer->code       = $row['customer_code'];
                        $customer->name       = $row['customer_name'];
                        $customer->city_id    = $city->id;
                        $customer->contact_no = $row['contact_no'];
                        $customer->email      = $row['email'];
                        $customer->address    = $row['address'];
                        
                        if($customer->save()){
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            array_push($result,['row'=>$row,'status'=>'failed','erros'=>[],'error_count'=>1]);
                        }

                    }else{
                        $res = Customer::create([
                            'code'       => $row['customer_code'],
                            'name'       => $row['customer_name'],
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

    public function editCustomerData($param)
    {
        
        try {
            DB::transaction(function () use($param,&$response){
                $user = \Auth::user();

                $customer = Customer::find($param->edit_customer_id);

                if($customer){

                    $customer->code       = $param->customer_code;
                    $customer->name       = $param->customer_name;
                    $customer->city_id    = $param->customer_city;
                    $customer->contact_no = $param->customer_contact;
                    $customer->email      = $param->customer_email;
                    $customer->address    = $param->customer_address;

                    if($customer->save()){
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
