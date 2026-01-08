<?php
namespace App\Modules\CategoryManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function mainCategory()
    {
        return $this->belongsTo('App\Modules\CategoryManage\Models\MainCategory','main_category_id','id');
    }

    public function sub()
    {
        return $this->hasMany('App\Modules\CategoryManage\Models\MainCategory','main_category_id','id');
    }

	public function createdBy()
    {
        return $this->belongsTo('App\Models\User','created_by','id');
    }
}
