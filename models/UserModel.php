<?php
class UserModel extends Model
{
	public static function __constructStatic(): void
	{
		self::execute('create table if not exists users (id integer primary key, name varchar(40) not null unique, password varchar(255) not null, bio varchar(200) not null)');
	}

	public static function getUsers()
	{
		return self::execute('select id, name, bio from users')->fetchAll();
	}

	public static function getUser(string $id)
	{
		return self::execute('select * from users where id = :id', ['id' => $id])->fetch();
	}

	public static function getUserByName(string $name)
	{
		return self::execute('select * from users where name = :name', ['name' => $name])->fetch();
	}

	public static function register(string $name, string $passwordHash, string $bio)
	{
		self::execute('insert into users (name, password, bio) values (:name, :password, :bio)', ['name' => $name, 'password' => $passwordHash, 'bio' => $bio]);
	}
}
