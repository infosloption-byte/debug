<?php
namespace App\Modules\InquiryManage\Controllers;

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
use App\Modules\InquiryManage\Models\InquiryType;
use App\Modules\InquiryManage\Logics\InquiryLogic;

class InquiryManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Inquiry Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $inquiryLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(InquiryLogic $inquiryLogic)
	{
		$this->middleware('auth');
		$this->inquiryLogic = $inquiryLogic;
	}

	/**
	 * Show the Inquiry data screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = \Auth::user();
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['inquiries']        	= Inquiry::all();
		$inquiry_types        		= InquiryType::all();
		
		return view('InquiryManage::list',compact('data','inquiry_types'));
	}

	public function createView()
	{
		$user = \Auth::user();
		
		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['inquiries']        	= Inquiry::all();
		
		return view('InquiryManage::create',compact('data'));
	}

	public function createInquiry(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->inquiryLogic->createInquiry($request);

		return $details;
	}

	public function getInquiryData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->inquiryLogic->searchInquiryData($request);

		return $details;
	}

	public function approveInquiry(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->inquiryLogic->approveInquiry($request);

		return $details;
	}

	public function rejectInquiry(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->inquiryLogic->rejectInquiry($request);

		return $details;
	}

	public function createJob(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->inquiryLogic->createJob($request);

		return $details;
	}

}