<?php

namespace Dashboard\Model;

use Think\Model;

class  UserModel extends Model
{

	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';

	public function getUserList($email=null)
	{

	
		$where=[];

		if (!empty($email)) {
			$where['email']=$email;
		}
		
		$count=$this->where($where)->count();
		
		
		$Page = new \Think\Page($count,20);
		$page  = $Page -> show();

		
		
			
		$data = $this
			  
			  ->where($where)
			  ->order('user_id desc')
			  ->limit($Page->firstRow.','.$Page->listRows)
			  ->select();

		return array('data' => $data , 'page' => $page);
	}

	public function getUser($user_id)
	{
		return $this->where('user_id='.$user_id)->find();
	}

	public function changeKYCValidate($postData)
	{
		$email_confirm=$this->where('user_id =%d',$postData['user_id'])->getField('email_confirm');
		if (!$email_confirm) {
			return false;
		}
		$kyc_validate=$this->where('user_id =%d',$postData['user_id'])->getField('kyc_validate');
		if ($kyc_validate !='1') {
			return false;
		}

		if (!in_array($postData['kyc_validate'], array(2,3)) ) {
			return false;
		}
		if ($postData['kyc_validate']=='4') {
			return false;
		}
		$res=$this
			->where('user_id =%d',$postData['user_id'])
			->save(array('kyc_validate'=>$postData['kyc_validate']));
		return $res;
	}
}