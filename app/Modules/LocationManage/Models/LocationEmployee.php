<?php
namespace App\Modules\LocationManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationEmployee extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'location_employee';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

	public function location()
	{
		return $this->belongsTo('App\Modules\LocationManage\Models\Location','location_id','id');
	}

	public function employee()
	{
		return $this->belongsTo('System\Employee\Models\Employee','employee_id','id');
	}

	public function employeeType()
	{
		return $this->belongsTo('System\Hierarchy\Models\Hierarchy','employee_type_id','id');
	}

}