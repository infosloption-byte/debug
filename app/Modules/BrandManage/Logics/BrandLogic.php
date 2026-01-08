<?php
namespace App\Modules\BrandManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\BrandManage\Models\Brand;
use App\Modules\BrandManage\Models\BrandCategory;
use App\Modules\CategoryManage\Models\Category;

class BrandLogic 
{
        
    public function __construct()
    {
        
    }

    public function searchBrandData($param)
    {

        $res = Brand::whereNull('deleted_at')->with(['brandCategories.category']);


        if(isset($param->keyword)){
            $res = $res->where(function($qry) use($param)
            {
                $qry->where('name','LIKE','%'.$param->keyword.'%');
            });
        }

        $res = $res->get();

        return $res;
    }

    public function getBrandById($param)
    {

        $brand = Brand::where('id',$param->id)->with(['brandCategories'])->first();

        if($brand){
            return $brand;
        }else{
            return [];
        }
    }

    public function uploadBrandData($param)
    {   
        $result = [];

        DB::transaction(function () use($param,&$result){

            $path = $param->file('input-b2')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();

		    $user = \Auth::user();

		    foreach ($data as $row) {

                if($row!=null){
                    $brand = Brand::where('name',$row['brand_name'])->first();
                    if($brand){
                        $brand->name = $row['brand_name'];
                        $brand->save();
                        array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                    }else{
                        $res = Brand::create([
                            'name' => $row['brand_name']
                        ]);
                        $res->save();

                        array_push($result,['row'=>$row,'status'=>'success','erros'=>[],'error_count'=>0]);
                    }
                }else{
                     array_push($result,['row'=>'n/a','status'=>'failed','erros'=>[],'error_count'=>0]);
                }
		    }
			
		});
		
		return response()->json($result);
    }

    public function editBrandData($param)
    {
        
        try {
            DB::transaction(function () use($param,&$response){
                $user = \Auth::user();

                $brand = Brand::find($param->edit_brand_id);

                if($brand){

                    $brand->name = $param->brand_name;
                    $brand->save();

                    BrandCategory::where('brand_id',$brand->id)->delete();

                    foreach ($param->category as $key => $value) {
                        $cat = Category::find($value);

                        if($cat){
                            BrandCategory::create([
                                'brand_id' => $brand->id,
                                'category_id' => $cat->id
                            ]);
                        }
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
