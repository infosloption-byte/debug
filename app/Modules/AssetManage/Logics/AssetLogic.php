<?php
namespace App\Modules\AssetManage\Logics;

use Carbon\Carbon;
use Validator;
use Sentinel;
use Response;
use Excel;
use DB;

use App\Modules\BrandManage\Models\Brand;
use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Models\Category;
use App\Models\Supplier;

use App\Modules\AssetManage\Models\Asset;

class AssetLogic 
{
	
	public function searchAssetData($param)
    {

    	$res = Asset::selectRaw('*,0 as more')->whereNull('deleted_at')->with(['dealer','brand', 'category', 'maincategory', 'supplier', 'createdBy.employee']);

        if(isset($param->dealer)){
            $res = $res->where('dealer_id',$param->dealer);
        }

        if(isset($param->asset_no)){
            $res = $res->where('asset_no','like','%'.$param->asset_no.'%');
        }

        if(isset($param->main_category)){
            $res = $res->where('main_category_id',$param->main_category);
        }

        if(isset($param->category)){
            $res = $res->where('category_id',$param->category);
        }

    	if(isset($param->brand)){
    		$res = $res->where('brand_id',$param->brand);
    	}  

    	$res = $res->paginate(20);

    	return $res;
    }

    public function getAssetDataNotActivated($param)
    {

        $res = Asset::selectRaw('*,0 as more')->whereNull('deleted_at')->whereNull('warranty_from')->with(['dealer','brand', 'category', 'maincategory', 'supplier', 'createdBy.employee']);

        if(isset($param->dealer)){
            $res = $res->where('dealer_id',$param->dealer);
        }

        if(isset($param->main_category)){
            $res = $res->where('main_category_id',$param->main_category);
        }

        if(isset($param->category)){
            $res = $res->where('category_id',$param->category);
        }  

        $res = $res->paginate(20);

        return $res;
    }

    public function getAssetsByCategory($param)
    {

        $res = Asset::whereNull('deleted_at');

        if(isset($param->main_id)){
            $res = $res->where('main_category_id',$param->main_id);
        }

        if(isset($param->cat_id)){
            $res = $res->where('category_id',$param->cat_id);
        }

        return $res->get();
    }

    public function getAssetsById($id)
    {

        $res = Asset::where('id',$id)->with(['dealer', 'brand', 'category', 'maincategory', 'supplier', 'createdBy.employee','barcode.barcodetype','fieldValues.field','transactions.location','transactions.assetStatus'])->get();

        return $res[0];
    }

}