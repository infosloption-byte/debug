<?php
namespace App\Modules\DealerManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\DealerManage\Models\Dealer;
use App\Modules\DealerManage\Logics\DealerLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class DealerManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Dealer Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $dealerLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(DealerLogic $dealerLogic)
	{
		$this->middleware('auth');
		$this->dealerLogic = $dealerLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		$brands = Brand::all();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('DealerManage::index',compact('brands','counts'));
	}

	public function getDealerData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->dealerLogic->searchDealerData($request);

		return response()->json($details);
	}

	public function getAllDealers(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->dealerLogic->getAllDealers($request);

		return response()->json($details);
	}

	public function getDealerById(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->dealerLogic->getDealerById($request);

		return response()->json($details);
	}

	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->dealerLogic->uploadDealerData($request);
	}

	public function edit(Request $request)
	{
		$user = \Auth::user();
		
		return $this->dealerLogic->editDealerData($request);
	}

	public function getAllDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->dealerLogic->getAllDistrict();
	}

	public function getAllCitiesByDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->dealerLogic->getAllCitiesByDistrict($request);
	}
}
