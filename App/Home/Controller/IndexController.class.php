<?php
namespace Home\Controller;

class IndexController extends CommonController {

    public function index(){

    	
    	layout('Layout/index');
        $this->display();
    }


    public function errors()
    {
    	layout('Layout/layout');
    	$this->display();
    }

    public function whitepaper()
    {
        layout('Layout/layout');
        $articleModel =M('Articles','mcop_',C('DB_CONFIG'));
        $language =cookie('think_language');

        $pdfs =$articleModel ->where("type=3 and language='$language'")->select();
        if (empty($pdfs)) {
            $lang =$language =='zh-cn'?'en-us':'zh-cn';
            $pdfs =$articleModel ->where("type=3 and language='$lang'")->select();
        }
        $this->assign('pdfs',$pdfs);
        $this->display();
    }

    public function downloadPDF()
    {
        $pfd_id=I('get.pdf_id');

        $articleModel = M('Articles','mcop_',C('DB_CONFIG'));
        $article =$articleModel ->where('id=%d',$pfd_id)->find();

        $file=$article['url'];

        $download_name=$article['title'];

        ob_end_clean();
        $hfile=fopen($file, 'rb') or die('Can not find file');
        Header('Content-type:application/octet-stream');
        Header('Content-Transfer-Encoding:binary');
        Header('Accept-Ranges:bytes');
        Header('Content-Length:'.filesize($file));
        Header("Content-Disposition:attachment;filename={$download_name}.pdf");
        while (!feof($hfile)) {
            echo fread($hfile, 1024);
        }
        fclose($hfile);
    }


    public function tokensale()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function termsofuse()
    {
        $map['type'] =1;
        $map['language'] =cookie('think_language');

        $article= M('Articles','mcop_',C('DB_CONFIG'))->where($map)->find();
        if (empty($article)) {
            $map['language'] =C('DEFAULT_LANG');
            $article= M('Articles','mcop_',C('DB_CONFIG'))->where($map)->find();
        }
        $this->assign('article',$article);
        layout('Layout/layout');

        $this->display();
    }

    public function privacypolicy()
    {
        $map['type'] =2;
        $map['language'] =cookie('think_language');

        $article= M('Articles','mcop_',C('DB_CONFIG'))->where($map)->find();
        if (empty($article)) {
            $map['language'] =C('DEFAULT_LANG');
            $article= M('Articles','mcop_',C('DB_CONFIG'))->where($map)->find();
        }
        $this->assign('article',$article);
        layout('Layout/layout');
        $this->display();
    }

    

}