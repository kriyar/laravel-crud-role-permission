# Laravel 5.8 with CRUD operation to manage role, permission, and user role.

This project provide interface to manage role, permission, and user role. This project based on [Spatie Role Permission](https://github.com/spatie/laravel-permission).

## Features

- Role management
- Permission management
- User role management

## Usage

- Clone the project and install required packages using command `composer install`
- Copy `.env.example` to `.env`, then setup your database configuration at `.env` file
- Run command `php artisan key:generate` to generate new APP_KEY
- Run command `php artisan migrate` to generate database tables
- Run command `php artisan db:seed` to generate pre-define roles, permissions, and Super Admin user.
- Run command `php artisan route:list` to see available routes

## Main routes

- `/admin/roles` - List of all roles including CRUD links in the list
- `/admin/permissions` - List of all permissions including CRUD links in the list
- `/admin/role-permission` - Page to manage assign/remove role permssion
- `/user/list` - List of all users including the link to manage user role


## Credits

- The role and permission is based on package [Spatie Role Permisison](https://github.com/spatie/laravel-permission).
- The front-end of this project is based on [Bootstrap](https://getbootstrap.com).
- HTML Generator with [LaravelCollective/html](https://github.com/LaravelCollective/docs/blob/5.6/html.md).

## License

The project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
