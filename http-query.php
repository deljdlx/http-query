<?php

function httpQuery($url, $method='get', $data=array(), $headers=array()) {

	$method=strtoupper($method);

    $headerString='';
	$contentTypeHeader=false;
	
    foreach ($headers as $name=>$value) {
		if($name=='Content-type') {
			$contentTypeHeader=true;
		}
        $headerString.=$name.': '.$value."\r\n";
    }
	
	if(!$contentTypeHeader && $method=='POST') {
		$headerString='Content-type: application/x-www-form-urlencoded'."\r\n".$headerString;
	}


    $raw=http_build_query($data);
	
    $options = array(
        'http' => array(
            'header'  => $headerString."Content-Length: ".strlen($raw)."\r\n".$headerString,
            'method'  => $method,
            'content' => $raw,
            'request_fulluri' => true
        ),
    );
    $context  = stream_context_create($options);
    return file_get_contents($url, false, $context);
}


