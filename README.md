##E-Commerce Management System

This project is a basic E-Commerce Management System built with PHP and MySQL. It allows users to manage customers, orders, products, suppliers, shipping details, and reviews through a simple, functional admin dashboard.

Features
  - Login and Authentication: Simple admin login to access the dashboard.
  - Customer Management: Add, edit, delete, and view customer details.
  - Order Management: Manage customer orders, including order details and related shipping.
  - Product Management: Add products, assign categories, and associate products with suppliers.
  - Supplier Management: Manage suppliers and their linked products.
  - Shipping Management: Track and update shipping details for orders.
  - Review Management: Add and view product reviews.
  
Tech Stack
  - Backend: PHP (No frameworks, plain PHP for simplicity)
  - Database: MySQL (Schema provided)
  - Frontend: Basic HTML, CSS (for styling)
  - Development Environment: XAMPP
  
Installation
Prerequisites
  - XAMPP or any PHP & MySQL environment installed.
  - Git installed for cloning the repository.
  
Steps
  1. Clone the Repository:
    git clone https://github.com/javadqanati/E-commerce-Database-Management
  2. Set Up Database:
    Import the ecommerce_db.sql file into MySQL using phpMyAdmin or the MySQL command line.
    Make sure the DBconnection.php file matches your database credentials.
  3. Start the Server:
   Place the project in the htdocs folder (if using XAMPP).
   Start the Apache and MySQL services in XAMPP.
  4. Access the Application:
    Open your browser and navigate to http://localhost/your-project-folder.

Usage
1. Login:
  Username: root
  Password: 1234
2. Use the links in the admin dashboard to manage customers, orders, products, suppliers, and reviews.

Project Structure
  - DBconnection.php: Database connection file.
  - login.php: Handles admin login.
  - logout.php: Ends the admin session.
  - admin_dashboard.php: Main admin dashboard.
  - customers.php, orders.php, categories.php, suppliers.php, shippings.php: Management modules.
  - add_*.php, update_*.php, delete_*.php: CRUD operations for various entities.
  - style.css: Styling for the project.

Contributing
Contributions are welcome! Please fork the repository and submit a pull request for any improvements or bug fixes.







