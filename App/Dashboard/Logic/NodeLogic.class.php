<?php 

namespace Dashboard\Logic;

use Think\Model;

class NodeLogic extends Model
{
	protected $connection='DB_CONFIG';
	protected $tablePrefix = 'mcop_';
	
	public function getNodeList(){
		$data = $this->select();
		$data = node_tree($data,0);
	 	return $data;
	}


	/*添加节点*/
	public function addNewNode($post){

		$res = $this->add($post);
		
		return $res;
	}


	/*更新节点*/
	public function findNode($nodeId){
		return $this->where( array('id'=>$nodeId) )->find();
	}

	/*删除节点*/
	public function deleteNode($nodeId){
		M('Access','mcop_',C('DB_CONFIG'))->where(array('node_id'=>$nodeId))->delete();
		
		$this->where(array('id'=>$nodeId))->delete();

	}

	/*更新节点*/
	public function updateNode($data){
		$this->save($data);
	}
}