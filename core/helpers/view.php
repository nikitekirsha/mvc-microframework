<?php

/**
 * Render a template from "views" folder inside "views/layout.phtml".
 *
 * @param string $view Template name
 * @param array $vars Variables, which should be included into the template
 */
function view(string $view, array $vars = []): void
{
	extract($vars, EXTR_SKIP);

	ob_start();
	include ROOT . "/views/$view.phtml";
	$content = ob_get_clean();

	include ROOT . '/views/layout.phtml';
}
