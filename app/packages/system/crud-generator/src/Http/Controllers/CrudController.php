<?php
namespace System\CrudGenerator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Artisan;

class CrudController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Role Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request){
		return view('CrudGenerator::gen');
	}


	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function genrate(Request $request){
		//$request->all();

		$fields  = $request->fields;
		$types   = $request->types;
		$options = $request->options;

		$jsn = [];

		for($i=0;$i<count($fields);$i++) {
			if($types[$i]=='select'){
				$jsn['fields'][$i]['name']    =  $fields[$i];
				$jsn['fields'][$i]['type']    =  $types[$i];
				$jsn['fields'][$i]['options'] =  explode(',', $options[$i]);
			}else{
				$jsn['fields'][$i]['name']    =  $fields[$i];
				$jsn['fields'][$i]['type']    =  $types[$i];
				
			}
		}

		

		Artisan::call('crud:generate',[
			'name'                   => $request->module, 
			'--view-path'            => $request->view_path, 
			'--controller-namespace' => $request->namespace, 
			'--route-group'          => $request->prefix, 
			'--model-namespace'      => $request->model, 
			'--fields_from_file'     => json_encode($jsn)       
        ]);

  //       if($request->create_table>0){
		// 	Artisan::call('migrate');
		// }

        //title#string; content#text; category#select#options=technology,tips,health

        return redirect('crud/index')->with([
            'success' => true,
            'success.message' => $request->module.'Module Created!',
            'success.title'   => 'Success..!'
        ]);
	}



	

}
