<?php
namespace App\Modules\BrandManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\BrandManage\Models\Brand;
use App\Modules\BrandManage\Logics\BrandLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class BrandManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Brand Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $brandLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(BrandLogic $brandLogic)
	{
		$this->middleware('auth');
		$this->brandLogic = $brandLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		$brands = Brand::all();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('BrandManage::index',compact('brands','counts'));
	}

	public function getBrandData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->brandLogic->searchBrandData($request);

		return response()->json($details);
	}

	public function getBrandById(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->brandLogic->getBrandById($request);

		return response()->json($details);
	}

	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->brandLogic->uploadBrandData($request);
	}

	public function edit(Request $request)
	{
		$user = \Auth::user();
		
		return $this->brandLogic->editBrandData($request);
	}
}
