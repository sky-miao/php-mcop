<?php 
	
namespace Dashboard\Logic;

use Think\Model;

class AdminLogic extends Model{

	protected $connection  = 'DB_CONFIG';
	protected $tablePrefix = 'mcop_';
	

	
	public function getWelcomeUserInfo($admin_id){

		$data = $this
			->where( array('admin_id'=>$admin_id) )
			->find();
	   	return $data;
	}

	public function updatePassword($admin_id,$password)
	{
		$salt='mcop!@#$';
		$password_salt=md5(md5($password.$salt));
		$data = array('password'=>$password_salt);
		$result = $this
			->where(array('admin_id'=>$admin_id))
			->save($data);
		return $result;
	}

	public function getAdminList($name='')
	{
		$map=[];
		$where=[];

		if (!empty($name)) {
			$where['name']=$name;

			$map['a.name'] =$name;
		}
		
		$count=$this->where($where)->count();
		
		
		$Page = new \Think\Page($count,20);
		$page  = $Page -> show();

		$join = 'as a left join __ROLE_USER__ as c on a.admin_id=c.user_id left join __ROLE__ as d on c.role_id=d.id';
		
			/*根据uid进行分组,找到组内最大的login_time*/
		$data = $this
			  ->join($join)
			  ->field('a.admin_id,a.name ,a.truename,m_count,email,is_active,current_login_time,d.name as role_name')
			  
			  ->where($map)
			  ->order('admin_id asc')
			  ->limit($Page->firstRow.','.$Page->listRows)
			  ->select();

		return array('data' => $data , 'page' => $page);
	}

	public function addNewAdmin($post)
	{
		//dump($post);exit;
		$salt = 'mcop!@#$';
		$post['password'] = md5(md5($post['password'].$salt));
		$post['current_login_ip']=get_client_ip();
		$post['current_login_time']=time();
		$post['prev_login_ip']=get_client_ip();
		$post['prev_login_time']=time();
		$post['session_id']='';
		
		$id = $this->data($post)->add();
		
		$roleUser = array(
			'user_id' => $id,
			'role_id' => $post['role_id']
		);

		$res = M('RoleUser','mcop_',C('DB_CONFIG'))->data($roleUser)->add();
		return $id;
	}

	public function deleteAdmin($id)
	{
		M('RoleUser','mcop_',C('DB_CONFIG'))->where('user_id='.$id)->delete();
		
		return $this->where('admin_id ='.$id)->delete();
		
	}

	public function getAdmin($id)
	{
		$field="a.admin_id as admin_id,a.name as name ,email,is_active,a.remark as remark,truename,current_login_ip,current_login_time,m_count,prev_login_ip,prev_login_time,c.name as rolename,b.role_id as role_id";
		$admin = $this
			  ->field($field)
			  ->join(' as a left join __ROLE_USER__ as b on a.admin_id=b.user_id left join __ROLE__ as c on b.role_id=c.id ')
			  ->where('a.admin_id='.$id)
			  ->find();
		return $admin;	
	}

	public function updateAdmin($post)
	{

		if (!empty($post['password'])) {
			$salt = 'mcop!@#$';
			$data['password'] = md5(md5($post['password'].$salt));
		}
		$data['admin_id']=$post['id'];
		$data['is_active'] =$post['is_active'];
		$data['remark']=$post['remark'];
		$data['email']=$post['email'];
		$data['truename'] =$post['truename'];

		$admin=$this->save($data);
		$info=M('RoleUser','mcop_',C('DB_CONFIG'))->where('user_id='.$post['id'])->find();
		if ($info) {
			$res = M('RoleUser','mcop_',C('DB_CONFIG'))
			 ->where('user_id='.$post['id'])
			 ->save(['role_id'=>$post['role_id']]);
		}else{
			$roleUser = array(
				'user_id' => $post['id'],
				'role_id' => $post['role_id']
			);
			$res = M('RoleUser','mcop_',C('DB_CONFIG'))->data($roleUser)->add();

		}
		
		return true;
	}

	public function getAdminIDs()
	{
		return $this->field('admin_id')->select();
	}

}