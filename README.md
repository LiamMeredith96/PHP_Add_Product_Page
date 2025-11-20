# PHP Product Management Page

This project is a simple product management application built with PHP and MySQL.  
It allows you to:

- View a combined list of products (DVD, Furniture, Book)
- Add new products with type-specific attributes
- Perform a mass delete of selected products
- Validate SKU uniqueness on the client side and server side

It was originally built as part of an application task and later cleaned up and documented.

---

## Features

### Product types

The app supports three product types, each with specific attributes:

- **DVD**
  - SKU, Name, Price
  - Size (MB)

- **Furniture**
  - SKU, Name, Price
  - Height (CM), Width (CM), Length (CM)

- **Book**
  - SKU, Name, Price
  - Weight (KG)

All products share a common base (SKU, name, price), and type-specific attributes are stored in separate tables.

### Add Product

Page: `add_product.php`

- Basic fields: SKU, Name, Price
- Product Type dropdown: DVD / Furniture / Book
- When a type is selected, only the relevant fields are shown:
  - DVD → Size (MB)
  - Furniture → Height, Width, Length (CM)
  - Book → Weight (KG)
- On submit:
  - JavaScript validates required fields based on type.
  - An AJAX request (`check_product_id.php`) checks if the SKU already exists in any table.
  - If everything is valid, the form is posted to `save_product.php`, which inserts into the correct table.

### Product List

Page: `index.php`

- Shows a unified list of all products from:
  - `dvd`
  - `furniture`
  - `book`
- Uses a `UNION ALL` query to normalise product info into a single list.
- Displays:
  - SKU
  - Name
  - Price
  - A combined attribute column (e.g. `700MB`, `Dimension: 80x60x40`, `1.2KG`)
- Each product row has a checkbox for selection.
- Buttons:
  - **ADD** → goes to `add_product.php`
  - **MASS DELETE** → posts selected products to `delete_products.php`

### Mass Delete

Page: `delete_products.php`

- Accepts an array of SKUs from the form (`product[]`).
- For each SKU, deletes matching entries from:
  - `dvd`
  - `furniture`
  - `book`
- Uses prepared statements to avoid SQL injection.
- Redirects back to `index.php` after deletion.

---

## Project Structure

```text
project/
├─ add_product.php        # Add new product form (HTML + jQuery)
├─ check_product_id.php   # AJAX endpoint to check SKU uniqueness
├─ delete_products.php    # Handles mass delete of selected products
├─ index.php              # Product list and mass delete form
├─ save_product.php       # Inserts new product into the correct table
├─ config.php             # Local DB configuration (NOT committed)
├─ config.example.php     # Example config for others to copy
├─ scandiweb_project2.sql # Database schema (book, dvd, furniture)
└─ css/
   └─ style.css           # Styling for layout and forms

## Setup and Running Locally

### 1. Requirements

- PHP (e.g. via XAMPP, WAMP, MAMP, or a local PHP installation)
- MySQL / MariaDB
- A web server that can serve PHP (Apache via XAMPP is fine)

### 2. Import the database

1. Create a database (e.g. `scandiweb_project2`).
2. Import `scandiweb_project2.sql` using phpMyAdmin or the MySQL CLI.

### 3. Configure the connection

Copy `config.example.php` to `config.php`

Edit config.php and set:

$dbHost = "localhost";
$dbUser = "your_db_user";
$dbPass = "your_db_password";
$dbName = "scandiweb_project2";