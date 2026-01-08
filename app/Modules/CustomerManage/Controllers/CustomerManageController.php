<?php
namespace App\Modules\CustomerManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\CustomerManage\Models\Customer;
use App\Modules\CustomerManage\Logics\CustomerLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class CustomerManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Customer Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $customerLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(CustomerLogic $customerLogic)
	{
		$this->middleware('auth');
		$this->customerLogic = $customerLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();

		return view('CustomerManage::index',compact('counts'));
	}

	public function getCustomerData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->customerLogic->searchCustomerData($request);

		return response()->json($details);
	}

	public function getAllCustomers(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->customerLogic->getAllCustomers($request);

		return response()->json($details);
	}

	public function getCustomerById(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->customerLogic->getCustomerById($request);

		return response()->json($details);
	}

	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->customerLogic->uploadCustomerData($request);
	}

	public function edit(Request $request)
	{
		$user = \Auth::user();
		
		return $this->customerLogic->editCustomerData($request);
	}

	public function getAllDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->customerLogic->getAllDistrict();
	}

	public function getAllCitiesByDistrict(Request $request)
	{
		$user = \Auth::user();
		
		return $this->customerLogic->getAllCitiesByDistrict($request);
	}

	public function getCustomerByCity(Request $request)
	{
		$user = \Auth::user();
		
		return $this->customerLogic->getCustomerByCity($request);
	}
}
