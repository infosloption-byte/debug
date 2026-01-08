<?php
namespace App\Modules\JobManage\Controllers;

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
use App\Modules\InquiryManage\Models\Inquiry;

use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Logics\JobLogic;

class JobManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Job Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $jobLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(JobLogic $jobLogic)
	{
		$this->middleware('auth');
		$this->jobLogic = $jobLogic;
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
		$data['jobs']        		= Job::all();
		
		return view('JobManage::list',compact('data'));
	}

	public function getJobData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->searchJobData($request);

		return response()->json($details);
	}

	public function finishJob(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->finishJob($request);

		return $details;
	}

	public function createService(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->createService($request);

		return $details;
	}

	public function saveMaterialRequest(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->saveMaterialRequest($request);

		return $details;
	}

	public function startJobClock($id)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->startJobClock($id);

		return $details;
	}

	public function stopJobClock($id)
	{
		$user = \Auth::user();
		
		$details = $this->jobLogic->stopJobClock($id);

		return $details;
	}

}