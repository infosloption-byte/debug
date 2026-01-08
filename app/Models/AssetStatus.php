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
class AssetStatus extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'asset_status';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
}