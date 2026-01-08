<?php
namespace App\Modules\TechnicianManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\TechnicianManage\Models\Technician;
use App\Modules\TechnicianManage\Logics\TechnicianLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class TechnicianManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Technician Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $technicianLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(TechnicianLogic $technicianLogic)
	{
		$this->middleware('auth');
		$this->technicianLogic = $technicianLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('TechnicianManage::index',compact('counts'));
	}

	public function getTechnicianData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->technicianLogic->searchTechnicianData($request);

		return response()->json($details);
	}

	public function getTechnicianById(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->technicianLogic->getTechnicianById($request);

		return response()->json($details);
	}

	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->technicianLogic->uploadTechnicianData($request);
	}

	public function edit(Request $request)
	{
		$user = \Auth::user();
		
		return $this->technicianLogic->editTechnicianData($request);
	}

	public function getAllServiceCenters(Request $request)
	{
		$user = \Auth::user();
		
		return $this->technicianLogic->getAllServiceCenters();
	}

	public function getAllTechnicians(Request $request)
	{
		$user = \Auth::user();
		
		return $this->technicianLogic->getAllTechnicians();
	}
}
