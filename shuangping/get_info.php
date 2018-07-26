<?php
header("Content-type:text/html;charset=utf-8");
if( !isset($_COOKIE['wechat_info']) )
{
	include('wechat_info.class.php');
	$auth = new Auth();
	$type = 'info'; //base静默授权,info登录授权
	if( empty($_GET['code']) )
	{
		$redirect_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //需要获取code的页面
		$state="STATE";
		$url = $auth->get_authorize_url($redirect_url, $type);
		header("Location:".$url); 
	}
	else
	{
	  	$code = $_GET['code'];
	  	$json_obj = $auth -> get_access_token($code);// get_access_token()方法能够获取openid，access_token等信息
	  	if( empty($json_obj['openid']) )
	  	{
	  		echo 'error:('.$json_obj['errcode'].'):'.$json_obj['errmsg'];
	  		die();
	  	}

	  	$wechat_info['openid'] = $json_obj['openid'];

	  	if( $type == 'info' )
	  	{
	  		$info = $auth->get_user_info($json_obj['access_token'], $json_obj['openid']);
	  		if( empty($info['openid']) )
	  		{
	  			echo 'error:('.$json_obj['errcode'].'):'.$json_obj['errmsg'];
	  			die();
	  		}
	  		$wechat_info = $info;
	  	}
	  	setcookie('wechat_info', serialize($wechat_info), time()+7200);
	}
}
else
{
	$wechat_info = unserialize($_COOKIE['wechat_info']);
}

var_dump($wechat_info);
?>