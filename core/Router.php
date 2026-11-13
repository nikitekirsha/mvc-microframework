<?php
class Router
{
	/**
	 * Main route function. Runs the callback and stops the script,
	 * if the request matches. Otherwise, does nothing, so the next route gets its turn.
	 *
	 * @access private
	 * @param string $method HTTP method
	 * @param string $route URL path, may contain params like "/user/{id}/"
	 * @param callable $callback Called with the params if the request matches
	 */
	private static function route(string $method, string $route, callable $callback): void
	{
		if ($_SERVER['REQUEST_METHOD'] !== $method) {
			return;
		}

		// Leading and trailing slashes don't matter: "/user/1/" is the same as "user/1"
		$currentPath = '/' . trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		$route = '/' . trim($route, '/');

		// Turn "/user/{id}" into a pattern, where every param catches one path segment
		$pattern = preg_replace('/{\w+}/', '([^/]+)', $route);

		if (preg_match("#^$pattern$#", $currentPath, $params)) {
			$callback(...array_slice($params, 1));

			exit;
		}
	}

	/**
	 * Route wrapper for "GET" method.
	 *
	 * @param string $route URL path
	 * @param callable $callback Called if the request matches
	 */
	public static function get(string $route, callable $callback): void
	{
		self::route('GET', $route, $callback);
	}

	/**
	 * Route wrapper for "POST" method.
	 *
	 * @param string $route URL path
	 * @param callable $callback Called if the request matches
	 */
	public static function post(string $route, callable $callback): void
	{
		self::route('POST', $route, $callback);
	}
}
