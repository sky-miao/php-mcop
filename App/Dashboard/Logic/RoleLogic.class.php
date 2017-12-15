<?php 

namespace Dashboard\Logic;

use Think\Model;

class RoleLogic extends Model
{
	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';
	
	public function roleList()
	{
		return $this->order('id')->select();
	}

	public function addRole( $postData )
	{
		$access = $postData['access'];
		unset($postData['access']);
			
		/*角色表*/
		$roleId = $this->add($postData);

		/*角色节点表*/
		$count = count($access);
		for( $i=0;$i<$count;++$i ){
			$data[$i]['role_id'] = $roleId;
			$data[$i]['node_id'] = $access[$i];
		}
		
		 
		$accessModel = M('Access','mcop_',C('DB_CONFIG'));
		

		$res = $accessModel->where( array('role_id'=>$roleId) )->delete();

		  
		if($accessModel->addAll($data)){
			
			return true;	
		}
			
		
		return false;		  	 
	}

	public function getRole($role_id)
	{	
		$data = $this->where(array('id'=>$role_id))->find();

		/*相关权限*/
		$checknode = M('Access','mcop_',C('DB_CONFIG'))->where(array('role_id'=>$role_id))->getFIeld('node_id',true);
		

		$nodelist = D('Node','Logic')->getNodeList();
			 
		return array('data'=>$data,'nodelist'=>$nodelist,'checknode'=>$checknode);
	}

	public function saveRole($postData){
			
		$access = $postData['access'];
		unset($postData['access']);

		$this->where(array('id'=>$postData['roleId']))->data($postData)->save();
	
		$accessModel = M('Access','mcop_',C('DB_CONFIG'));
		
		/*角色节点表*/
		$count = count($access);
			for( $i=0;$i<$count;++$i ){
				$data[$i]['role_id'] = $postData['roleId'];
				$data[$i]['node_id'] = $access[$i];
				$data[$i]['level']   = 0;
			}


		

		$res = $accessModel->where(array('role_id'=>$postData['roleId']))->delete();

	
		if($accessModel->addAll($data)){
			
			return true;
		}
	
		
		return false;
	}
}