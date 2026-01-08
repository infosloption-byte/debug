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
class BarcodeCategory extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'barcode_types';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];


}
