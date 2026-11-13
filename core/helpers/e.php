<?php

/**
 * Escape a value before printing it into a template.
 * Use it for everything that comes from users or the database.
 *
 * @param mixed $value Value to print
 * @return string Safe HTML
 */
function e(mixed $value): string
{
	return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
