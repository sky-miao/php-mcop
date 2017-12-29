<?php


namespace Dashboard\Controller;


class SettingController extends BaseController
{

	public function setting()
	{
		if (IS_POST) {
			$postData =I('post.');
			$result=D('Settings')->saveSettings($postData);

			redirect(U('Setting/setting'));
			exit;
		}
		$settings=D('Settings')->getSettings();

		$this->assign('settings',$settings);
		$this->display();
	}

	
}