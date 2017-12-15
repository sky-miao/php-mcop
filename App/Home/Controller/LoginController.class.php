<?php

namespace Home\Controller;

class LoginController extends BaseController{

    
	public function login()
    {
    	if (session('isSignin')) {
            redirect(U('User/index'));
        }
    	layout('Layout/layout');
    	$this->display();
    }


    public function doLogin()
    {
        if (IS_POST) {
            $postData=I('post.');
            if (session('loginErrorNum')>5) $this->error(L('loginErrorNum'));
            if (!empty($postData['email']) && !empty($postData['pass'])) {
                $salt='mcop!@#$';
                $map['email']=$postData['email'];
                $map['password']=md5(md5($postData['pass'].$salt));
                $map['is_active']=1;
                
                $result=D('User')->checkUserLogin($map);
                
                if ($result) {
                    $_SESSION['isSignin']  = true;
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['email'] = $result['email'];
                    
                  
                    
                    /*登录行为记录*/
                    B('\Home\Behaviors\LoginLog','',$result['user_id']);
                    
                    redirect(U('User/index'));
                }else{
                    session(array('name'=>'loginErrorNum','expire'=>3600));
                    $_SESSION['loginErrorNum']+=1;
                    $this->error(L('email_or_passord_error'));
                }
            }else{
                $this->error('登录名和密码不能为空.');
            }
        }

    }



    public function register()
    {
        if (session('isSignin')) {
            redirect(U('User/index'));
        }
       
    	layout('Layout/layout');
    	$this->display();
    }

    public function doRegister()
    {
        if (IS_POST) {
            $postData=I('post.');

            if (empty($postData['email']) || empty($postData['pass'])) {
                $this->error(L('emptyRegisterForm'));
            }

            if ($postData['pass'] != $postData['repass']) {
                $this->error(L('passwordConfim'));
            }
            $email=stringFilter($postData['email']);
            $password=trim($postData['pass']);
            $email_exist= D('User')->checkEmailUsing($email);
            if ($email_exist) {
                $this->error(L('emailExist'));
            }
            $user= D('User')->registerUser($email,$password);
            if ($user) {
                
                $sendEmail=A('Email')->sendMailToRegister($user);
                if ( $sendEmail) {
                    session('isSignin',true);
                    session('user_id',$user['user_id']);
                    session('email',$user['email']);
                    session('message.registersuccess',L('registersuccess'));
                    redirect(U('Home/User/index'));
                    exit;
                }else{
                     $this->error('system error.');
                }
                
            }else{
                $this->error('system error.');
            }
        }

       
    }


    public function checkEmailUsing()
    {
        if (IS_POST && IS_AJAX) {
            $email=I('post.email');
            $result =D('User')->checkEmailUsing($email);
            if ($result) {
                $response =[
                    'code' =>'failed',
                    'message' =>'Mailbox has been occupied.',
                ];
            }else{
                $response =[
                    'code' =>'success',
                    'message' =>'',
                ];
            }

            $this->ajaxReturn($response);
        }
    }

    public function resetPassword()
    {
        if (session('isSignin')) {
            redirect(U('User/index'));
        }
       
        layout('Layout/layout');
        $this->display();
    }


    public function resetPasswordEmail()
    {
        if (IS_POST && IS_AJAX) {
            $email=I('post.email');
            $email=stringFilter($email);
            $result=A('Email')->sendMailToResetPassword($email);
            if ($result) {
                $response=[
                    'code' =>'success',
                    'msg' =>'success',
                ];
            }else{
                $response=[
                    'code' =>'failed',
                    'msg' =>'failed',
                ];
            }

            $this->ajaxReturn($response);
        }
    }


    public function logout()
    {
        session_destroy();
        redirect(U('Index/index'));
    }

    public function doResetPassword()
    {
        if (session('isSignin')) {
            redirect(U('User/index'));
        }else{
            $user_id=I('get.user');
            $token=I('get.token');
            
            $isToken =D('User')->checkToken($user_id,$token);

            if (!empty($token) && $isToken) {
                cookie('user_id',$user_id,1800);
                cookie('pass_token',$token,1800);
                layout('Layout/layout');
            
                $this->display();
            }else{

                layout('Layout/layout');
            
                $this->display('Errors/tokenError');
               
            }
        }
        

    }

    public function reset()
    {
        if (IS_POST) {
            $postData = I('post.');

            $user =D('User')->checkToken($postData['user_id'],$postData['token']);

            if ($user && $postData['pass'] ==$postData['pass_confirm']) {
                $salt ='mcop!@#$';
                $data['password']=md5(md5($postData['pass'].$salt));
                $data['password_confirm_code'] =stringCode();
                $result = M('User','mcop_',C('DB_CONFIG'))->where('user_id='.$user['user_id'])->save($data);
             
                if ($result) {
                    session('isSignin',true);
                    session('user_id',$user['user_id']);
                    session('email',$user['email']);
                    session('message.resetpasswordsuccess',L('resetpasswordsuccess'));
                    
                    redirect(U('User/index'));
                }else{
                    redirect(U('Login/errorAction',array('code'=>'failed')));
                }

            }

        }
    }

    public function errorAction()
    {

        layout('Layout/layout');
        $this->display('Errors/tokenError');
    }

    public function emailVerify()
    {

        $user_id=I('get.user');
        $token =I('get.token');
        
        $isToken =D('User')->checkEmailToken($user_id,$token);
        if ($isToken) {

            $data=[
                'email_confirm' =>1,
                'email_confirm_code' =>stringCode(48),
            ];
            $res=M('User','mcop_',C('DB_CONFIG'))
                ->where('user_id =%d and email_confirm_code ="%s"',array($user_id,$token))
                ->save($data);
            if (!session('isSignin')) {
                session('user_id',$isToken['user_id']);
                session('isSignin',true);
                session('email',$isToken['email']);
                
            }
            session('message.email_is_confirm',L('email_is_confirm'));
            redirect(U('User/index'));

        }else{
            redirect(U('Index/errors'));
        }

    }
}