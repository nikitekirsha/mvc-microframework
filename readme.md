## About

Only basic PHP. It can be useful if you're a beginner and somehow not allowed to use composer and frameworks

## Instead of docs

Please notice:

-   All your controllers and models classes must be classes with static methods
-   Classes from `core`, `controllers` and `models` folders are included automatically on first use, so you don't need `require_once`. The file name must match the class name
-   If a class has a `__constructStatic` method, it's called once, right after the class is included
-   Routes live in `index.php` and are checked from top to bottom. The first matched one stops the script, and if nothing matched, the 404 page at the bottom of the file is shown
-   A route callback is anything callable: `UserController::home(...)` or a function. Params like `{id}` are passed as arguments
-   All templates must have `.phtml` file extension and are rendered inside `views/layout.phtml`. A template can set the page title with `<?php $title = '...' ?>`
-   Print everything through `e()` in templates: `<?= e($user['name']) ?>`. It protects you from XSS
-   Every file in `core/helpers` is included automatically, so it's the place for your own functions
-   This "framework" relies on sqlite and the file's being created automatically at `./database/database.sqlite`
-   Your database structure sets up automatically too: just add a `__constructStatic` method with the `create table if not exists ... (...)` statement to your models

## Setup project

In order to set up your project, you should:

-   Have PHP 8.1 or newer
-   Run `php -S localhost:8000 index.php` in the project folder
-   Or put it into Apache with `mod_rewrite` enabled
-   That's all :)

If you use another web server, send all requests to `index.php` and forbid direct access to all the other files, especially the `database` folder

## Why's this code so awful?

I'm actually a frontend dev 🥺👉👈
