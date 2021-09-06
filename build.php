<?php

$containerJson = file_get_contents('containers.json');
$containers = json_decode($containerJson, true);

foreach($containers['platforms'] as $platform) {
	if(!file_exists($platform['outputDirectory'])) {
		mkdir($platform['outputDirectory'], 0777, true);
	}
}

foreach($containers['customCommands'] as $customCommand) {
	foreach($containers['platforms'] as $platform) {
		$command = $platform['outputFilePrefix'] . $customCommand['command'];
		$outPath = $platform['outputDirectory'] . $customCommand['name'] . $platform['fileExtension']; 
		file_put_contents($outPath, $command);
	}
}

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
		
		$network = '';
		if(isset($containerData['network'])) {
			$network = " --network={$containerData['network']}";
		}
		
		$volume = '-v ##PWD##:/local ';
		if($containers['buildOptions']['addScripts']) {
			if(isset($containerData['volume']) && is_array($containerData['volume'])) {
				foreach($containerData['volume'] as $volumeEntry) {
					$volume .= str_replace('##SCRIPTSLOCATION##', $containers['buildOptions']['scriptsLocation'], '-v ' . $volumeEntry);
				}
			}
		}

		$name = "";
		if(isset($containerData['name'])) {
			$name = " --name " . $containerData['name'] . ' ';
		}

		foreach($containers['platforms'] as $platform) {
			
			$command = "docker run{$arch} -it $name--rm$network -w /local $volume ##PORTS##{$containerData['organization']}:$version {$containerData['command']}";
			$command = str_replace('##PWD##', $platform['pwd'], $command);
			$outPath = $platform['outputDirectory'] . "d{$containerData['group']}{$fileVersion}" . $platform['fileExtension']; 
				
			$command = str_replace('##PORTS##', $ports, $command);
			$command = $platform['outputFilePrefix'] . $command;
			
			file_put_contents($outPath, $command);
		}
	}
}