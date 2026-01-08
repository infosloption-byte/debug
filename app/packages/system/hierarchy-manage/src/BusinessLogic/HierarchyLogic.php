<?php
namespace System\Hierarchy\BusinessLogic;

use System\Hierarchy\Models\Hierarchy;

class HierarchyLogic {
	
	public function __construct()
	{
		
	}

	public function getAllHierarchys()
	{
		return Hierarchy::all();
	}

	public function getAllHierarchyByDepartment($id)
	{
		return Hierarchy::where('department_id',$id)->with(['createdBy','department','parent'])->get();
	}

	public function getHierarchy($id)
	{
		return Hierarchy::find($id);
	}
	

	

}
