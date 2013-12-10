<?php

$paths = array(
	__DIR__ . '/../vendor',
	__DIR__ . '/../../..'
);

foreach ($paths as $path) {
	if (@is_dir($path . '/composer') && @is_file($path . '/autoload.php')) {
		require_once $path . '/autoload.php';
		return;
	}
}
