# Craftedby

This is a web application developed in PHP using the Laravel framework. The application is connected to a MySQL database and utilizes the Laravel Breeze and Laravel Sanctum packages for user authentication.

## Main Functionalities

The application features three user roles:

1. **Unauthenticated Client:** Users with this role can make online purchases.

2. **Authenticated Client:** Users with this role can make online purchases, access available products, and manage their profile.

3. **Artisan:** Users with this role have the ability to create pages with different themes and upload their products to the page they have created.

4. **Administrator:** This role has administrative privileges and can manage users, products, pages, and orders.

## Features

- Provides a platform for e-commerce.
- Offers a management system for online stores for artisans.


## Requirements

- PHP >= 8.2.4
- Composer >= 2.7.2
- laravel/breeze >= 2.0
- laravel/framework => 11.0
- laravel/sanctum => 4.0
- laravel/tinker => 2.9
- MySQL

## Installation

1. Clone the GitHub repository: https://github.com/nathasoto/laravel.git

2. Install Composer dependencies: composer install

3. Create a copy of the `.env.example` file and rename it to `.env`. Then, configure the environment variables, especially the database configuration.

4. Generate a new application key: php artisan key:generate

5. Run migrations and seeders to generate the database structure and create sample users:
php artisan serve

## Usage

1. Access the application in your web browser.
2. Register as a new user or log in if you already have an account.
3. Depending on your user role, you will be able to access different functionalities of the application.
4. Explore the available options for making purchases, creating pages, managing products, etc.

## Contribution

If you wish to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Make your changes and commit them, describing your modifications (`git commit -am 'Add new feature'`).
4. Push your changes to your fork (`git push origin feature/new-feature`).
5. Create a pull request in the original repository.

## Issues

If you encounter any problems or have any suggestions, please open an issue in the repository.

## Credits

This project was developed by [Nathalie Soto](https://github.com/nathasoto).

## License

This project is licensed under the [Student](https://opensource.org/licenses/MIT).

## API Documentation

Project documentation 

1. [API Postman](https://documenter.getpostman.com/view/31334199/2sA3Bhdtp3)
2. [API Swagger](http://127.0.0.1:8000/api/documentation)

This documentation provides detailed information on each endpoint, including request parameters, responses, and examples of usage.
