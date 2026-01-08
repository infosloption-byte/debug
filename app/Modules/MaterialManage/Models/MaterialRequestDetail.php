<?php
namespace App\Modules\MaterialManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialRequestDetail extends Model{

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'material_request_details';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	protected $casts = [

    ];

    public function materialRequest()
	{
		return $this->belongsTo('App\Modules\MaterialManage\Models\MaterialRequest','material_request_id','id');
	}

    public function material()
	{
		return $this->belongsTo('App\Modules\MaterialManage\Models\Material','material_id','id');
	}
}
