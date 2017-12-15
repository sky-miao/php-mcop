<?php


namespace Home\Controller;

class UploadController extends BaseController
{


	public function idcardUpload()
	{

		if (IS_AJAX && session('isSignin')) {
			$config = array(
			    'maxSize'    =>    3145728,
			    'rootPath'   =>    './Uploads/',
			    'savePath'   =>    'idcards/',
			    'saveName'   =>    array('uniqid',''),
			    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			    'autoSub'    =>    true,
			    'subName'    =>    array('date','Ymd'),
			);

			$upload = new \Think\Upload($config);
		
		  	$user_id=session('user_id');
		  	$field = $_POST['name'];
		    $info   =   $upload->upload();
		    if(!$info) {// 上传错误提示错误信息
		        $this->ajaxReturn($upload->getError());;
		    }else{// 上传成功
		    	$imgUrl= '/Uploads/'.$info['file']['savepath'].$info['file']['savename'];
		    	M('User','mcop_',C('DB_CONFIG'))->where('user_id =%d',$user_id)->save(array($field=>$imgUrl));
		        $this->ajaxReturn($info);
		    }
		}
	}

	public function avatarUpload()
	{

		if (IS_AJAX && session('isSignin')) {
			$config = array(
			    'maxSize'    =>    3145728,
			    'rootPath'   =>    './Uploads/',
			    'savePath'   =>    'avatar/',
			    'saveName'   =>    array('uniqid',''),
			    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			    'autoSub'    =>    true,
			    'subName'    =>    array('date','Ymd'),
			);

			$upload = new \Think\Upload($config);
		
		  	$user_id=session('user_id');
		  	$field = $_POST['name'];
		    $info   =   $upload->upload();
		    if(!$info) {// 上传错误提示错误信息
		        $this->ajaxReturn($upload->getError());
		    }else{// 上传成功
		    	$imgUrl= '/Uploads/'.$info['file']['savepath'].$info['file']['savename'];
		    	M('User','mcop_',C('DB_CONFIG'))->where('user_id =%d',$user_id)->save(array($field=>$imgUrl));
		        $this->ajaxReturn($info);
		    }
		}
	}
}