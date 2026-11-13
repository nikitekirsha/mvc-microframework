<?php
require_once __DIR__ . '/core/autoload.php';

/* == auth == */

Router::get('/register/', function () {
	AuthController::register();
});

Router::post('/register/', function () {
	AuthController::doRegister();
});

Router::get('/login/', function () {
	AuthController::login();
});

Router::post('/login/', function () {
	AuthController::doLogin();
});

Router::get('/logout/', function () {
	AuthController::logout();
});

/* == user == */

Router::get('/', function () {
	UserController::home();
});

Router::get('/user/{id}/', function ($id) {
	UserController::userDetails($id);
});

Router::get('/profile/', function () {
	UserController::profile();
});

/* == common == */

Router::get('/about/', function () {
	view('about');
});

/* == not found == */

// A matched route stops the script, so we get here only if nothing matched
http_response_code(404);
view('404');
