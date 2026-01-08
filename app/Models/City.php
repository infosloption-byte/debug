<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model{

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'city';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'status'];

	public function districts()
    {
        return $this->belongsTo('App\Models\District','district_id','id');
    }
}
