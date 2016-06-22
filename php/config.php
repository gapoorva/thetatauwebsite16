<?php 
	
	function get_config($name, $domain, $print_js_object) {
		$rawconfig = file_get_contents($name);
		if ($print_js_object) {
			echo "var ".$domain."Config = ".$rawconfig;
		}
		return json_decode($rawconfig, true); 
	}
?>