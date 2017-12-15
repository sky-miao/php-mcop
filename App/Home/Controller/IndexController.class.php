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
        $this->display();
    }

    public function downloadPDF()
    {
        $pfd_id=I('get.pdf_id');
        $file="./Uploads/pdf/".$pfd_id.".pdf";

        $download_name=md5(md5(basename($file,'.pdf').time()));
        ob_end_clean();
        $hfile=fopen($file, 'rb') or die('Can not find file');
        Header('Content-type:application/octet-stream');
        Header('Content-Transfer-Encoding:binary');
        Header('Accept-Ranges:bytes');
        Header('Content-Length:'.filesize($file));
        Header("Content-Disposition:attachment;filename=\"$download_name\".pdf");
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