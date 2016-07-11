<?php 
	
	/*
		CONFIG SERVICE
			takes: 
				name: the name of the config requested
				print_js_object: should echo config as a js (JSON) object called [$name]Config
			returns:
				a php associatve array of the config
				optionally echos a js object with config. 
					NOTE: assumes configservice() was called from within script tags in the parent
	*/

	function configservice($name, $print_js_object) {
		$basepath = getcwd();
		$rawdefaultconfig = file_get_contents($basepath.'/config/default.json');
		$defaultconfig = json_decode($rawdefaultconfig, true);

		$rawconfig = file_get_contents($basepath."/config/".$name.".json");

		$config = array_merge($defaultconfig, json_decode($rawconfig, true));

		if ($print_js_object) {
			echo "var ".$name."Config = ".json_encode($config) . ";";
		}
		return $config; 
	}
?>