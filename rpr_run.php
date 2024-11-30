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
			$rebootSequences = (array_key_exists('rebootSequences',$pluginSettings) ? trim($pluginSettings['rebootSequences']) : '');

			if ((stripos(trim($rebootSequences),trim($playingData['sequenceName'])) !== false) && ($combined['secondsElapsed'] < $combined['uptimeTotalSeconds'])) {
				// a sequence is playing where we want to reboot remote FPP devices
				logEntry("Reboot Sequence Detected: " . $playingData['sequenceName'] . " | " . $combined['secondsElapsed'] . " | " . $combined['uptimeTotalSeconds']);
				$result = file_get_contents('http://127.0.0.1/api/system/fppd/restart');
				logEntry("RESULT: " . $result);
				$sleepDuration = 30;
			} else {
				// a sequence is playing where we do not want to reboot remote FPP devices
				logEntry("Do Nothing: " . $playingData['sequenceName'] . " | " . $combined['secondsElapsed'] . " | " . $combined['uptimeTotalSeconds']);
				$sleepDuration = 30;
			}
		} else {
			// master/player mode
			$sleepDuration = 180;
		}
		
		sleep($sleepDuration);

	}

?>