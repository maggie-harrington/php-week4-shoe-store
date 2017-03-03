# Shoe Stores

#### _Epicodus PHP Week 4 Independent Project - MySQL Databases Extended with Many-to-Many Relationships, 3/3/2017_

#### By Maggie Harrington

## Description

An application written in PHP to demonstrate use of MySQL databases with many-to-many relationships and join statements. The application lists local shoe stores and the brands of shoes they sell.

## Setup/Installation Requirements

* Download project at my GitHub repository: https://github.com/php-week4-shoe-stores .
* To clone through GitHub, first make sure that you have PHP, Composer, and MAMP installed.
* See https://secure.php.net/ for details on installing PHP. Note: PHP is typically already installed on Macs.
* See https://getcomposer.org for details on installing Composer.
* See https://mamp.info/ for details on installing MAMP.
* Open the terminal and enter `cd Desktop`. Copy the link above (in the first bullet point), then type `git clone ` and enter the link. You will now have a copy of this project on your desktop.
* In the terminal, type `cd php-week4-shoe-stores/` and hit enter.
* From the terminal, run `composer install --prefer-source --no-interaction`
* Launch MAMP, select _Preferences > Ports_ and make sure _Apache Port_ = 8888 and _MySQL Port_ = 8889.
* Click on the _Web Server_ tab and change the _Document Root_ to the web folder of this project (_Desktop > php-week4-shoe-stores > web_).
* Select _Start Servers_ from the initial MAMP window. If your servers were already running, please restart after making the changes above.
* Open a new terminal window and enter `cd ~`, then start MySQL at the command prompt with `/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot`
* Use PHPMyAdmin `http://localhost:8888/phpmyadmin/` and `shoes.sql.zip` (located in the root level of the project folder) to import the `shoes` database.
* In your web browser, navigate to `localhost:8888`, which will open the index page.

* If you would like to verify my PHPUnit class tests, use PHPMyAdmin to make a copy of the `shoes` database and name it `shoes_test` database.
* To run PHPUnit tests from the project root, enter `vendor/bin/phpunit tests` into the terminal.

## Known Bugs

No known bugs at this time.

## Support and contact details

If you run into any issues or have questions, ideas or concerns, please feel free to contact me at maggie.harrington@gmail.com

## Technologies Used

Written using Git Bash, Atom, PHP, Composer, Silex, Twig, PHPUnit, MySQL, Apache, MAMP, and Bootstrap.

### MIT License

Copyright (c) 2017 Maggie Harrington


## Specifications

0. Create `shoes` production database with `stores` and `brands` tables, as well as a `brands_stores` join table, and make a copy into `shoes_test` for development.

1. Create Store class with construct, create and test getters & setters.

2. Create tests and methods for the following Store functions (full CRUD functionality: Create, Read, Update, Delete):
    * save
    * getAll
    * deleteAll
    * find - singular
    * update
    * delete - singular

3. Write Silex routes for Store methods in app.php after all tests pass.

4. Create Brand class with construct, create and test getters & setters.

5. Create tests and methods for the following Brand functions:
    * save
    * getAll
    * deleteAll
    * find - singular
    * update
    * delete - singular

6. Write Silex routes for Brand methods in app.php after all tests pass.

7. Create index page to list all stores and all brands, including forms to add new stores and new brands.

8. Construct and test methods within Store class to assign a brand to a store (addBrand) and to display all brands assigned to a store (getBrands).

9. Write Silex routes to implement addBrand and getBrands.

10. Create store page to display all brands a particular store carries, including a form to add more brands to a store.

11. Add edit and delete buttons to store page, with a new page for the edit form.

12. Construct and test methods within Brand class to assign a store to a brand (addStore) and to display all stores assigned to a brand (getStores).

13. Write Silex routes to implement addStore and getStores.

14. Create brand page to display all stores that carry a particular brand, including a form to add more stores to a brand.

15. (Optional) Add edit and delete buttons to brand page, with a new page for the edit form.

16. Export `shoes` and `shoes_test` databases to include in project folder.


## MySQL Commands Used

/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot

CREATE DATABASE shoes;

USE shoes;

SELECT DATABASE();

CREATE TABLE stores (id SERIAL PRIMARY KEY, name VARCHAR (255));

CREATE TABLE brands (id SERIAL PRIMARY KEY, name VARCHAR (255));

CREATE TABLE brands_stores (id SERIAL PRIMARY KEY, brand_id BIGINT, store_id BIGINT);

DESCRIBE stores;

| Field | Type                | Null | Key | Default | Extra          |
|-------|---------------------|------|-----|---------|----------------|
| id    | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name  | varchar(255)        | YES  |     | NULL    |                |

DESCRIBE brands;

| Field      | Type                | Null | Key | Default | Extra          |
|------------|---------------------|------|-----|---------|----------------|
| id         | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name       | varchar(255)        | YES  |     | NULL    |                |

DESCRIBE brands_stores;

| Field      | Type                | Null | Key | Default | Extra          |
|------------|---------------------|------|-----|---------|----------------|
| id         | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| brand_id   | bigint(20)          | YES  |     | NULL    |                |
| store_id   | bigint(20)          | YES  |     | NULL    |                |
