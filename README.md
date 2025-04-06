# Car-Inventory-Management-Web-Application
Car Inventory Management Web Application
=========================================



---

Description:
-------------
This project is a PHP and MySQL web application that allows registered users to manage a car inventory. 
Users can register, log in, list all cars, add new cars, search for cars, and delete cars securely.

---

Setup Instructions:
--------------------
1. Ensure you have a web server with PHP and MySQL installed (e.g., XAMPP, MAMP, WAMP).
2. Place the project folder into your server's root directory (e.g., `htdocs` for XAMPP).
3. Create a MySQL database if needed.
4. Update `dblogin.php` with your correct database name, username, and password if needed.
5. Run `setupDB.php` once to create the database tables and insert initial car records.
6. Start using the application via `register.php` to create a new user account!

---

Folder Structure:
------------------
- php/
  - setupDB.php
  - dblogin.php
  - register.php
  - login.php
  - mainmenu.php
  - list_records.php
  - add_record.php
  - search_records.php
  - delete_record.php
  - logout.php
- css/
  - styles.css
- images/
  - car_banner.jpg
  
- README.txt

---

Important Notes:
-----------------
- Make sure `setupDB.php` is only run once to create tables.
- Passwords are securely stored using PHP's password_hash.
- All database queries use prepared statements to prevent SQL Injection.
- Session control is enabled to prevent unauthorized access.

---

Thank you for reviewing my project!

