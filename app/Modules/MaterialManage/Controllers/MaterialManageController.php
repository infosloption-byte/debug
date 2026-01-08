<?php
namespace App\Modules\MaterialManage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
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

use App\Modules\MaterialManage\Models\Material;
use App\Modules\MaterialManage\Models\MaterialRequest;

use App\Modules\MaterialManage\Logics\MaterialLogic;

class MaterialManageController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Material Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $logic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(MaterialLogic $logic)
	{
		$this->middleware('auth');
		$this->logic = $logic;
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
		
		return view('MaterialManage::list',compact('data'));
	}

	public function getMaterialRequestData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->logic->searchMaterialRequestData($request);

		return response()->json($details);
	}

	public function list()
	{
		$user = \Auth::user();

		$data['brands']          	= Brand::all();
		$data['main_categories'] 	= MainCategory::all();
		$data['categories']      	= Category::all();
		$data['jobs']        		= Job::all();
		
		return view('MaterialManage::material',compact('data'));
	}

	public function getMaterialData(Request $request)
	{
		$user = \Auth::user();
		
		$details = $this->logic->searchMaterialData($request);

		return response()->json($details);
	}

	public function approveMaterialRequest(Request $request,$id)
	{
		$user = \Auth::user();
		
		$details = $this->logic->approveMaterialRequest($id);

		return $details;
	}

	public function rejectMaterialRequest(Request $request,$id)
	{
		$user = \Auth::user();
		
		$details = $this->logic->rejectMaterialRequest($id);

		return $details;
	}

	public function uploadMaterial(Request $param)
    {
        $result = [];

    	DB::transaction(function () use($param,&$result){	
	    	$path = $param->file('files')->getRealPath();
		    $data = Excel::load($path, function($reader) {
                $reader->formatDates(true, 'Y-m-d');
            })->get()->toArray();

		    $user = \Auth::user();

		    foreach ($data as $row) {
                if($row!=null){

                	$material = Material::where('code',$row['material_code'])->first();
                    
                    if($material){
                        $material->name    = 	$row['name'];
                        $material->specs  	= 	$row['specs'];
                        $material->price  	= 	$row['price'];
                        $material->save();
                    }else{
                        $material = Material::create([
                        	'code'  => $row['material_code'],
                        	'name'  => $row['name'],
                        	'specs' => $row['specs'],
                        	'price' => $row['price']
                        ]);
                    }
		    	} 
		    }
			
		});
		
		return response()->json([
			'success' => true,
			'success.message' => 'Asset Uploaded successfully!',
			'success.title'   => 'Well Done!'
		]);
    }

}