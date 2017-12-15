<?php

$db=include_once (dirname(__FILE__)."/database.php");


$conf=array(
	'SHOW_PAGE_TRACE' =>true,  //开发模式
	'URL_MODEL'     =>  2, //URL访问模式,可选参数0/1/2/3
    
   
	/* 权限认证配置 start */

	'USER_AUTH_ON' => true,      //是否需要认证
    'USER_AUTH_TYPE' => 2 ,      //认证类型
    'USER_AUTH_KEY'  =>'admin_id',      //认证识别号
    'NOT_AUTH_MODULE' => 'Login,Public',    //无需认证模块
    'USER_AUTH_GATEWAY' =>'Dashboard/Login/login' ,  //认证网关
    'ADMIN_AUTH_KEY'    => 'supper_admin',
    'ADMIN'             => 'admin',  /*超级管理员账号-如果修改超级管理员用户名,此处需要修改*/
    /* 权限认证配置 end */

    'DEFAULT_MODULE'        =>  'Home',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'Index', // 默认操作名称

    'MAIL_DEBUG'       =>0,   // 0 off  1  client messages 2  client and server messages
    'MAIL_HOST'        =>'smtp.163.com' ,
    'MAIL_PORT'        =>'25' ,
    'MAIL_USERNAME'    =>'ishaiua@163.com',
    'MAIL_PASSWORD'    =>'Lian0000',
    'MAIL_TITLE'       =>'MCOP',
    'LANG_LIST'        => 'zh-cn,en-us',

);


return array_merge($conf,$db);