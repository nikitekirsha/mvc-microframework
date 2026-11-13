<?php

/**
 * Render view without a controller method.
 *
 * @param string $view Template name
 */
function view(string $view)
{
	include ROOT . "/views/$view.phtml";
}
