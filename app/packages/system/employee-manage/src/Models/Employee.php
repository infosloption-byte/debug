<?php
namespace System\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Employee extends Model{

	use NodeTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employee';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];


	public function usertask()
	{
		return $this->belongsTo('App\Models\User','id','employee_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User','id','employee_id');
	}

	public function department()
	{
		return $this->belongsTo('System\Department\Models\Department','department_id','id');
	}

	public function employeeType()
	{
		return $this->belongsTo('System\Hierarchy\Models\Hierarchy','employee_type_id','id');
	}

    public function supervisor()
    {
        return $this->belongsTo('System\Employee\Models\Employee','parent_id','id');
    }

    public function skills()
    {
        return $this->hasMany('App\Modules\SelfAssesmentManage\Models\EmployeeSkill','employee_id');
    }

}
