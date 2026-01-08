<?php
namespace System\Hierarchy\Http\Requests;

use App\Http\Requests\Request;

class HierarchyRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'name' => 'required',
		];
		return $rules;
	}

}
