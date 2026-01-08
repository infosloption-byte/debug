<?php namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Sentinel;
use Session;
use Response;
use DB;

use App\Modules\ProductManage\Models\Product;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
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

    public function default() 
    {
        return view('dashboard.default');
    }

    public function getAssetData()
    {
        return [
             
        ];
    }

    public function getSalesData()
    {
        return [];
    }
}
