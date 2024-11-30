<?php

	include_once "rpr_common.php";
	
	$pluginName = basename(dirname(__FILE__));
	$pluginConfigFile = $settings['configDirectory'] . "/plugin." .$pluginName;
	$pluginSettings = parse_ini_file($pluginConfigFile);
	
	$deviceData = getDeviceData();
	$playingData = getCurrentPlayingData();
	$combined = array_merge(json_decode($deviceData,true),json_decode($playingData,true));
	
	echo "Randolph Park Reboot Data<br /><br />";
	
	echo "Temp: " . round(((($combined['tempC']/1000)*(9/5))+32),2) . "<br />";
	echo "Serial: " . $combined['serial'] . "<br />";
	echo "Eth0 Address: " . $combined['eth0Addr'] . "<br />";
	echo "Wlan0 Address: " . $combined['wlan0Addr'] . "<br /><br />";
	
	echo "Device Time: " . date('Y-m-d h:i:sa',$combined['time']) . "<br />";
	echo "Device Time Epoch: " . $combined['time'] . "<br /><br />";

	echo "Current Sequence: " . $combined['currentSequence'] . "<br />";
	echo "Elapsed Seconds: " . $combined['secondsElapsed'] . "<br />";
	echo "Uptime Seconds: " . $combined['uptimeTotalSeconds'] . "<br /><br />";
	
	echo "Reboot Sequences: " . (array_key_exists('rebootSequences',$pluginSettings) ? trim($pluginSettings['rebootSequences']) : '') . "<br /><br />";

?>