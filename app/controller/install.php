<?php
use TOOL\SQL\SQL;
use TOOL\System\Path;

Path::open(BASESTORAGE)
    ->make('cache');

Path::open(BASESTORAGE)
    ->make('backups');

Path::open(BASESTORAGE)
    ->make('database');

Path::open(BASESTORAGE)
    ->make('uploads');

Path::open(BASESTORAGE)
    ->createFiles(['settings.json']);

SQL::run("CREATE table IF NOT EXISTS `users` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `fullName` VARCHAR(30) Null,
    `type` VARCHAR(15) NULL,
    `username` VARCHAR(20) NULL,
    `password` TEXT NULL,
    `visiblepass` TEXT NULL,
    `rfidCode` TEXT NULL,
    UNIQUE (`username`)
)");


SQL::set("INSERT IGNORE INTO `users` (id, type, username, password,visiblepass) VALUES
(1 , 'admin', 'admin', :pass, 'admin')")->exec([
    'pass' => password_hash('admin', PASSWORD_DEFAULT)
]);

SQL::set("INSERT IGNORE INTO `users` (id, type, username, password,visiblepass) VALUES
(2, 'cashier', 'caissier', :pass,'caissier')")->exec([
    'pass' => password_hash('caissier', PASSWORD_DEFAULT)
]);

SQL::run("CREATE table IF NOT EXISTS `categories` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `name` VARCHAR(50) NOT NULL,
    `image` TEXT NULL,
    UNIQUE (`name`)
)");


SQL::run("CREATE table IF NOT EXISTS `menu` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `category_id` INT(10) UNSIGNED NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `capital` FLOAT NOT NULL,
    `price` FLOAT NOT NULL,
    `quantity` FLOAT NULL,
    `equips_in` VARCHAR(10) NOT NULL,
    `image` TEXT NULL,
    CONSTRAINT `fk_menu_categories` FOREIGN KEY (category_id) REFERENCES categories(id),
    CHECK(`equips_in` IN ('kitchen','bartender')),
    CHECK(`quantity` = NULL OR `quantity` >= 0)
)");


SQL::run("CREATE table IF NOT EXISTS `areas` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `name` VARCHAR(50) NOT NULL
)");


SQL::run("CREATE table IF NOT EXISTS `tables` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `area_id` INT(10) UNSIGNED NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    CONSTRAINT `fk_tables_areas` FOREIGN KEY (area_id) REFERENCES areas(id)
)");


SQL::run("CREATE table IF NOT EXISTS `customers` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `name` VARCHAR(50) NOT NULL,
    `address` VARCHAR(200) NULL,
    `phone` VARCHAR(30) NULL,
    UNIQUE (`name`)
)");


SQL::run("CREATE table IF NOT EXISTS `daily` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `close_at` TIMESTAMP NULL
)");


SQL::run("CREATE table IF NOT EXISTS `orders` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` VARCHAR(30),
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `daily_id` INT(10) UNSIGNED NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `table_id` INT NULL,
    `table_area` VARCHAR(20) NULL,
    `table_name` VARCHAR(20) NULL,
    `no_people` INT NULL,
    `customer_id` INT NULL,
    `customer_name` VARCHAR(50) NULL,
    `customer_address` VARCHAR(200) NULL,
    `customer_phone` VARCHAR(30) NULL,
    `paid` BOOLEAN NOT NULL DEFAULT 0,
    CONSTRAINT `fk_orders_daily` FOREIGN KEY (daily_id) REFERENCES daily(id),
    CHECK(`type` IN ('table','import', 'delivery'))
)");


SQL::run("CREATE table IF NOT EXISTS `sales` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `order_id` INT(10) UNSIGNED NOT NULL,
    `menu_id` INT NOT NULL,
    `equips_in` VARCHAR(10) NOT NULL,
    `category_name` VARCHAR(50) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `price` FLOAT NOT NULL,
    `capital` FLOAT NOT NULL,
    `qnt` FLOAT NOT NULL,
    `note` TEXT NULL,
    CONSTRAINT `fk_sales_orders` FOREIGN KEY (order_id) REFERENCES orders(id),
    CHECK(`qnt` >= 1)
)");


// for expense
SQL::run("CREATE table IF NOT EXISTS `expense_daily` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Custom columns
    `close_at` TIMESTAMP NULL
)");
SQL::run("CREATE table IF NOT EXISTS `expenses` (
    -- Primary columns
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `create_by` INT,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- Custom columns
    `title` VARCHAR(100) NOT NULL,
    `amount` FLOAT NOT NULL,
    `description` VARCHAR(500),
    `daily_id` INT(10) UNSIGNED NOT NULL
)");

SQL::run("ALTER TABLE `expenses`
MODIFY COLUMN `daily_id` INT(10) UNSIGNED NULL");

SQL::run("ALTER TABLE `orders`
MODIFY COLUMN `daily_id` INT(10) UNSIGNED NULL");


SQL::run("ALTER TABLE `orders`
ADD COLUMN IF NOT EXISTS `paid_at` TIMESTAMP NULL");

if (realpath(BASEPUBLIC . '/uploads'))
    Path::open(BASEPUBLIC)->go('uploads')->move(BASEUPLOAD);
