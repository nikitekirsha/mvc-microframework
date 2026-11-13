<?php
class AuthController extends Controller
{
	public static function __constructStatic()
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

	public static function register()
	{
		if (self::logged()) {
			return self::redirect('/profile/');
		}

		self::render('auth/register');
	}

	public static function doRegister()
	{
		$name = $_POST['name'] ?? '';
		$password = $_POST['password'] ?? '';
		$repeatPassword = $_POST['repeat-password'] ?? '';
		$bio = $_POST['bio'] ?? '';

		if (empty($name) || empty($password) || empty($repeatPassword) || empty($bio)) {
			return self::redirect('/register/', ['message' => 'You didn\'t fill all fields.']);
		}

		if ($password !== $repeatPassword) {
			return self::redirect('/register/', ['message' => 'Passwords don\'t match.']);
		}

		if (!empty(UserModel::getUserByName($name))) {
			return self::redirect('/register/', ['message' => 'This name is already taken.']);
		}

		UserModel::register($name, password_hash($password, PASSWORD_DEFAULT), $bio);

		return self::redirect('/login/');
	}

	/* == login == */

	public static function login()
	{
		if (self::logged()) {
			return self::redirect('/profile/');
		}

		self::render('auth/login');
	}

	public static function doLogin()
	{
		$name = $_POST['name'] ?? '';
		$password = $_POST['password'] ?? '';

		if (empty($name) || empty($password)) {
			return self::redirect('/login/', ['message' => 'You didn\'t fill all fields.']);
		}

		$user = UserModel::getUserByName($name);

		if (empty($user)) {
			return self::redirect('/login/', ['message' => 'This user doesn\'t exist.']);
		}

		if (!password_verify($password, $user['password'])) {
			return self::redirect('/login/', ['message' => 'Wrong password.']);
		}

		session_regenerate_id(true);
		$_SESSION['user'] = $user['id'];

		return self::redirect('/profile/');
	}

	/* == logout == */

	public static function logout()
	{
		unset($_SESSION['user']);

		return self::redirect('/');
	}
}
