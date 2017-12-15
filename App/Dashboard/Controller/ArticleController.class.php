<?php


namespace Dashboard\Controller;


class ArticleController extends BaseController
{
	public function articleList()
	{
		$articles= M('Articles','mcop_',C('DB_CONFIG'))->select();

		$this->assign('articles',$articles);
		$this->display();
	}


	public function addArticle()
	{

		$language=C('LANG_LIST');
		$lang=explode(',', $language);
		$this->assign('lang',$lang);
		$this->display();
	}

	public function doAddAriticle()
	{
		if (IS_POST) {
			$post= I('post.');
			if ($post['type'] =='0') {
				$this->error('未选择类型.');
			}
			$post['created_at'] =time();
			$post['updated_at'] =$post['created_at'];
			$articleModel = M('Articles','mcop_',C('DB_CONFIG'));
			if ($post['type']=='3') { // white paper
				$file=$_FILES['pdf'];
				
				$post['url']=$this->uploadPDF($file);
				\Think\Log::write($post['url'],'WARN');
				if (!$post['url']) {
					$this->error('文件上传错误 文件格式错误或者文件太大.');
				}

			}
			$article=$articleModel->create($post);
			$articleModel->add();
			redirect(U('Article/articleList'));
			
		}
	}

	public function uploadPDF($file)
	{
		
		$config = array(
		    'maxSize'    =>    3145728,
		    'rootPath'   =>    './Uploads/',
		    'savePath'   =>    'pdf/',
		    'saveName'   =>    array('uniqid',''),
		    'exts'       =>    array('pdf'),
		    'autoSub'    =>    true,
		    'subName'    =>    array('date','Ymd'),
		);

		$upload = new \Think\Upload($config);
	
	  	$user_id=session('user_id');
	  	$field = $_POST['name'];
	    $info   =   $upload->uploadOne($file);
	   
	    if(!$info) {// 上传错误提示错误信息
	    	
	    	\Think\Log::write(json_encode($upload->getError()),'WARN');
	        return false;
	    }else{// 上传成功
	    	
	    	return $pdfurl= '/Uploads/'.$info['savepath'].$info['savename'];
	    	
	    }
	}

	public function updateArticle()
	{
		$id=I('get.article_id');
		$language=C('LANG_LIST');
		$lang=explode(',', $language);
		$this->assign('lang',$lang);
		$articleModel = M('Articles','mcop_',C('DB_CONFIG'));
		$article =$articleModel->where('id='.$id)->find();
		$this->assign('article',$article);
		$this->display();
	}

	public function doUpdateAriticle()
	{
		if (IS_POST) {
			$post= I('post.');
			
			
			$post['updated_at'] =time();
			$articleModel = M('Articles','mcop_',C('DB_CONFIG'));
			if ($post['type']=='3') { // white paper
				$file=$_FILES['pdf'];

				if (!empty($file['name'])) {
					$post['url']=$this->uploadPDF($file);
					\Think\Log::write($post['url'],'WARN');
					if (!$post['url']) {
						$this->error('文件上传错误 文件格式错误或者文件太大.');
					}
				}
			}
			
			$articleModel->save($post);
			redirect(U('Article/articleList'));
			
		}
	}
}