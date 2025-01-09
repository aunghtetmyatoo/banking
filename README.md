# Banking System

A comprehensive banking system built with Laravel and Filament. This project includes features such as user registration, login, OTP verification, transactions (deposit, withdraw, transfer), and more.

## Table of Contents

-   [Features](#features)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Running the Application](#running-the-application)
-   [Contributing](#contributing)
-   [License](#license)

## Features

-   User registration and login
-   OTP verification
-   User profile management
-   Transactions: deposit, withdraw, transfer
-   Dashboard with charts and statistics
-   Role-based access control

## Requirements

-   PHP 8.2 or higher
-   Composer
-   Node.js and npm
-   MySQL or any other supported database

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/aunghtetmyatoo/banking.git
    cd banking
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

## Configuration

1. **Copy the `.env.example` file to `.env`:**

    ```bash
    cp .env.example .env
    ```

2. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

3. **Configure the `.env` file:**

    Update the database and other configuration settings in the `.env` file.

4. **Run the database migrations and seeders:**

    ```bash
    php artisan migrate --seed
    ```

5. **Cache the configuration files:**

    ```bash
    php artisan config:cache
    ```

## Running the Application

1. **Start the local development:**

    ```bash
    php artisan serve
    npm run dev
    ```

2. **Access the application:**

    Open your browser and navigate to `http://localhost:8000/admin` for admin.
    Open your browser and navigate to `http://localhost:8000/user` for user.

## Contributing

Contributions are welcome!

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
