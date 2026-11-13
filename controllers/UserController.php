<?php
class UserController extends Controller
{
	public static function home(): void
	{
		$logged = AuthController::logged();
		$users = UserModel::getUsers();

		self::render('home', ['logged' => $logged, 'users' => $users]);
	}

	public static function userDetails(string $id): void
	{
		$user = UserModel::getUser($id);

		if (empty($user)) {
			self::redirect('/');
		}

		self::render('userDetails', ['user' => $user]);
	}

	public static function profile(): void
	{
		$user = AuthController::getUser();

		if (empty($user)) {
			self::redirect('/');
		}

		self::render('profile', ['user' => $user]);
	}
}
