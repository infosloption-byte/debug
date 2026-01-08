<?php
namespace App\Modules\TechnicianManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'technician';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function serviceCenter()
    {
        return $this->belongsTo('App\Modules\ServiceCenterManage\Models\ServiceCenter','service_center_id','id');
    }

}
