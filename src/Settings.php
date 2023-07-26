<?php

namespace Lib;

class Settings
{
	private array $settings = [];
	
	public function __construct(array $files)
	{
		$pathConfig = BASE_DIR . 'app/Config/settings/';
		
		foreach ($files as $alias => $file) {
			if (file_exists($pathConfig . $file)) {
				$this->settings[$alias] = require $pathConfig . $file;
			}
		}
	}
	
	public function getAlias(string $alias, $default = [])
	{
		return $this->settings[$alias] ?? $default;
	}
}
