<?php

namespace Dashboard\Behaviors;

use Think\Behavior;

class LoginLogBehavior extends Behavior
{
	public function run(&$id)
	{
		$data['current_login_ip'] = $_SERVER['REMOTE_ADDR'];
   		$data['current_login_time']     = time();

		$adminModel = M('Admin','mcop_',C('DB_CONFIG'));
      
		$map['admin_id'] = $id;
		$result = $adminModel->where($map)->find();

		$data['prev_login_ip'] = $result['current_login_ip'];
		$data['prev_login_time'] = $result['current_login_time'];

		/*月份登录次数检测*/
		if( date('m',$data['prev_login_time'])===date('m',$data['current_login_time']) ){
		    $data['m_count'] = $result['m_count']+1;
		}else{
		    $data['m_count'] = 1;
		}
		$data['session'] = session_id();
		$adminModel->where($map)->save($data);
	}
}