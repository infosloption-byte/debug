<?php
namespace App\Modules\InquiryManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inquiries';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

    public function asset()
    {
        return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
    }

    public function inquiryType()
    {
        return $this->belongsTo('App\Modules\InquiryManage\Models\InquiryType','inquiry_type_id','id');
    }

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

    public function approvedBy()
	{
		return $this->belongsTo('App\Models\User','approved_by','id');
	}

    public function rejectedBy()
	{
		return $this->belongsTo('App\Models\User','rejected_by','id');
	}
}
