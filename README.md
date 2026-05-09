BlueDrive Online Car Sale

Project Overview
BlueDrive Online Car Sale is a Phase B backend development project for an online used car sale website. It uses PHP, MySQL and PDO to implement seller registration, seller login, session handling, seller page, add-car functionality, dynamic search, and car detail display.

Technology Used
- PHP
- MySQL
- PDO
- HTML
- CSS

Database Setup
1. Create a MySQL database using:
   database/schema.sql

2. Insert sample data using:
   database/dummy_data.sql

Database name:
online_car_sale

How to Run
1. Place the project folder inside the local server directory, for example:
   htdocs/blue-drive-d3/Coursework-A-Delivery-3-BlueDrive-Online-Car-Sale-feature-car-detail-guo

2. Start Apache and MySQL in XAMPP.

3. Import:
   database/schema.sql
   database/dummy_data.sql

4. Open:
   http://localhost/blue-drive-d3/Coursework-A-Delivery-3-BlueDrive-Online-Car-Sale-feature-car-detail-guo/public/index.php

Test Seller Accounts
All sample seller accounts use the same password:
Password: 12345678

Example accounts:
- username: liwei_seller
- username: chen_auto
- username: wang_motors
- username: zhao_premium
You can also login by email.

 Main Pages
- public/index.php
- public/register.php
- public/seller-login.php
- public/seller-page.php
- public/add-car.php
- public/search.php
- public/car-detail.php
- public/developers.php

Main Features
- Seller registration with password hashing
- Seller login using username/email and password
- Session-based seller access control
- Seller dashboard page
- Add car records into MySQL
- Store seller_id as a foreign key in cars table
- Search cars by brand/model and year
- Dynamic car detail page with seller contact information

Team Contributions
- Guo Zhilin: database, search.php, car-detail.php
- Liu Jiasheng: register.php and homepage improvements
- Zhang Chenye: seller-login.php, login_process.php, session and logout, seller-page
- Zhu Tongchen: add-car.php, image upload, seller_id insertion

Notes
This project uses PHP and MySQL without frameworks or external templates.
