<?php
namespace App\Modules\Warpath\Controllers;


use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;
use System\Department\Models\Department;

use App\Modules\DepartmentKPIManage\Models\DepartmentKpi;
use App\Modules\DepartmentKPIManage\Models\DepartmentKpiValue;

use  App\Modules\PredefineTaskManage\Models\DailyPredefinedTask;
use  App\Modules\PredefineTaskManage\Models\DailyTaskUnit;
use  App\Modules\DailyplanManage\Models\DailyTask;

class WarpathController extends Controller {

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
	public function index(Request $request,$id)
	{
		$user_id = \Auth::user()->id;
		$day 			= Carbon::now('Asia/Colombo')->format('Y-m');

		$from   = Carbon::now('Asia/Colombo')->startOfMonth()->format('Y-m-d');
        $to     = Carbon::now('Asia/Colombo')->endOfMonth()->format('Y-m-d');

        $request->sort = $request->sort?$request->sort:'asc';

		$parent   = Department::with(['hod.employee'])->find($id);
		$childs   = Department::with(['hod.employee'])->where('parent_id',$id)->get();
		$breadcrumbs       = Department::defaultOrder()->ancestorsAndSelf($id);
		$sva       = Employee::with(['user.bip'])->where('department_id',$id)->where('type','sva')->get();
		$dva       = Employee::with(['user'])->where('department_id',$id)->where('type','dva')->get();

		$kpis      = DepartmentKpi::selectRaw('department_kpis.kpi,department_kpis.department_id,ifnull(department_kpi_values.value,0) as value,ifnull(department_kpis.target_value,0) as target')
								->where('department_kpis.department_id',$id)
								->leftjoin('department_kpi_values', function ($join) use($day) {
						            $join->on('department_kpis.id', '=', 'department_kpi_values.kpi_id')
						                ->where('department_kpi_values.month',$day)
						                ->orderBy('desc');
						        })
								->get();


		$dva = DB::select(DB::raw("select *,TRUNCATE((((tmp.aa/480)*100)/tmp2.tot),2) as utilization from employee  
			left join users on users.employee_id = employee.id
			left join (
			    select ifnull(sum((daily_task.hrs*60)+daily_task.min),0) as aa,daily_task.user_id from daily_task 
			    where date(daily_task.date) >= '".$from."'
			    and date(daily_task.date) <= '".$to."'
			    GROUP by daily_task.user_id
			)tmp on tmp.user_id = users.id
			left join (
			    select ifnull(count(*),0) as tot,tmp.user_id from (
			    select ifnull(count(*),0) as aa,daily_task.user_id,DATE_FORMAT(date, '%Y-%m') 
			    from daily_task 
			    GROUP by DATE_FORMAT(date, '%Y-%m'),daily_task.user_id
			)tmp group by (tmp.user_id))tmp2 on tmp2.user_id = users.id
			where employee.department_id=".$id." and employee.type='dva' order by utilization ".$request->sort));


		return view('Warpath::warpath',compact('parent','childs','breadcrumbs','sva','dva','kpis','request'));
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function indexPrent(Request $request)
	{
		$user_id = \Auth::user()->id;
		$from   = Carbon::now('Asia/Colombo')->startOfMonth()->format('Y-m-d');
        $to     = Carbon::now('Asia/Colombo')->endOfMonth()->format('Y-m-d');
        
		$parent   = Department::with(['hod.employee'])->get()->toTree()[0];
		$childs   = Department::with(['hod.employee'])->where('parent_id',$parent->id)->get();
		$breadcrumbs = Department::defaultOrder()->ancestorsAndSelf($parent->id);
		$sva       = Employee::with('user')->where('department_id',$parent->id)->where('type','sva')->get();
		
		$kpis      = DepartmentKpi::where('department_id',$parent->id)->get();

		$request->sort = $request->sort?$request->sort:'asc';

		$dva = DB::select(DB::raw("select *,TRUNCATE((((tmp.aa/480)*100)/tmp2.tot),2) as utilization from employee  
			left join users on users.employee_id = employee.id
			left join (
			    select ifnull(sum((daily_task.hrs*60)+daily_task.min),0) as aa,daily_task.user_id from daily_task 
			    where date(daily_task.date) >= '".$from."'
			    and date(daily_task.date) <= '".$to."'
			    GROUP by daily_task.user_id
			)tmp on tmp.user_id = users.id
			left join (
			    select ifnull(count(*),0) as tot,tmp.user_id from (
			    select ifnull(count(*),0) as aa,daily_task.user_id,DATE_FORMAT(date, '%Y-%m') 
			    from daily_task 
			    GROUP by DATE_FORMAT(date, '%Y-%m'),daily_task.user_id
			)tmp group by (tmp.user_id))tmp2 on tmp2.user_id = users.id
			where employee.department_id=".$parent->id." and employee.type='dva' order by utilization ".$request->sort));

		return view('Warpath::warpath',compact('parent','childs','breadcrumbs','sva','dva','kpis','request'));
	}


/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getChilds(Request $request)
	{
		$user      = \Auth::user();
		$dep       = Department::with('hod.employee')->find($request->id);
		$childs    = $dep->where('parent_id',$dep->id)->get()->pluck('id');
		$childrens = Department::with('hod.employee')->whereIn('id',$childs)->get();
		$sva       = Employee::where('department_id',$dep->id)->where('type','sva')->get();
		$dva       = Employee::where('department_id',$dep->id)->where('type','dva')->get();

		return response()->json(['parent'=>$dep,'childs'=>$childrens,'sva'=>$sva,'dva'=>$dva]);
	}

}
