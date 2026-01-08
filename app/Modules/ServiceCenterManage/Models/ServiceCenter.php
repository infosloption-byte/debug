<?php
namespace App\Modules\ServiceCenterManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCenter extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'service_center';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function cities()
    {
        return $this->hasMany('App\Modules\ServiceCenterManage\Models\ServiceCenterCity','city_id');
    }

	public function technicians()
    {
        return $this->hasMany('App\Modules\TechnicianManage\Models\Techinician','center_id');
    }

}
