<?php

namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';

	public function checkEmailUsing($email)
	{
		return $this->where("email = '%s'",array($email))->find();
	}

	public function registerUser($email,$password)
	{
		$salt='mcop!@#$';
		$password_salt=md5(md5($password.$salt));

		$userdata= [
			'email' =>$email,
			'password' =>$password_salt,
			'nickname' =>$email,
			'avatar'   =>'/Public/images/avatar.jpg',
			'email_confirm'  =>0,
			'kyc_validate'   =>0,
			'reg_time' =>time(),
			'current_login_ip' => get_client_ip(),
			'current_login_time' => time(),
			'prev_login_ip' => get_client_ip(),
			'prev_login_time' => time(),
			'session_id'=> '',
			'm_count' =>1,
		];
		
		$result=$this->data($userdata)->add();
		if ($result) {
			return $this->where("email = '%s'",array($email))->find();
		}else{
			return false;
		}
	}


	public function checkUserLogin($map)
	{
		return $this->where($map)->find();

	}

	public function checkToken($user_id,$token)
	{
		
		return $this
			->where('user_id=%d and password_confirm_code ="%s"',array($user_id,$token))
			->find();
	}


	public function checkEmailToken($user_id,$token)
	{
		return $this
			->where('user_id=%d and email_confirm_code ="%s"',array($user_id,$token))
			->find();
	}


	public function getUser($user_id)
	{
		return $this->where('user_id =%d ',$user_id)->find();
	}

	public function saveUserData($postData)
	{
		$user_id=session('user_id');
		$postData['kyc_validate'] =1;
		$result=$this
				->where('user_id=%d',$user_id)
				->field('first_name,last_name,date_of_birth,street_address,city,state_region,country,postal_code,ethereum_address,estimated_participation_amount,idcard_number,kyc_validate')
				->save($postData);
		return $result;
	}

	public function updatePassword($postData)
	{
		$user_id =session('user_id');
		$salt='mcop!@#$';
		$nowpass=md5(md5($postData['nowpass'].$salt));

		$user=$this->where('user_id =%d and password= "%s"',array($user_id,$nowpass))->find();
		if (!$user) {
			return false;
		}else{
			$password=md5(md5($postData['pass'].$salt));
			return $this->where('user_id =%d',$user_id)->save(array('password'=>$password));
		}

	}


}