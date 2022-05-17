/*SETUP*/

DROP TABLE IF EXISTS RestaurantOwner;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS OrderQueue;
DROP TABLE IF EXISTS Review;

/*CREATE*/

CREATE TABLE RestaurantOwner
(
    OwnerId INTEGER NOT NULL,
    FirstName NVARCHAR(100) NOT NULL,
    LastName NVARCHAR(100) NOT NULL,
    Address NVARCHAR(100),
    PhoneNumber NVARCHAR(50),
    Email NVARCHAR(50) NOT NULL,
    Password NVARCHAR(50) NOT NULL,
    CONSTRAINT PK_RestaurantOwner PRIMARY KEY (OwnerId)
);

CREATE TABLE Restaurant
(
    RestaurantId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Address NVARCHAR(100) NOT NULL,
    CONSTRAINT PK_Restaurant PRIMARY KEY (RestaurantId)
);

CREATE TABLE Menu
(
    MenuId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Price REAL NOT NULL,
    Category NVARCHAR(100),
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_Menu PRIMARY KEY (MenuId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE Dish
(
    DishId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Price REAL NOT NULL,
    Category NVARCHAR(100),
    MenuId INTEGER NOT NULL,
    CONSTRAINT PK_Dish PRIMARY KEY (DishId),
    FOREIGN KEY (MenuId) REFERENCES Menu (MenuId)
);

CREATE TABLE Customer
(
    CustomerId INTEGER NOT NULL,
    FirstName NVARCHAR(50) NOT NULL,
    LastName NVARCHAR(50) NOT NULL,
    Address NVARCHAR(100),
    City NVARCHAR(100),
    Country NVARCHAR(100),
    PostalCode NVARCHAR(10),
    PhoneNumber NVARCHAR(50),
    Email NVARCHAR(100) NOT NULL,
    Password NVARCHAR(50) NOT NULL,
    CONSTRAINT PK_Customer PRIMARY KEY (CustomerId)
);

CREATE TABLE OrderQueue
(
    OrderId INTEGER NOT NULL,
    CustomerId INTEGER NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_Order PRIMARY KEY (OrderId),
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE Review
(
    ReviewId INTEGER NOT NULL,
    ReviewScore INTEGER NOT NULL,
    ReviewContent NVARCHAR(200) NOT NULL,
    CustomerId INTEGER NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_Review PRIMARY KEY (ReviewId),
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);