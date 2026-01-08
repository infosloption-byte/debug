<?php
namespace App\Modules\CategoryManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCategory extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'main_categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function subCategories()
    {
        return $this->hasMany('App\Modules\CategoryManage\Models\Category','main_category_id');
    }

    public function nodes()
    {
        return $this->hasMany('App\Modules\CategoryManage\Models\Category','main_category_id');
    }
}
