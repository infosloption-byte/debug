<?php
namespace App\Modules\MaterialManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialRequest extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'material_requests';

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

    public function technician()
    {
        return $this->belongsTo('System\Employee\Models\Employee','technician_id','id');
    }

    public function details()
    {
        return $this->hasMany('App\Modules\MaterialManage\Models\MaterialRequestDetail','material_request_id');
    }

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}
}
