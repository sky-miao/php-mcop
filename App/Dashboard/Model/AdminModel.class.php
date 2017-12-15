<?php

namespace Dashboard\Model;

use Think\Model;

class AdminModel extends Model
{
	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';

	public function checkAdminLogin($map)
	{

		$admin = $this->where($map)->find();

		return $admin;
	}
}