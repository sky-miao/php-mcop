<?php
function node_tree($data,$pid){
	$arr = array();
	foreach($data as $value){
		if($value['pid'] == $pid){
			$value['child'] = node_tree($data,$value['id']);
			$arr[] = $value;
		}
	}
	return $arr;
}

function node_level($level){
	switch( $level ){
        case '1':
        	return '模块';break;
        case '2':
        	return '控制器';break;
        case '3':
        	return '方法'; break; 
   }     
}

function recaptchaPost($postData)
{
	

	$curl = curl_init();
	$url ="https://www.google.com/recaptcha/api/siteverify";
	curl_setopt_array($curl, 
		array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($postData),
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/x-www-form-urlencoded"
			),
		)
	);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		dump($err);exit;
	} else {
		return json_decode($response,true);
	}
}
