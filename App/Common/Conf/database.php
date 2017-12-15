<?php

$mysql_ip      = '127.0.0.1';
$mysql_user    = 'root';
$mysql_pwd     = '';

return array(

//*************************************数据库设置*************************************
    'DB_CONFIG' => array(
        'DB_TYPE'       =>  'mysql',               // 数据库类型
        'DB_HOST'       =>  $mysql_ip,             // 服务器地址
        'DB_NAME'       =>  'mcop',                // 数据库名
        'DB_USER'       =>  $mysql_user,           // 用户名
        'DB_PWD'        =>  $mysql_pwd,            // 密码
        'DB_PORT'       =>  '3306',                // 端口
        'DB_PREFIX'     =>  '',                    // 数据库表前缀
    ),

    'RBAC_DB_DSN'  =>   array(
        'DB_TYPE'       =>  'mysql',      
        'DB_HOST'       =>  $mysql_ip,  
        'DB_NAME'       =>  'mcop',           
        'DB_USER'       =>  $mysql_user,      
        'DB_PWD'        =>  $mysql_pwd,     
        'DB_PORT'       =>  '3306',       
        'DB_PREFIX'     =>  '',  
    ),   //数据库连接DSN
    
    'RBAC_USER_TABLE'   => 'mcop_admin',         //用户表名称
    'RBAC_ROLE_TABLE'   => 'mcop_role' ,         //角色表名称
    'RBAC_USER_TABLE'   => 'mcop_role_user',     //用户表名称
    'RBAC_ACCESS_TABLE' => 'mcop_access' ,       //权限表名称
    'RBAC_NODE_TABLE'   => 'mcop_node' ,         //节点表名称
);