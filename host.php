<?php

require_once 'conf/common.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

$host = validate_get(GET('h'), 'host');
$plugin = validate_get(GET('p'), 'plugin');

if (!$plugin) {
	$selected_plugins = $CONFIG['overview'];
}
else {
	$selected_plugins = array($plugin);
}

html_start();

printf('<h2>%s</h2>'."\n", $host);

$plugins = collectd_plugins($host);

if(!$plugins) {
	echo "Unknown host\n";
	return false;
}

plugins_list($host, $CONFIG['overview'], $plugins, $selected_plugins);

echo '<div class="graphs">';
foreach ($selected_plugins as $selected_plugin) {
	plugin_header($host, $selected_plugin);
	graphs_from_plugin($host, $selected_plugin);
}
echo '</div>';

html_end();

?>
