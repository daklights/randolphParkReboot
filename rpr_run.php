<?php

	include_once "/home/fpp/media/plugins/randolphParkReboot/rpr_common.php";

	$doLoop = true;

	while ($doLoop) {
		$pluginSettings = parse_ini_file($pluginConfigFile);
		$deviceData = getDeviceData();
		$playingData = json_decode(getCurrentPlayingData(),true);

		if ($playingData['mode'] == "remote") {
			// remote mode
			$rebootSequences = (array_key_exists('rebootSequences',$pluginSettings) ? trim($pluginSettings['rebootSequences']) : '');

			if ((stripos(trim($rebootSequences),trim($playingData['sequenceName'])) !== false) && ($playingData['secondsElapsed'] < $playingData['uptimeTotalSeconds'])) {
				// a sequence is playing where we want to reboot remote FPP devices
				$result = file_get_contents('http://127.0.0.1/api/system/fppd/restart');
				$sleepDuration = 30;
			} else {
				// a sequence is playing where we do not want to reboot remote FPP devices
				$sleepDuration = 30;
			}
		} else {
			// master/player mode
			$sleepDuration = 180;
		}
		
		sleep($sleepDuration);

	}

?>