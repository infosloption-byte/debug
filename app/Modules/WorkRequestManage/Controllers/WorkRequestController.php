<?php
namespace App\Modules\WorkRequestManage\Controllers;

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
use App\Modules\WorkRequestManage\Models\Work;
use App\Modules\WorkRequestManage\Models\WorkType;
use App\Modules\WorkRequestManage\Logics\WorkLogic;

class WorkRequestController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Work Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $workLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(WorkLogic $workLogic)
	{
		$this->middleware('auth');
		$this->workLogic = $workLogic;
	}

	/**
	 * Show the Work data screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = \Auth::user();
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['works']        	= Work::all();
		
		return view('WorkRequestManage::list',compact('data'));
	}

	public function createView()
	{
		$user = \Auth::user();
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['works']        	= Work::all();
		$data['work_types']        	= WorkType::all();
		
		return view('WorkRequestManage::create',compact('data'));
	}

	public function createWork(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->workLogic->createWork($request);

		return $details;
	}

	public function getWorkData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->workLogic->searchWorkData($request);

		return $details;
	}

	public function approveWork(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->workLogic->approve($request);

		return $details;
	}

	public function rejectWork(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->workLogic->rejectWork($request);

		return $details;
	}

	public function createJob(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->workLogic->createJob($request);

		return $details;
	}

}