<?php
class UserModel extends Model
{
	public static function __constructStatic(): void
	{
		self::execute('create table if not exists users (id integer primary key, name varchar(40) not null, password varchar(40) not null, bio varchar(200) not null)');
	}

	public static function getUsers()
	{
		return self::execute('select * from users')->fetchAll();
	}

	public static function getUser(string $id)
	{
		return self::execute('select * from users where id = :id', ['id' => $id])->fetch();
	}

	public static function getUserByName($name)
	{
		return self::execute('select * from users where name = :name', ['name' => $name])->fetch();
	}

	public static function register($name, $password, $bio)
	{
		return self::execute('insert into users (name, password, bio) values (:name, :password, :bio)', ['name' => $name, 'password' => $password, 'bio' => $bio]);
	}
}
