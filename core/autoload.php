<?php
define('ROOT', dirname(__DIR__));

// Helpers are plain functions, so they're just included all at once
foreach (glob(ROOT . '/core/helpers/*.php') as $helper) {
	require_once $helper;
}

// Classes included on first use, ones with "__constructStatic" method are called after that
spl_autoload_register(function (string $class): void {
	foreach (['core', 'controllers', 'models'] as $folder) {
		$file = ROOT . "/$folder/$class.php";

		if (is_file($file)) {
			require_once $file;

			if (method_exists($class, '__constructStatic')) {
				$class::__constructStatic();
			}

			return;
		}
	}
});
