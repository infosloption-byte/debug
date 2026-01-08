<?php
namespace App\Modules\ServiceManage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Sentinel;
use DB;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\BrandManage\Models\Brand;
use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Models\Category;

use App\Modules\AssetManage\Models\Asset;
use App\Modules\ComplainManage\Models\Complain;
use App\Modules\JobManage\Models\Job;

use App\Modules\ServiceManage\Models\Service;
use App\Modules\ServiceManage\Logics\ServiceLogic;

class ServiceManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Service Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $serviceLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(ServiceLogic $serviceLogic)
	{
		$this->middleware('auth');
		$this->serviceLogic = $serviceLogic;
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
		$data['services']        	= Service::all();
		
		return view('ServiceManage::list',compact('data'));
	}

	public function getServiceData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceLogic->searchServiceData($request);

		return response()->json($details);
	}

	public function getServiceTypes(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceLogic->getServiceTypes($request);

		return $details;
	}

	public function getServiceProviders(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceLogic->getServiceProviders($request);

		return $details;
	}

	public function completeService(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->serviceLogic->completeService($request);

		return $details;
	}

}