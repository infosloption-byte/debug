<?php
namespace App\Modules\BrandManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCategory extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'brand_categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function brand()
    {
        return $this->belongsTo('App\Modules\BrandManage\Models\Brand','brand_id','id');
    }

	public function category()
    {
        return $this->belongsTo('App\Modules\CategoryManage\Models\Category','category_id','id');
    }

}
