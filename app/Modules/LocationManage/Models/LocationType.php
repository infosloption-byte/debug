<?php
namespace App\Modules\LocationManage\Models;

use Illuminate\Database\Eloquent\Model;

class LocationType extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'location_type';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

	public function parent()
	{
		return $this->belongsTo('App\Modules\LocationManage\Models\LocationType','parent_id','id');
	}

	public function employeeType()
	{
		return $this->belongsTo('System\Hierarchy\Models\Hierarchy','employee_type_id','id');
	}

}