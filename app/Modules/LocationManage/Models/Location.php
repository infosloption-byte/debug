<?php
namespace App\Modules\LocationManage\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Location extends Model{

	use NodeTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'location';

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

	public function parentLocation()
	{
		return $this->belongsTo('App\Modules\LocationManage\Models\Location','parent_id','id');
	}

	public function locationType()
	{
		return $this->belongsTo('App\Modules\LocationManage\Models\LocationType','location_type_id','id');
	}

	public function employee()
	{
		return $this->hasOne('App\Modules\LocationManage\Models\LocationEmployee','location_id','id');
	}

	public function rep()
	{
		return $this->hasOne('App\Modules\LocationManage\Models\LocationSalesRep','location_id','id');
	}

	public function hod()
	{
		return $this->belongsTo('App\Models\User','hod_id','id');
	}

}