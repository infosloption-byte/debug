<?php
namespace App\Modules\ServiceManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'services';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

    public function job()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\Job','job_id','id');
	}

    public function asset()
    {
        return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
    }

    public function serviceType()
    {
        return $this->belongsTo('App\Modules\ServiceManage\Models\ServiceType','service_type_id','id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo('App\Modules\ServiceManage\Models\ServiceProvider','service_provider_id','id');
    }

    public function technician()
    {
        return $this->belongsTo('System\Employee\Models\Employee','technician_id','id');
    }

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}
}
