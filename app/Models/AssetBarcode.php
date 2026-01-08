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
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class AssetBarcode extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'asset_barcode';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	
	public function asset()
	{
	 	return $this->belongsTo('App\Modules\AssetManage\Models\Asset','asset_id','id');
	}

	public function barcodetype()
	{
	 	return $this->belongsTo('App\Models\BarcodeCategory','barcode_type_id','id');
	}
}