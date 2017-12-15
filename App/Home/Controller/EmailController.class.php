<?php


namespace Home\Controller;

use Think\Controller;

class EmailController extends Controller
{



	public function sendMailTo($email,$username,$subject,$body,$IsHTML=true)
	{

		require './ThinkPHP/Library/Vendor/PHPMailer//PHPMailerAutoload.php';

		
		$mail = new \PHPMailer(true);
		
		$mail->isSMTP();

		

		$mail->CharSet="utf-8";
		
		$mail->SMTPDebug = C('MAIL_DEBUG');
		
		
		$mail->Host = C('MAIL_HOST');
	
		$mail->Port = C('MAIL_PORT');
		
		$mail->SMTPAuth = true;
		
		$mail->Username = C('MAIL_USERNAME');
		
		$mail->Password = C('MAIL_PASSWORD');
		
		$mail->setFrom(C('MAIL_USERNAME'), C('MAIL_TITLE'));
		
		$mail->addReplyTo(C('MAIL_USERNAME'), C('MAIL_TITLE'));
		
		$mail->addAddress($email, $username);
	
		$mail->Subject = $subject;
		
		$mail->IsHTML($IsHTML);

		$mail->Body=$body;
		//send the message, check for errors
		if (!$mail->send()) {
			\Think\Log::write($mail->ErrorInfo,'WARN');
		    return false;
		} else {
		    return true;
		}
	}



	public function sendMailToRegister($user)
	{

		$contract=C('MAIL_USERNAME');
		
		$subject='Welcome to join MCOP';	
		$body = <<<EOD
		<div style="background-color:#ECECEC; padding: 35px;">
		<table cellpadding="0" align="center" style="width: 600px; margin: 0px auto; text-align: left; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; font-size: 14px; font-family:微软雅黑, 黑体; line-height: 1.5; box-shadow: rgb(153, 153, 153) 0px 0px 5px; border-collapse: collapse; background-position: initial initial; background-repeat: initial initial;background:#fff;">
		<tbody>
		<tr>
			<th valign="middle" style="height: 25px; line-height: 25px; padding: 15px 35px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #C46200; background-color: #009688; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
			<font face="微软雅黑" size="5" style="color: rgb(255, 255, 255); "> MCOP </font>
			</th>
		</tr>
		<tr>
			<td>
			<div style="padding:25px 35px 40px; background-color:#fff;">
			<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4" >Hi,{$user['email']}：</font></font></h2>
			<h3>welcome join us！</h3>
			<p align="right"><a href="http://www.mcop.app">MCOP</a></p>
			<p align="right">Contract us email: {$contract}</p>
			</div>
			</td>
		</tr>
		</tbody>
		</table>
		</div>
EOD;

		$subject ='Welcome to  mcop ';
		return $this->sendMailTo($user['email'],$user['email'],$subject,$body);
	}

	public function sendMailToResetPassword($email)
	{
		$userModel=M('User','mcop_',C('DB_CONFIG'));
		$user=$userModel->where("email= '%s'",array($email))->find();
		$token=stringCode(64);
		$userModel->where("email= '%s'",array($email))->save(array('password_confirm_code'=>$token));
		$contract=C('MAIL_USERNAME');
		$link =$_SERVER['HTTP_HOST']."/Home/Login/doResetPassword/user/{$user['user_id']}/token/{$token}/lang/".cookie('think_language');

		$subject='';	

		$body = <<<EOD
		<div style="background-color:#ECECEC; padding: 35px;">
		<table cellpadding="0" align="center" style="width: 600px; margin: 0px auto; text-align: left; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; font-size: 14px; font-family:微软雅黑, 黑体; line-height: 1.5; box-shadow: rgb(153, 153, 153) 0px 0px 5px; border-collapse: collapse; background-position: initial initial; background-repeat: initial initial;background:#fff;">
		<tbody>
		<tr>
			<th valign="middle" style="height: 25px; line-height: 25px; padding: 15px 35px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #C46200; background-color: #009688; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
			<font face="微软雅黑" size="5" style="color: rgb(255, 255, 255); "> MCOP </font>
			</th>
		</tr>
		<tr>
			<td>
			<div style="padding:25px 35px 40px; background-color:#fff;">
			<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4" >Hi,{$user['email']}：</font></font></h2>
			<h3>Reset Password Link :</h3>
			<p> {$link} </p>
			<p align="right"><a href="http://www.mcop.app">MCOP</a></p>
			<p align="right">Contract us email: {$contract}</p>
			</div>
			</td>
		</tr>
		</tbody>
		</table>
		</div>
EOD;

		$subject ='MCOP:Reset your password';
		return $this->sendMailTo($user['email'],$user['email'],$subject,$body);

	}

	public function sendMailToVerifyEmail($email=null)
	{
		if ($email==null) {
			$email=session('email');
		}

		$userModel=M('User','mcop_',C('DB_CONFIG'));
		$user=$userModel->where("email= '%s'",array($email))->find();
		$token=stringCode(48);
		$userModel->where("email= '%s'",array($email))->save(array('email_confirm_code'=>$token));
		$contract=C('MAIL_USERNAME');
		$link =$_SERVER['HTTP_HOST']."/Home/Login/emailVerify/user/{$user['user_id']}/token/{$token}/lang/".cookie('think_language');

		$subject='';	

		$body = <<<EOD
		<div style="background-color:#ECECEC; padding: 35px;">
		<table cellpadding="0" align="center" style="width: 600px; margin: 0px auto; text-align: left; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; font-size: 14px; font-family:微软雅黑, 黑体; line-height: 1.5; box-shadow: rgb(153, 153, 153) 0px 0px 5px; border-collapse: collapse; background-position: initial initial; background-repeat: initial initial;background:#fff;">
		<tbody>
		<tr>
			<th valign="middle" style="height: 25px; line-height: 25px; padding: 15px 35px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #C46200; background-color: #009688; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
			<font face="微软雅黑" size="5" style="color: rgb(255, 255, 255); "> MCOP </font>
			</th>
		</tr>
		<tr>
			<td>
			<div style="padding:25px 35px 40px; background-color:#fff;">
			<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4" >Hi,{$user['email']}：</font></font></h2>
			<h3>Confirm Email Activate :</h3>
			<p><a href="{$link}" style="
				background: #096  repeat-x;
		display: inline-block;
		padding: 5px 10px 6px;
		color: #eee;
		text-decoration: none;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
		-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
		-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
		text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
		border-bottom: 1px solid rgba(0,0,0,0.25);
		position: relative;
		cursor: pointer">Activate Account</a> </p>
			<p> {$link} </p>
			<p align="right"><a href="http://www.mcop.app">MCOP</a></p>
			<p align="right">Contract us email: {$contract}</p>
			</div>
			</td>
		</tr>
		</tbody>
		</table>
		</div>
EOD;

		$subject ='Confirm Your Email Activate';
		return $this->sendMailTo($user['email'],$user['email'],$subject,$body);
	}
}