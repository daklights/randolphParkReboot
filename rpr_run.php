<?php

	include_once "/home/fpp/media/plugins/randolphParkReboot/rpr_common.php";
	
	$doLoop = true;
	logEntry("Randolph Park Reboot Initializing...");
	
	while ($doLoop) {
		$pluginSettings = parse_ini_file($pluginConfigFile);
		$deviceData = getDeviceData();
		$playingData = json_decode(getCurrentPlayingData(),true);
		$combined = json_encode(array_merge(json_decode($deviceData,true),$playingData));
		
		if ($playingData['mode'] == "remote") {
			// remote mode
			$rebootSeq1 = (array_key_exists('rebootSeq1',$pluginSettings) ? trim($pluginSettings['rebootSeq1']) : '');
			$rebootSeq2 = (array_key_exists('rebootSeq2',$pluginSettings) ? trim($pluginSettings['rebootSeq2']) : '');
			
			if (($rebootSeq1 == $playingData['sequenceName'] || $rebootSeq2 != $playingData['playlistName']) && ($combined['secondsElapsed'] < $combined['uptimeTotalSeconds'])) {
				// a sequence is playing where we want to reboot remote FPP devices
				//logEntry("Reboot Sequence Detected: " . $playingData['sequenceName']);
				$result = file_get_contents('http://127.0.0.1/api/system/fppd/restart');
				$sleepDuration = 30;
			} else {
				// song has not changed
				$sleepDuration = 30;
			}
		} else {
			// master/player mode
			$sleepDuration = 180;
		}
		
		sleep($sleepDuration);

	}
	
?>