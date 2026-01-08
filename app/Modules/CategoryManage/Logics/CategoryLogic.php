<?php
namespace App\Modules\CategoryManage\Logics;

use DB;
use Excel;
use Response;
use Sentinel;
use Carbon\Carbon;

use App\Modules\CategoryManage\Models\Category;
use App\Modules\CategoryManage\Models\MainCategory;
use Validator;
class CategoryLogic 
{
        
    public function __construct()
    {
        
    }

    public function getCategoryHyrchy($param)
    {

        $res = MainCategory::selectRaw('id,name as text,code,true as parent')->whereNull('deleted_at')->with(['nodes'=>function($a)
        {
            $a->selectRaw('id,name as text,code,main_category_id,false as parent');
        }])->get();

        return $res;
    }

    public function searchCategoryData($param)
    {

        $res = Category::whereNull('deleted_at')->with(['mainCategory','createdBy.employee']);

        if(isset($param->main_category)){
            $res = $res->where('main_category_id',$param->main_category);
        }

        if(isset($param->keyword)){
            $res = $res->where(function($qry) use($param)
            {
                $qry->where('name','LIKE','%'.$param->keyword.'%')
                        ->orWhere('code','LIKE','%'.$param->keyword.'%');
            });
        }

        $res = $res->paginate(20);

        return $res;
    }

    public function getCategoriesByMainId($param)
    {

    	$res = Category::where('main_category_id',$param->id)->get();

    	return $res;
    }

    public function getAllCategories($param)
    {

        $res = Category::whereNull('deleted_at')->get();

        return $res;
    }

    public function getAllMainCategories($param)
    {

        $res = MainCategory::whereNull('deleted_at')->get();

        return $res;
    }

    public function uploadCategoryData($param)
    {
        $result = [];

    	DB::transaction(function () use($param,&$result){	
	    	$path = $param->file('files')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->formatDates(true, 'Y-m-d');
            })->get()->toArray();

		    $user = \Auth::user();

		    foreach ($data as $row) {
                if($row!=null){
                    $cats = Category::where('name',$row['category_name'])->first();    
                    if(!$cats){
                        $validator = Validator::make($row,[
                            "category_name" => "required",
                            "main_category" => "required|exists:main_categories,code"
                        ]);
                    }else{
                        $validator = Validator::make($row,[
                            "category_name" => "required",
                            "main_category" => "required|exists:main_categories,code"
                        ]);
                    }

                    if($validator->fails()){
                        array_push($result,['row'=>$row,'status'=>'failed',
                            'erros'=>implode( "<br>", $validator->messages()->all()),
                            'error_count'=>count($validator->messages()->all())]);
                    }else{
                        $main = MainCategory::where('code',$row['main_category'])->first(); 
                        if($cats){
                            $cats->name             = $row['category_name'];
                            $cats->main_category_id = $main->id;
                            $cats->save();
                            array_push($result,['row'=>$row,'status'=>'update','erros'=>[],'error_count'=>0]);
                        }else{
                            $res = Category::create([
                                'main_category_id' => $main->id,
                                'name'             => $row['category_name'],
                                'preventive_servce_by' => $row['service_by'],
                                'created_by'       => $user->id
                            ]); 

                            $res->code = "CAT/".str_pad($res->id,6,0,STR_PAD_LEFT)."";
                            $res->save();

                            array_push($result,['row'=>$row,'status'=>'success','erros'=>[],'error_count'=>0]);
                        }
                         
                    }
                }else{
                    array_push($result,['row'=>'n/a','status'=>'failed','erros'=>[],'error_count'=>0]);
                }
		    }
			
		});

		$categories = Category::whereNull('deleted_at')->with(['products.mrp'])->get();
		
        return response()->json(['res'=>$result,'data'=>$categories]);
    }
   
}
