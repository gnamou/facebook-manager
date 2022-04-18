# FACEBOOK-PAGE-MANAGER

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/installation)


Clone the repository

    get clone https://github.com/gnamou/facebook-manager.git

Switch to the repo folder

    cd facebook-manager

Install all the dependencies using composer

    composer install
OR

    composer update

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server(**Set the FACEBOOK_APP_ID, FACEBOOK_APP_SECRET AND FACEBOOK_REDIRECT variables in .env before using the app**)

    http://localhost:8000
