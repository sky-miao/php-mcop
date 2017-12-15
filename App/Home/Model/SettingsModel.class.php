<?php


namespace Home\Model;

use Think\Model;

class SettingsModel extends Model
{
	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';


	public function getSettings($key=null)
	{
		
		if ($key==null) {
			$settings= $this->select();
			foreach ($settings as $key => $val) {
				$result[$val['setting_name']]=$val['setting_value'];
			}
			return $result;
		}else{
			$setting= $this->where("setting_name= '%s'",$key)->getField('setting_value');
			return $setting;
		}
	}

	
}