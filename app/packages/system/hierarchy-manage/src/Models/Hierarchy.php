<?php
namespace System\Hierarchy\Models;

use Illuminate\Database\Eloquent\Model;

class Hierarchy extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'department_employee_hierarchy';

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

	public function department()
	{
		return $this->belongsTo('System\Department\Models\Department','department_id','id');
	}

	public function parent()
	{
		return $this->belongsTo('System\Hierarchy\Models\Hierarchy','parent_id','id');
	}

}