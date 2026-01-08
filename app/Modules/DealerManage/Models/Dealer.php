<?php
namespace App\Modules\DealerManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dealer';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function assets()
    {
        return $this->hasMany('App\Modules\AssetManage\Models\Asset','dealer_id');
    }

	public function city()
    {
        return $this->belongsTo('App\Models\City','city_id','id');
    }

}
