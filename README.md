## Starting/Stopping the application

- The only thing needed to run the application is executing the start.sh script found in the root folder. It handles:
    - the startup of the containers
    - running a composer install
    - running the migrations for the database, both for prod and testing.
    - generating swagger documentation
    - Compiling assets
- Stopping the application can be done by executing ./vendor/bin/sail down
- Swagger documentation of the API can be found at http://localhost/api/documentation

## Technical aspects

- Migrations are stored in database/migrations and are run using artisan
- Sail is being used to run the laravel app and the MYSQL
- DDD was used when transcribing business requirements into code and for the modeling of the application.
- ATDD was used when creating the Operations supported by the app.
- VueJS communicates with the backend via api calls and the frontend routes are being handled by vue-router, while login and register are blade templates and rendered by laravel
- Decided to implement the TMDB Api Wrapper myself

## Framework and technologies used

- Laravel ^10.10 for the API
- Pest for writing and running tests
- MYSQL for storing data about companies and stations.
- Swagger for API documentation
- VueJS for frontend

## Libraries used

- For generating swagger annotations, thus documenting the API correctly and accurately: https://github.com/DarkaOnLine/L5-Swagger
