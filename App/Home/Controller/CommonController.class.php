<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller{

	public function _initialize()
	{
		
		// $site_status=D('Settings')->getSettings('site_status');
		// if ($site_status!=1) {
		// 	$this->show('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><title>MCOP</title><link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"><style>html,body{background-color:#fff;color:#636b6f;font-family:Raleway,sans-serif;font-weight:100;height:100vh;margin:0}.full-height{height:100vh}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.content{text-align:center}.title{font-size:36px;padding:20px}</style></head><body><div class="flex-center position-ref full-height"><div class="content"><div class="title">Be right back.</div></div></div></body></html>');
		// 	exit;

		// }
		$lang=cookie('think_language');
		$langList =C('LANG_LIST');
		$langArr =explode(',', $langList);

		$this->assign('langArr',$langArr);
		if (session('isSignin')) {
            $user_id=session('user_id');
            $user=D('User')->getUser($user_id);
            $this->assign('user',$user);
        }
	}
}