<?php
class Model
{
	/**
	 * Instance of PDO class.
	 */
	private static ?PDO $db = null;

	/**
	 * Method which sets up the database on first use.
	 *
	 * @access private
	 * @return PDO Database connection
	 */
	private static function db(): PDO
	{
		if (self::$db === null) {
			if (!is_dir(ROOT . '/database')) {
				mkdir(ROOT . '/database', 0777, true);
			}

			self::$db = new PDO('sqlite:' . ROOT . '/database/database.sqlite', options: [
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]);
		}

		return self::$db;
	}

	/**
	 * Read database query.
	 *
	 * @access protected
	 * @param string $query SQL query
	 * @return PDOStatement Output result
	 */
	protected static function query(string $query): PDOStatement
	{
		return self::db()->query($query);
	}

	/**
	 * Execute database query with variable.
	 *
	 * @access protected
	 * @param string $query SQL query
	 * @param array $vars Query variables
	 * @return PDOStatement Output result
	 */
	protected static function execute(string $query, array $vars = []): PDOStatement
	{
		$stmt = self::db()->prepare($query);
		$stmt->execute($vars);

		return $stmt;
	}
}
