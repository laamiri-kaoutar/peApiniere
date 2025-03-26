# API Documentation Setup

Follow these steps to generate API documentation using Swagger in your Laravel project:

## Step 1: Install Swagger Package
Run the following command to install Swagger via Composer:
```sh
composer require darkaonline/l5-swagger
```

## Step 2: Publish Swagger Configuration
Execute the command to publish the Swagger configuration files:
```sh
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

## Step 3: Add Annotations in Controllers
Write Swagger annotations in your controller files to document your API endpoints. Refer to [this example repository](https://github.com/ilyassan/park-it) for guidance.

## Step 4: Create OpenAPI Annotations File
1. Navigate to the repository `iyass/park-it`, then go to `app/openApi/annotations.php` to understand its structure.
2. In your project, create a new folder `openApi` inside the `app` directory.
3. Inside `openApi`, create a file named `annotations.php`.
4. Generate a custom annotations file specific to your project using AI or manual configuration and place it inside `annotations.php`.

## Step 5: Generate API Documentation
Run the following command to generate the API documentation:
```sh
php artisan l5-swagger:generate
```

## Step 6: Access API Documentation
Open your browser and navigate to the following URL to view your API documentation:
```sh
http://127.0.0.1:8000/api/documentation
```

Now your API documentation is set up and accessible!

