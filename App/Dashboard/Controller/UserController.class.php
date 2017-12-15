<?php


namespace Dashboard\Controller;


class UserController extends BaseController
{

	public function userList()
	{
		$email='';
        if (IS_GET) {
            $email=I('get.email');
            if( !empty($_GET['formsearch']) ){
                $_GET['p'] = 1;
                unset($_GET['formsearch']);
            }
        }
        $data=D('User')->getUserList($email);
        
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
		$this->display();
	}


	public function userDetail()
	{

		if (IS_POST) {
			$postData=I('post.');
			//dump($postData);exit;
			$result =D('User')->changeKYCValidate($postData);
			if (!$result) {
				$this->error('未发生修改或者系统错误。');
			}else{
				//发送邮件
				A('Email')->sendMailForKYCResult($postData['email']);
				redirect(U('User/userDetail',array('user_id'=>$postData['user_id'])));
			}

		}
		$user_id=I('get.user_id');
		$user = D('User')->getUser($user_id);
		$this->assign('user',$user);
		$this->display();

	}
}