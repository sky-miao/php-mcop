<?php

namespace Dashboard\Controller;
use Think\Controller;

class LoginController extends Controller
{
	public function login()
	{
		if (IS_POST) {
			$postData = I('post.');
			if (session('loginErrorNum')>5) $this->error('登录错误次数过多，请勿再尝试~');
			if (!empty($postData['name']) && !empty($postData['password'])) {
				$salt='mcop!@#$';
				$map['name']=$postData['name'];
				$map['password']=md5(md5($postData['password'].$salt));
				$map['is_active']=1;
				
				$result=D('Admin')->checkAdminLogin($map);
				
				if ($result) {
					$_SESSION['isLogin']  = 1;
					$_SESSION['admin_id'] = $result['admin_id'];
					
					$_SESSION['name'] = $result['name'];
					$_SESSION['email'] = $result['email'];
					
					/*如果是超级管理员,给true*/
					if( $result['name']===C('ADMIN') ){
						session(C('ADMIN_AUTH_KEY'),true);
					}
					
					/*登录行为记录*/
					B('\Dashboard\Behaviors\LoginLog','',$result['admin_id']);
					
					redirect(U('Dashboard/Index/index'));
				}else{

					$_SESSION['loginErrorNum']+=1;
					$this->error('用户名或密码错误.');
				}
			}else{
				$this->error('登录名和密码不能为空.');
			}

		}
		$this->display();
	}


	public function logout()
	{	
		session_destroy();
		redirect(U('Dashboard/Login/Login'));
	}
}