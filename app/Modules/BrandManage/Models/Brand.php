<?php
namespace App\Modules\BrandManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'brands';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function products()
    {
        return $this->hasMany('App\Modules\ProductManage\Models\Product','brand_id');
    }

	public function brandCategories()
    {
        return $this->hasMany('App\Modules\BrandManage\Models\BrandCategory','brand_id');
    }

}
