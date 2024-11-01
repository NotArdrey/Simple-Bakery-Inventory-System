# Simple Bakery Inventory System

Welcome to the **Simple Bakery Inventory System** repository! This project is designed to manage the inventory of bakery products from an admin perspective, ensuring that products are served in a FIFO (First In, First Out) order. This system allows administrators to perform basic CRUD (Create, Read, Update, Delete) operations on the product inventory.

## Features

- **Product Management**: Admins can add new bakery products, update existing product information, and delete products from the inventory.
- **FIFO Management**: The system ensures that the oldest products are served first, helping to maintain product freshness and reduce waste.
- **User Authentication**: Admins can securely log in to manage the inventory.

## Technologies Used
 
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Getting Started

To set up the Simple Bakery Inventory System on your local machine, follow these steps:

1. **Clone the Repository**:
   - Use the following command to clone the repository:
     ```bash
     git clone https://github.com/yourusername/simple-bakery-inventory-system.git
     ```

2. **Import the Database**:
   - Open your MySQL management tool (like phpMyAdmin) and import the `database.sql` file included in the repository to set up the necessary database structure.

3. **Configure Database Settings**:
   - Update the database connection settings in the relevant PHP files to match your local setup.

4. **Run the Server**:
   - Use XAMPP or any other local server environment to host the PHP application.

5. **Access the Application**:
   - Open your web browser and navigate to `http://localhost/SimpleBakeryInventorySystem/admin.php` to access the admin panel.

## Usage

- Admins can log in to the admin dashboard to manage bakery products.
- The system will automatically handle the FIFO process, ensuring that the oldest products are prioritized for serving.

## Contribution

Feel free to fork the repository and submit pull requests for any enhancements or bug fixes.
