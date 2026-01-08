<?php
namespace App\Modules\WarrantyManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'warranty_activations';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function dealer()
    {
        return $this->belongsTo('App\Modules\DealerManage\Models\Dealer','dealer_id','id');
    }

	public function customer()
    {
        return $this->belongsTo('App\Modules\CustomerManage\Models\Customer','customer_id','id');
    }

	public function asset()
    {
        return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
    }

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
