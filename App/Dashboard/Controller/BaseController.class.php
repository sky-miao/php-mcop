<?php

namespace Dashboard\Controller;
use Think\Controller;
use Org\Util\Rbac;

class BaseController extends Controller
{
	public function _initialize()
	{

		if (session('isLogin')!=1 && empty(session('name'))) {
			redirect(U('Dashboard/Login/login'));
		}

		if (!Rbac::checkLogin()) {
			$this->error('你还没有登录呢.',U('Dashboard/Login/login'));
		}

		if (!IS_AJAX) {
			if (!Rbac::AccessDecision()) {
			
				$this->error('没有访问权限.');
			}
		}
		

		if (!session(C('ADMIN_AUTH_KEY'))) {
			$id=session('admin_id');
			if (!$menu=S('menu'.$id)) {
				$map['user_id']=$id;
				$map['show']=1;

				$menu = M('RoleUser','mcop_',C('DB_CONFIG'))
					  ->join('as a left join mcop_access as b on a.role_id = b.role_id')
					  ->join('mcop_node as c on c.id=b.node_id')
					  ->where($map)
					  ->order('node_id')
					  ->select();
				S('menu'.$id,$menu);
			}
			
		

		}else{
			if( !$menu=S('admin') ){
				$map['show']    = 1; //是否在前台栏目显示
				
				
				$menu = M('Node','mcop_',C('DB_CONFIG'))->where($map)->select();
				S('admin',$menu);
			}
		}
		
		$menu = node_tree($menu,1);
		$this->assign('menu',$menu);

	}

	
}