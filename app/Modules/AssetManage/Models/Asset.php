<?php
namespace App\Modules\AssetManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'assets';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

	public function dealer()
    {
        return $this->belongsTo('App\Modules\DealerManage\Models\Dealer','dealer_id','id');
    }

	public function maincategory()
    {
        return $this->belongsTo('App\Modules\CategoryManage\Models\MainCategory','main_category_id','id');
    }

	public function category()
    {
        return $this->belongsTo('App\Modules\CategoryManage\Models\Category','category_id','id');
    }

	public function barcode()
    {
        return $this->hasOne('App\Models\AssetBarcode','asset_id','id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Modules\BrandManage\Models\Brand','brand_id','id');
    }

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

    public function supplier()
	{
		return $this->belongsTo('App\Models\Supplier','supplier_id','id');
	}

    public function fieldValues()
	{
		return $this->hasMany('App\Modules\AssetManage\Models\AssetFieldValue','asset_id');
	}

    public function transactions()
	{
		return $this->hasMany('App\Models\AssetTransaction','asset_id')->orderBy('created_at','DESC');
	}
}