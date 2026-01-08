<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

    public function inquiry()
	{
		return $this->belongsTo('App\Modules\InquiryManage\Models\Inquiry','inquiry_id','id');
	}

    public function asset()
    {
        return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
    }

    public function technician()
    {
        return $this->belongsTo('App\Modules\TechnicianManage\Models\Technician','technician_id','id');
    }

    public function materialRequest()
    {
        return $this->belongsTo('App\Modules\MaterialManage\Models\MaterialRequest','id','job_id');
    }

    public function services()
    {
        return $this->hasMany('App\Modules\ServiceManage\Models\Service','job_id');
    }

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}
}
