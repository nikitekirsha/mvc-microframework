<?php
class AuthController extends Controller
{
	public static function __constructStatic(): void
	{
		session_start();
	}

	/* == utils == */

	public static function logged(): bool
	{
		return !empty(self::getUser());
	}

	public static function getUser(): array
	{
		if (empty($_SESSION['user'])) {
			return [];
		}

		// Session keeps the id only, so the data is always fresh
		return UserModel::getUser($_SESSION['user']) ?: [];
	}

	/* == register == */

	public static function register(): void
	{
		if (self::logged()) {
			self::redirect('/profile/');
		}

		self::render('auth/register');
	}

	public static function doRegister(): void
	{
		$name = $_POST['name'] ?? '';
		$password = $_POST['password'] ?? '';
		$repeatPassword = $_POST['repeat-password'] ?? '';
		$bio = $_POST['bio'] ?? '';

		if (empty($name) || empty($password) || empty($repeatPassword) || empty($bio)) {
			self::redirect('/register/', ['message' => 'You didn\'t fill all fields.']);
		}

		if ($password !== $repeatPassword) {
			self::redirect('/register/', ['message' => 'Passwords don\'t match.']);
		}

		if (!empty(UserModel::getUserByName($name))) {
			self::redirect('/register/', ['message' => 'This name is already taken.']);
		}

		UserModel::register($name, password_hash($password, PASSWORD_DEFAULT), $bio);

		self::redirect('/login/');
	}

	/* == login == */

	public static function login(): void
	{
		if (self::logged()) {
			self::redirect('/profile/');
		}

		self::render('auth/login');
	}

	public static function doLogin(): void
	{
		$name = $_POST['name'] ?? '';
		$password = $_POST['password'] ?? '';

		if (empty($name) || empty($password)) {
			self::redirect('/login/', ['message' => 'You didn\'t fill all fields.']);
		}

		$user = UserModel::getUserByName($name);

		if (empty($user)) {
			self::redirect('/login/', ['message' => 'This user doesn\'t exist.']);
		}

		if (!password_verify($password, $user['password'])) {
			self::redirect('/login/', ['message' => 'Wrong password.']);
		}

		session_regenerate_id(true);
		$_SESSION['user'] = $user['id'];

		self::redirect('/profile/');
	}

	/* == logout == */

	public static function logout(): void
	{
		unset($_SESSION['user']);

		self::redirect('/');
	}
}
