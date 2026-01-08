<?php
namespace App\Modules\AssetManage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use Response;
use Sentinel;
use DB;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\DealerManage\Models\Dealer;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Models\Category;
use App\Models\Supplier;

use App\Modules\AssetManage\Models\Asset;
use App\Modules\AssetManage\Logics\AssetLogic;

class AssetManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Asset Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $assetLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(AssetLogic $assetLogic)
	{
		$this->middleware('auth');
		$this->assetLogic = $assetLogic;
	}

	/**
	 * Show the Category data screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = \Auth::user();
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['assets']        		= Asset::all();
		
		return view('AssetManage::list',compact('data'));
	}

	public function getAssetData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->assetLogic->searchAssetData($request);

		return response()->json($details);
	}

	public function getAssetDataToActivate(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->assetLogic->getAssetDataNotActivated($request);

		return response()->json($details);
	}

	public function getAssetsByCategoryId(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->assetLogic->getAssetsByCategory($request);

		return response()->json($details);
	}

	public function viewAssetDetails($id)
	{
		$user = \Auth::user();

		$details = $this->assetLogic->getAssetsById($id);

		return view('AssetManage::view',compact('details'));
	}

	public function assignView()
	{
		$user = \Auth::user();	
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['assets']        		= Asset::all();
		
		return view('AssetManage::assign',compact('data'));
	}

	public function transferView()
	{
		$user = \Auth::user();	
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['assets']        		= Asset::all();
		
		return view('AssetManage::transfer',compact('data'));
	}

	public function add(AssetRequest $request)
	{
        $user = \Auth::user()->id;
		
        try {
            DB::transaction(function () use ($request,$user,$warranty_start,$warranty_end) {

        		$asset = Asset::create([
        			'dealer_id'			=>	$request->get('dealer'),
        			'main_category_id'	=>	$request->get('main_category'),
        			'category_id'		=>	$request->get('category'),
                    'brand_id'       	=>  $request->get('brand'),
                    'asset_no'     		=> 	$request->get('asset_no'),
                    'serial_no'     	=> 	$request->get('serial_no'),
                    'supplier_id'     	=> 	$request->get('supplier'),
                    'invoice_number'    => 	$request->get('invoice_number'),
                    'purchased_date'  	=> 	$request->get('purchased_date'),
                    'purchased_value' 	=> 	$request->get('purchased_value'),
                    'warranty_period' 	=> 	$request->get('warranty_period')
                ]);
            });

            return [
            	'success' => true,
                'success.message' => 'Asset added successfully!',
                'success.title'   => 'Well Done!'
            ];
        } catch (TransactionException $e) {
            
        } catch (Exception $e) {
            
        }
    }

    public function uploadAssets(Request $param)
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

                	$asset = Asset::where('asset_no',$row['asset_no'])->first();
                    
                    $main_category 	= MainCategory::where('name',$row['main_category'])->first();
                    $category 		= Category::where('name',$row['category'])->first();
                    $brand  		= Brand::where('name',$row['brand'])->first();
                    $supplier  		= Supplier::where('name',$row['supplier'])->first();

                    $dealer  		= Dealer::where('name',$row['dealer'])->first();
                    
                    if(!$brand){
                        $brand = Brand::create(['name'=>$row['brand']]);
                    }

                    if(!$main_category){
                        $main_category = Category::create([
                            'name' => $row['main_category']
                        ]);
                        $main_category->code = "MCAT/".str_pad($main_category->id,6,0,STR_PAD_LEFT)."";
                        $main_category->save();
                    }

                    if(!$category){
                        $category = Category::create([
                            'name' => $row['category'],
                            'main_category_id' => $main_category->id
                        ]);
                        $category->code = "CAT/".str_pad($res->id,6,0,STR_PAD_LEFT)."";
                        $category->save();
                    }

                    if(!$supplier){
                        $supplier = Supplier::create([
                            'name' => $row['supplier']
                        ]);
                    }

                    if(!$dealer){
                        $dealer = Dealer::create([
                            'name' => $row['dealer']
                        ]);
                        $dealer->code = "DL/".str_pad($dealer->id,6,0,STR_PAD_LEFT)."";
                        $dealer->save();
                    }
                    
                    if($asset){
                        $asset->dealer_id 		 =	$dealer->id;
                        $asset->main_category_id =	$main_category->id;
	        			$asset->category_id		 =	$category->id;
	                    $asset->brand_id       	 =  $brand->id;
	                    $asset->asset_no     	 = 	$row['asset_no'];
	                    $asset->serial_no     	 = 	$row['serial_no'];
	                    $asset->supplier_id      = 	$supplier->id;
	                    $asset->invoice_number   = 	$row['invoice_number'];
	                    $asset->purchased_date   = 	$row['purchased_date'];
	                    $asset->purchased_value  = 	$row['purchased_value'];
	                    $asset->warranty_period  = 	$row['warranty_period'];
	                    $asset->created_by		 =  \Auth::user()->id;
	                    $asset->save();
                    }else{
                        $asset = Asset::create([
                            'dealer_id' 	   => $dealer->id,
                            'main_category_id' => $main_category->id,
		        			'category_id'	   => $category->id,
		                    'brand_id'         => $brand->id,
		                    'asset_no'         => $row['asset_no'],
		                    'serial_no'        => $row['serial_no'],
		                    'supplier_id'      => $supplier->id,
		                    'invoice_number'   => $row['invoice_number'],
		                    'purchased_date'   => $row['purchased_date'],
		                    'purchased_value'  => $row['purchased_value'],
		                    'warranty_period'  => $row['warranty_period'],
		                    'creared_by' 	   => \Auth::user()->id
                        ]);
                    }
		    	} 
		    }
			
		});
		
		return response()->json($result);
    }

}