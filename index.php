<?php
require_once('inc/config.php'); //load the configuration class
//initialize a new instance of configuration, defaults to looking for a file
// "settings.config"
$config = new Configuration();
?>
<html>
<head>
	<title>Adboom coding sample</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	We can have the class return the settings as an associative array, which we can loop over
	<table>
		<thead>
			<tr>
				<th>Setting Name</th>
				<th>Value</th>
				<th>Data Type</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$settings = $config->get_all_settings();
			var_dump( $settings );
			foreach( $settings as $key => $value ){
				echo '<tr>';
				echo '<td>' . $key . '</td>';
				echo '<td>' . (( $value === TRUE ) ? "TRUE" : (( $value === FALSE) ? "FALSE" : $value)) . '</td>';
				echo '<td>' . gettype( $value ) . '</td>';
				echo '</tr>';	
			}
			?>
		</tbody>
	</table>
	
	<p>We are also able to access any setting individually
	by using the syntax $config->setting_name
	</p>
	<?php 
		echo '$config->server_id = ' . $config->server_id . '<br/>';
		echo '$config->host = ' . $config->host . '<br/>';
		echo '$config->debug_mode = ' . ( $config->debug_mode?"TRUE":"FALSE" ) . '<br/>';
		echo '$config->verbose = ' . ( $config->verbose?"TRUE":"FALSE" ) . '<br/>';
		//variables not in the config file return null, and throw a warning
		echo '$config->fizgig = ' . ( is_null( $config->fizgig )?"null":$config->fizgig ) . '<br/>';
	?>
	
	<p>We can spefify an alternate configuration file if we would like
	$config2 = new Configuration('configs/settings2.config');</p>
	<?php 
		echo '$config->server_id = ' . $config2->server_id . '<br/>';
		echo '$config->host = ' . $config2->host . '<br/>';
		echo '$config->debug_mode = ' . ( $config2->debug_mode?"TRUE":"FALSE" ) . '<br/>';
		echo '$config->verbose = ' . ( $config2->verbose?"TRUE":"FALSE" ) . '<br/>';
		//variables not in the config file return null, and throw a warning
		echo '$config->fizgig = ' . ( is_null( $config2->fizgig )?"null":$config2->fizgig ) . '<br/>';
	?>
	
	
</body>
</html>