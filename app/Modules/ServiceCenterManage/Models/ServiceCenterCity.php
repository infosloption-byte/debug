<?php
namespace App\Modules\ServiceCenterManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCenterCity extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'service_center_cities';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function city()
    {
        return $this->belongsTo('App\Models\City','city_id','id');
    }

	public function center()
    {
        return $this->belongsTo('App\Modules\ServiceCenterManage\Models\ServiceCenter','center_id','id');
    }

}
