<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use  App\Modules\IssueManage\Models\Issue;
use  System\Employee\Models\Employee;
use  System\Department\Models\Department;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        view()->composer('*', function ($view) {
            if(\Auth::check()){
                $user  = \Auth::user();
                $employee = Employee::find($user->employee_id);

                // $bi_pending = Issue::where('status',0)->where('created_department_id',$employee->department_id)->count();

                // $personal =  Issue::with(['rectifydepartment.hod'=>function($aa) use($user){
                //     $aa->where('id',$user->id);
                // }])->where('issue.issue_type',ISSUE_TYPE_ISSUE)
                // ->where('issue.status','>',0)   
                // ->where('issue.status','<',9)   
                // ->where('assigned_to',$user->id)
                // ->count();

                // $board_count = Department::selectRaw('department.id,department.name,(select ifnull(count(*),0) from issue where created_department_id=department.id and (issue.status > 0 and issue.status < 10 ) and issue.issue_type=2) as total_issues')
                // ->where('department.id',$employee->department_id)   
                // ->first();

                $view->with('sidebar_data', [
                    "boards"=>0,
                    "issues"=>0,
                    "goals"=>0,
                    "bip"=>0,
                    "tasks"=>0
                ]);
            }
        });

       

        
        
        Blade::directive('active', function($menu) {
           return "<?php echo str_is($menu, \Route::currentRouteName()) ? 'active' : ''?>";
        }); 

        Blade::directive('show', function($menu) {
           return "<?php echo str_is($menu, \Route::currentRouteName()) ? 'active' : ''?>";
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
