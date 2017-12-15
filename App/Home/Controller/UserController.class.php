<?php

namespace Home\Controller;

class UserController extends BaseController
{
	public function index()
	{
		

		$user_id=session('user_id');
		
	
		$user=D('User')->getUser($user_id);

		if (is_array($user['kyc_validate'],array(0,3))) {
			$countrys =@include_once('./Data/countrys.php');
			$this->assign('countrys',$countrys);
		}


		$messages =session('message')??[];
		if ($user['email_confirm'] =='0') {
			$messages['need_email_confirm'] =L('need_email_confirm');
		}

		session('message',null);
		layout('Layout/layout');
		//dump($user);exit;
		
		$this->assign('messages',$messages);
		$this->assign('user',$user);
		$this->display();
	}


	public function validate()
	{
		if (IS_POST ) {
			if ($this->isValidate()) {
				$postData=I('post.');
				$postData['first_name'] =trim($postData['first_name']);
				$postData['last_name']=trim($postData['last_name']);
				$postData['street_address'] =stringFilter($postData['street_address']);
				$postData['ethereum_address'] =trim($postData['ethereum_address']);
				$result =D('User')->saveUserData($postData);
				if (!$result) {
					session('message.kyc_validate_save_error',L('kyc_validate_save_error'));
				}
				$result=A('Email')->sendMailToVerifyEmail(session('email'));
				redirect(U('User/index'));
			}

		}else{
			$this->error(L('somethingerror'));
		}
	}




	public function isValidate($user_id=null)
	{
		if ($user_id==null) {
			$user_id=session('user_id');
		}
		$code= M('User','mcop_',C('DB_CONFIG'))
				->where('user_id= %d',$user_id)
				->getField('kyc_validate');
		if (is_array($code,array(1,2))) {
			return false;
		}else{
			return true;
		}
	}

	public function isEmailValidate($user_id=null)
	{
		if ($user_id==null) {
			$user_id=session('user_id');
		}
		$code=M('User','mcop_',C('DB_CONFIG'))
				->where('user_id= %d',$user_id)
				->getField('email_confirm');
		if ($code=='0') {
			return false;
		}else{
			return true;
		}
	}


	public function hacIDCardImages()
	{
		if (IS_POST) {
			$user_id=session('user_id');
			$user =M('User','mcop_',C('DB_CONFIG'))
				->where('user_id=%d',$user_id)
				->find();
			if ($user['idcard_front']=='' || $user['idcard_back']=='') {
				$response =[
					'code' =>'falied',
					'message' =>L('needuploadidcard'),
				];
			}else{
				$response =[
					'code' =>'success',
				];
			}

			$this->ajaxReturn($response);	
		}
	}

	public function resendEmail()
	{
		if (IS_POST && IS_AJAX) {
			$result=A('Email')->sendMailToVerifyEmail(session('email'));
			if ($result) {
				$this->ajaxReturn(array('code'=>'success','message'=>L('resendemailtip')));
			}else{
				$this->ajaxReturn(array('code'=>'falied','message'=>L('resendemailtiperror')));
			}
		}
	}

	public function setting()
	{
		layout('Layout/layout');

		$user_id=session('user_id');
		$user=D('User')->getUser($user_id);
		$this->assign('user',$user);
		$this->display();
	}

	public function uploadPassword()
	{
		if (IS_AJAX) {
			$postData = I('post.');
			\Think\Log::write(json_encode($postData),'WARN');
			$result=D('User')->updatePassword($postData);
			if ($result) {
				
				$response=[
					'code' =>'success',
					'message' =>'Success'
				];
			}else{
				$response=[
					'code' =>'failed',
					'message' =>L('passworderror'),
				];
			}

			$this->ajaxReturn($response);

		}
	}

	public function uploadProfile()
	{
		if (IS_AJAX) {
			$postData = I('post.');
			
			$result=M('User','mcop_',C('DB_CONFIG'))
				->where('user_id =%d',session('user_id'))
				->save(array('ethereum_address'=>$postData['ethereum_address']));
			if ($result) {
				$response=[
					'code' =>'success',
					'message' =>'Success'
				];
			}else{
				$response=[
					'code' =>'failed',
					'message' =>'修改失败.',
				];
			}

			$this->ajaxReturn($response);

		}
	}

	public function updateEth()
	{
		if (IS_POST) {
			$user_id=session('user_id');
			$eth_addr=I('post.ethereum_address');
			if ($user_id && $eth_addr!='') {
				$res=M('User','mcop_',C('DB_CONFIG'))->where('user_id ='.$user_id)->setField('ethereum_address',$eth_addr);
				if ($res) {
					$response=[
						'code' =>'success',
						'message' =>'Success',
					];
					
				}else{
					$response=[
						'code' =>'failed',
						'message' =>'something errors',
					];
					
				}
			}else{
				$response=[
					'code' =>'failed',
					'message' =>'something error',
				];
				
			}

			$this->ajaxReturn($response);
		}
	}
}