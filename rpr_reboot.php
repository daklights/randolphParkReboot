<?php

	if (isset($_GET['p']) && is_numeric($_GET['p'])) {
		$targetPowerState = $_GET['p'];
	} else {
		die();
	}

	function getControllers() {
		$url = "http://127.0.0.1/api/channel/output/universeOutputs";
		$options = array(
			'http' => array(
				'method'  => 'GET'
			)
		);
		$context = stream_context_create( $options );
		$result = file_get_contents( $url, false, $context );		
		return $result;
	}
	
	function toggleDevicePower($ipAddress,$newPowerState) {
		$dataToSend = '{"on":'.$newPowerState.'}';
		$urlToCall = "http://".$ipAddress."/json/state";		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $urlToCall);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $dataToSend);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 5);
		$json_response = curl_exec($curl);
		$statusPut = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($statusPut != 200) {
			return false;
			//die("Error: call to URL failed with status $statusPut, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		} else {
			return true;
			//echo $ip . "<br />";
			//print_r($json_response);
			//echo "<br /><hr /><br />";
		}
	}
	
	$c = getControllers();
	$d = json_decode($c,true);
	
	foreach ($d['channelOutputs']['universes'] as $key=>$val) {
		print_r($key) . "<br /><br />";
		print_r($val) . "<br /><br /><hr />";
	}	
	
?>