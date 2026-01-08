<?php
namespace App\Modules\CustomerManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customer';

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

}
