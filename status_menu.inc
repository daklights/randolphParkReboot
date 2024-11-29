<?php

$pages = Array(
	'name' => "Randolph Park Reboot",
	'type' => "status",
	'page' => "rpr.php",
	);

?>

<li><a href="<?php echo preg_replace('/.*\/plugins\/(.*)/', 'plugin.php?plugin=$1&page=rpr.php', dirname(__FILE__)); ?>">Randolph Park Reboot</a></li>
