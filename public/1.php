<?php

header('Content-Type:text/html; charset=utf-8');


    //step1. 요청을 위한 파라미터 설정
		$key       = "cjAo6CD95LpJS0S4";
        $mid       = $setting['inicis_mid'];
	    $type      = "partialRefund";
	    $timestamp = date("YmdHis");
	    $clientIp  = $_SERVER["REMOTE_ADDR"];
	
	$postdata = array();
	$postdata["mid"] = "thaitour37";
	$postdata["type"] = $type;
    $postdata["timestamp"] = $timestamp;
	$postdata["clientIp"] = $clientIp;
	
	//// Data 상세
    $detail = array();
	$detail["tid"] = "StdpayCARDthaitour3720250526095858348462";
	$detail["msg"] = "테스트취소";
	$detail["price"] = "8482";
	$detail["confirmPrice"] = "5000";
	$detail["currency"] = "WON";
	$detail["tax"] = "0";
	$detail["taxfree"] = "0";
	$postdata["data"] = $detail;
	
	$details = str_replace('\\/', '/', json_encode($detail, JSON_UNESCAPED_UNICODE));

	//// Hash Encryption
	$plainTxt = $key.$mid.$type.$timestamp.$details;
    $hashData = hash("sha512", $plainTxt);

	$postdata["hashData"] = $hashData;

	echo "plainTxt : ".$plainTxt."<br/><br/>"; 
	echo "hashData : ".$hashData."<br/><br/>"; 


	$post_data = json_encode($postdata, JSON_UNESCAPED_UNICODE);
	
	echo "**** 요청전문 **** <br/>" ; 
	echo str_replace(',', ',<br>', $post_data)."<br/><br/>" ; 
	
	
	//step2. 요청전문 POST 전송
	
	$url = "https://iniapi.inicis.com/v2/pg/partialRefund";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    $response = curl_exec($ch);
    curl_close($ch);
	
	
    //step3. 결과출력
	
	echo "**** 응답전문 **** <br/>" ;
	echo str_replace(',', ',<br>', $response)."<br><br>";
    
?>