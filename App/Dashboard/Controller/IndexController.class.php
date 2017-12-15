<?php

namespace Dashboard\Controller;



class IndexController extends BaseController{

	public function index()
	{
		$admin_id = I('session.admin_id');

 		$data = D('Admin','Logic')->getWelcomeUserInfo($admin_id);
 		
 		$this->assign('data',$data);
		$this->display();
	}

	public function updateAdminPassword()
	{
		if (IS_POST && IS_AJAX) {
    		$admin_id=session('admin_id');
    		$password=I('post.password');
    		$result=D('Admin','Logic')->updatePassword($admin_id,$password);
    		if ($result) {
    			$this->ajaxReturn(['status'=>0]);
    		}else{
    			$this->ajaxReturn(['status'=>1]);
    		}
    	}else{
    		$this->ajaxReturn(['status'=>1]);
    	}
	}

    public function getAdminList()
    {
        $name='';
        if (IS_GET) {
            $name=I('get.name');
            if( !empty($_GET['formsearch']) ){
                $_GET['p'] = 1;
                unset($_GET['formsearch']);
            }
        }
        $data=D('Admin','Logic')->getAdminList($name);
        
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
       
        $this->display();
    }

    public function addNewAdmin()
    {
        if (IS_POST) {
            $postData=I('post.');
           
            $result=D('Admin','Logic')->addNewAdmin($postData);
            if ($result) {
                redirect(U('Index/getAdminList'));
            }else{
                $this->error('系统错误');
            }
            
        }
        $roleList = D('Role','Logic')->roleList();
        $this->assign('roleList',$roleList);
        $this->display();
    }

    public function deleteAdmin()
    {
       if (IS_POST && IS_AJAX) {
            $id=I('post.id');
            $result=D('Admin','Logic')->deleteAdmin($id);
            if ($result) {
                echo 'success';
            }else{
                echo 'faile';
            }
        }else{
            die('sorry');
        }
    }

    public function updateAdmin()
    {
        if (IS_POST) {
            $postData=I('post.');

            $result=D('Admin','Logic')->updateAdmin($postData);
            if ($result) {
                redirect(U('Index/getAdminList'));
            }else{
                $this->error('系统错误');
            }
        }
        $id=I('get.id');
        $data = D('Admin','Logic')->getAdmin($id);
        $roleList = D('Role','Logic')->roleList();
        $this->assign('roleList',$roleList);
        $this->assign('data',$data);
        //dump($data);exit;
        $this->display();
    }

    public function getRoleList()
    {
        $data = D('Role','Logic')->roleList();
        $this->assign('data',$data);
        $this->display();
    }

    public function addNewRole()
    {
        if(IS_POST){
            $postData = I('post.');
            D('Role','Logic')->addRole($postData);
            redirect(U('Index/getRoleList'));
            exit;
        }
        $node = D('Node','Logic')->where(array('status'=>1))->getNodeList();

        $this->assign('node',$node);
        $this->display();
    }

    public function updateRole()
    {
        if( IS_POST ){

            $post = I('post.');
            D('Role','Logic')->saveRole($post);
            redirect(U('Index/getRoleList'));
            exit;
        }

        $role_id = I('get.role_id');
        $data = D('Role','Logic')->getRole($role_id);
        $this->assign('data',$data);
        $this->display();
    }

    public function deleteRole()
    {
        $role_id=I('get.role_id');
       
        $result=M('RoleUser','mcop_',C('DB_CONFIG'))->where('role_id='.$role_id)->find();
        if ($result) {
            $this->error('该角色下还有用户不能删除~');
        }else{
            $re=M('Access','mcop_',C('DB_CONFIG'))->where('role_id='.$role_id)->delete();
            $res=M('Role','mcop_',C('DB_CONFIG'))->where('id='.$role_id)->delete();
            redirect(U('Index/getRoleList'));
        }
        
    }

    public function getNodeList()
    {
        $data= D('Node','Logic')->getNodeList();
          
        $this->assign('data',$data);
        $this->display();
    }

    public function addNewNode(){
        if(IS_POST){
            $post = I('post.');
            
            $res = D('Node','Logic')->addNewNode($post);
            if($res){
                S('admin',null);
                redirect(U('Index/getNodeList'));
            }else{
                $this->error('添加失败,请重试');
            }
            exit;
        }
        $this->display();
    }

    public function deleteNode(){
        $nodeId = I('get.dataid');
        D('Node','Logic')->deleteNode($nodeId);
        S('admin',null);
        redirect(U('Index/getNodeList'));
    }


    public function updateNode()
    {
        if(IS_POST){
            $postData = I('post.');
            D('Node','Logic')->updateNode($postData);
            S('admin',null);
            redirect(U('Index/getNodeList'));
        }

        $node_id = I('get.id');
        $data = D('Node','Logic')->findNode($node_id);
      
        $this->assign('data',$data);
        $this->display();
    }

    public function clearCache(){

        $adminIDs = D('Admin','Logic')->getAdminIDs();

        foreach($adminIDs as $admin_id){
            S('menu'.$admin_id,null);
        }
        S('admin',null);
        redirect(U('Index/getAdminList'));
    }
}