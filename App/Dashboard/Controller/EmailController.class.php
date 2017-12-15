<?php


namespace Dashboard\Controller;

use Think\Controller;

class EmailController extends BaseController
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





	public function sendMailForKYCResult($email=null)
	{
		if ($email==null) {
			return false;
		}
		$subject='';
		$userModel=M('User','mcop_',C('DB_CONFIG'));
		$user=$userModel->where("email= '%s'",array($email))->find();
		
		if ($user['kyc_validate']==2) {
			$subject ='Congratulations on the approval for KYC Validate';
		}else{
			$subject ='Sorry ,Audit failure for KYC Validate.';
		}
		$contract=C('MAIL_USERNAME');
		$loginLink =$_SERVER['HTTP_HOST']."/Home/Login/login/";

			

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
			<h3>{$subject}</h3>
			<p><a href="{$loginLink}" style="
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
		cursor: pointer">Go to Login</a> </p>
		
			<p align="right"><a href="http://www.mcop.app">MCOP</a></p>
			<p align="right">Contract us email: {$contract}</p>
			</div>
			</td>
		</tr>
		</tbody>
		</table>
		</div>
EOD;

		
		return $this->sendMailTo($user['email'],$user['email'],$subject,$body);
	}
}