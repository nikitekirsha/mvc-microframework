<?php
require_once __DIR__ . '/core/autoload.php';

/* == auth == */

Router::get('/register/', AuthController::register(...));
Router::post('/register/', AuthController::doRegister(...));

Router::get('/login/', AuthController::login(...));
Router::post('/login/', AuthController::doLogin(...));

Router::get('/logout/', AuthController::logout(...));

/* == user == */

Router::get('/', UserController::home(...));
Router::get('/user/{id}/', UserController::userDetails(...));
Router::get('/profile/', UserController::profile(...));

/* == common == */

Router::get('/about/', fn () => view('about'));

/* == not found == */

// A matched route stops the script, so we get here only if nothing matched
http_response_code(404);
view('404');
