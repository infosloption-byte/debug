<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * DeviceModal Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author      <>
 * @copyright  Copyright (c) 2019, 
 * @version    v1.0.0
 */
class AssetTransaction extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'asset_transaction';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	
	public function assetStatus()
	{
	 	return $this->belongsTo('App\Models\AssetStatus','status_id','id');
	}
	
	public function asset()
	{
	 	return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
	}

	public function location()
	{
	 	return $this->belongsTo('App\Modules\LocationManage\Models\Location','location_id','id');
	}
}