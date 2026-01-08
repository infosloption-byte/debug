<?php
namespace App\Modules\ServiceCenterManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\ServiceCenterManage\Models\ServiceCenter;
use App\Modules\ServiceCenterManage\Logics\ServiceCenterLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class ServiceCenterManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| ServiceCenter Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $serviceCenterLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(ServiceCenterLogic $serviceCenterLogic)
	{
		$this->middleware('auth');
		$this->serviceCenterLogic = $serviceCenterLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('ServiceCenterManage::index',compact('counts'));
	}

	public function getServiceCenterData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceCenterLogic->searchServiceCenterData($request);

		return response()->json($details);
	}

	public function getServiceCenterById(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceCenterLogic->getServiceCenterById($request);

		return response()->json($details);
	}

	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->serviceCenterLogic->uploadServiceCenterData($request);
	}

	public function edit(Request $request)
	{
		$user = \Auth::user();
		
		return $this->serviceCenterLogic->editServiceCenterData($request);
	}

	public function getAllDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->serviceCenterLogic->getAllDistrict();
	}

	public function getAllCitiesByDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->serviceCenterLogic->getAllCitiesByDistrict($request);
	}
}
