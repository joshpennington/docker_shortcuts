<?php

$containerJson = file_get_contents('containers.json');
$containers = json_decode($containerJson, true);
$powerShellPwd = '{PWD}';
$winCmdPwd = '%cd%';
$nixPwd = '$(pwd)';

foreach($containers['containersToBuild'] as $containerData) {
	foreach($containerData['versions'] as $version) {
		$fileVersion = $version == 'latest' ? '' : str_replace(".", "", $version);
		$ports = "";
		
		if(isset($containerData['ports'])) {
			foreach($containerData['ports'] as $port) {
				$ports .= '-p ' . $port . ' ';
			}
		}
		
		$arch = '';
		if(isset($containerData['platform'])) {
			$arch = ' --platform ' . $containerData['platform'];
		}
		
		foreach($containers['platforms'] as $platform) {
			
			$command = "docker run{$arch} -it --rm -v ##PWD##:/local ##PORTS##{$containerData['organization']}:$version {$containerData['command']}";
			$command = str_replace('##PWD##', $platform['pwd'], $command);
			$outPath = $platform['outputDirectory'] . "d{$containerData['group']}{$fileVersion}" . $platform['fileExtension']; 
				
			$command = str_replace('##PORTS##', $ports, $command);
			$command = $platform['outputFilePrefix'] . $command;
			
			echo $command . "\n";
			
			// file_put_contents($outPath, $command);
		}
	}
}