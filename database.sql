/*SETUP*/

DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS OrderQueue;

/*CREATE*/

CREATE TABLE Restaurant
(
    RestaurantId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Address NVARCHAR(100),
    CONSTRAINT PK_Restaurant PRIMARY KEY (RestaurantId)
);

CREATE TABLE Menu
(
    MenuId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_Menu PRIMARY KEY (MenuId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE Dish
(
    DishId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
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

/*POPULATE*/

INSERT INTO Restaurant (RestaurantId, Name) VALUES (1, "Restaurante 1");
INSERT INTO Restaurant (RestaurantId, Name) VALUES (2, "Restaurante 2");
INSERT INTO Restaurant (RestaurantId, Name) VALUES (3, "Restaurante 3");
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (1, "Menu 1", 1);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (2, "Menu 2", 1);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (3, "Menu 3", 1);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (4, "Menu 4", 2);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (5, "Menu 5", 2);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (6, "Menu 6", 2);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (7, "Menu 7", 3);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (8, "Menu 8", 3);
INSERT INTO Menu (MenuId, Name, RestaurantId) VALUES (9, "Menu 9", 3);
INSERT INTO Dish (DishId, Name, MenuId) VALUES (1, "Prato 1", 1);
INSERT INTO Dish (DishId, Name, MenuId) VALUES (2, "Prato 2", 1);
INSERT INTO Dish (DishId, Name, MenuId) VALUES (3, "Prato 3", 1);
INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Password) VALUES (1, "Cliente", "1", "Email 1", "Password 1");
INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Password) VALUES (2, "Cliente", "2", "Email 2", "Password 2");
INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Password) VALUES (3, "Cliente", "3", "Email 3", "Password 3");
INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId) VALUES (1, 1, 1);
INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId) VALUES (2, 1, 1);
INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId) VALUES (3, 1, 1);