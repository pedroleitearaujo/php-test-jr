# Live eCommerce - Library Management System
API for library management, it can add users, books and make loans, using clean architecture and DDD (Domain Drive Design), and also has the use of unit tests.

# Developed in 
* PHP 8.3.13
* COMPOSER 2.8.2

# Configuration
1. Install Depedencies
    ```bash
    composer install

2. Run Tests
    ```bash
    vendor/bin/phpunit tests

3. Start Application
    ```bash
    php -S localhost:8000 

# Routes
1. Books
    * POST/books
    * get/books/@id
    * get/books
    * delete/books/@id

2. BooksUsers
    * POST/users
    * get/users/@id
    * get/users
    * delete/users/@id

3. Loans
    * POST/loans
    * get/loans/@id
    * get/loans
    * delete/loans/@id
    * put/loans/@id

## Basic Usage
To use the routes, enter the url of the api, and the desired route example:
POST
```bash
http://localhost:8000/books
```
json:
```bash
{
    "title": "Clean Code",
    "author": "Robert C. Martin",
    "isbn": "9780132350884"
}
```
response:
```bash
{
    "message": "Book added successfully"
}
```