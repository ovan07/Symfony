# Symfony Product CRUD

A simple CRUD application built with Symfony for managing products.

## Features

- List all products
- Create new products
- View product details
- Edit existing products
- Delete products with confirmation

## Tech Stack

- PHP 8+
- Symfony 7
- Doctrine ORM
- Twig templates
- MySQL (via XAMPP)

## Entity: Product

| Field       | Type         |
|-------------|--------------|
| id          | int (auto)   |
| name        | string (255) |
| description | text         |
| price       | decimal(10,2)|
| stock       | int          |

## Routes

| Route            | Method   | Path                  | Description       |
|------------------|----------|-----------------------|-------------------|
| product_index    | GET      | /product              | List all products |
| product_new      | GET/POST | /product/new          | Create product    |
| product_show     | GET      | /product/{id}         | View product      |
| product_edit     | GET/POST | /product/{id}/edit    | Edit product      |
| product_delete   | POST     | /product/{id}/delete  | Delete product    |

## Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure the database in `.env.local`:
   ```
   DATABASE_URL="mysql://root:@127.0.0.1:3306/your_database"
   ```
4. Run migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
5. Access the application at `http://localhost/Symfony/public/product`
