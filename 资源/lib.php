<?php


//header("Content-type:text/html;charset:utf-8");
define("APPID", "wx96629735ac2e7cf8"); //APPID
define("APPSECRET", "a00955de9882b91e3a1c445d5f01b455");//APPSECRET
$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;

function postMsg($url, $data){
 	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	$info = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Errno'.curl_error($ch);
	}
	curl_close($ch);
	return $info;
}


function getMsg($url){
	if(function_exists("file_get_contents")){ 
      $result =getFileGetContent($url);	return $result;
    }else{
    	$result = getCatch($url);
    }	
	return $result;
}

function getCatch($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
	$res = curl_exec($ch);
	$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $res;
}

function getFileGetContent($url){
	$result = file_get_contents($url);
	return $result;
}

function p($arr){ echo "<pre>";	var_dump($arr);	echo "</pre>";}
?>