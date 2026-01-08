<?php
namespace App\Modules\CategoryManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class CategoryManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Category Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $categoryLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(CategoryLogic $categoryLogic)
	{
		$this->middleware('auth');
		$this->categoryLogic = $categoryLogic;
	}

	/**
	 * Show the Category data screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = \Auth::user();
		$main_categories = MainCategory::all();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('CategoryManage::index',compact('main_categories','counts'));
	}

	/**
	 * Get Category data.
	 *
	 * @return JSON
	 */
	public function getCategoryData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->categoryLogic->searchCategoryData($request);

		return response()->json($details);

	}

	/**
	 * Save Category data.
	 *
	 * @return JSON
	 */
	public function upload(Request $request)
	{
		$user = \Auth::user();
		
		return $this->categoryLogic->uploadCategoryData($request);

	}

	/**
	 * Get sub categories data.
	 *
	 * @return JSON
	 */
	public function getCategoriesByMainId(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->categoryLogic->getCategoriesByMainId($request);

		return response()->json($details);

	}

	/**
	 * Get all main categories data.
	 *
	 * @return JSON
	 */
	public function getAllMainCategories(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->categoryLogic->getAllMainCategories($request);

		return response()->json($details);

	}

	/**
	 * Get all sub categories data.
	 *
	 * @return JSON
	 */
	public function getAllCategories(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->categoryLogic->getAllCategories($request);

		return response()->json($details);

	}

	/**
	 * Get all sub categories data.
	 *
	 * @return JSON
	 */
	public function viewPreventiveService(Request $request)
	{
		$user = \Auth::user();
		$main_categories = MainCategory::all();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();
		return view('CategoryManage::preventive_service',compact('main_categories','counts'));
	}
}
