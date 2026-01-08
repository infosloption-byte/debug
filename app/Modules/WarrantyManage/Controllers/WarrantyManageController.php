<?php
namespace App\Modules\WarrantyManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;

use App\Modules\CustomerManage\Models\Customer;
use App\Modules\WarrantyManage\Models\Warranty;

use App\Modules\InquiryManage\Models\Inquiry;

use App\Modules\WarrantyManage\Logics\WarrantyLogic;

use App\Modules\CategoryManage\Models\MainCategory;
use App\Modules\CategoryManage\Logics\CategoryLogic;
use App\Modules\BrandManage\Models\Brand;
use App\Modules\AssetManage\Models\Asset;
use App\Modules\CategoryManage\Models\Category;

class WarrantyManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Warranty Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $warrantyLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(WarrantyLogic $warrantyLogic)
	{
		$this->middleware('auth');
		$this->warrantyLogic = $warrantyLogic;
	}

	public function index()
	{
		$user = \Auth::user();
		$counts['products']        = Asset::get()->count();
		$counts['categories']      = Category::get()->count();
		$counts['main_categories'] = MainCategory::get()->count();
		$counts['brands']          = Brand::get()->count();

		return view('WarrantyManage::index',compact('counts'));
	}

	public function activateWarranty(Request $request)
	{
		DB::transaction(function () use($request){

			$assets = explode(',', $request->assets);
			foreach ($assets as $value) {

				$asset = Asset::find($value);

				if($asset){

					$customer = Customer::find($request->selected_customer_id);

					$activation = Warranty::create([
						'dealer_id' => $request->dealer,
						'customer_id' => $customer->id,
						'asset_id' =>$value,
						'activated_date' => date('Y-m-d'),
						'activated_by' => \Auth::user()->id,
					]);

					$tmp2 =	Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
					$warranty_start = $tmp2->toDateTimeString();
					$warranty_end = $tmp2->addMonths($asset->warranty_period)->toDateTimeString();

					$activation->warranty_end_date = $warranty_end;

					if($activation->save()){
						$asset->warranty_from = $warranty_start;
						$asset->warranty_to = $warranty_end;

						$asset->save();
					}

					$inquiry = Inquiry::create([
						'inquiry_type_id' => 1,
						'asset_id' => $asset->id,
						'title' => 'Asset Installation',
						'remark' => $customer->code.' '.$customer->name,
						'status' => 0,
						'resource' => 'web',
						'created_by' => \Auth::user()->id
					]);

					$inquiry->code = "CM/".str_pad($inquiry->id,6,0,STR_PAD_LEFT)."";
            		$inquiry->save();

				}

			}

		});

		return response()->json(['msg'=>'success']);
	}
}
