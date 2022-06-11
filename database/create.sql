/*SETUP*/

DROP TABLE IF EXISTS RestaurantOwner;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS OrderQueue;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS CategoryRestaurant;
DROP TABLE IF EXISTS CategoryMenu;
DROP TABLE IF EXISTS CategoryDish;
DROP TABLE IF EXISTS FavoriteCustomerRestaurant;
DROP TABLE IF EXISTS FavoriteCustomerDish;
DROP TABLE IF EXISTS MenuDish;

DROP TRIGGER IF EXISTS sameRestaurantMenuDish;
DROP TRIGGER IF EXISTS onRestaurantCreate;
DROP TRIGGER IF EXISTS onRestaurantUpdate;
DROP TRIGGER IF EXISTS onRestaurantDelete;
DROP TRIGGER IF EXISTS onMenuCreate;
DROP TRIGGER IF EXISTS onMenuUpdate;
DROP TRIGGER IF EXISTS onMenuDelete;
DROP TRIGGER IF EXISTS onDishCreate;
DROP TRIGGER IF EXISTS onDishUpdate;
DROP TRIGGER IF EXISTS onDishDelete;
/*CREATE*/

CREATE TABLE RestaurantOwner
(
    OwnerId INTEGER NOT NULL,
    FirstName NVARCHAR(100) NOT NULL,
    LastName NVARCHAR(100) NOT NULL,
    Address NVARCHAR(100),
    City NVARCHAR(100),
    Country NVARCHAR(100),
    PostalCode NVARCHAR(10),
    PhoneNumber NVARCHAR(50),
    Email NVARCHAR(50) NOT NULL,
    Password NVARCHAR(50) NOT NULL,
    CONSTRAINT PK_RestaurantOwner PRIMARY KEY (OwnerId)
);

CREATE TABLE Restaurant
(
    RestaurantId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Address NVARCHAR(100),
    OwnerId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    FOREIGN KEY (OwnerId) REFERENCES RestaurantOwner (OwnerId),
    FOREIGN KEY (CategoryId) REFERENCES Category (CategoryId),
    CONSTRAINT PK_Restaurant PRIMARY KEY (RestaurantId)
);

CREATE TABLE Menu
(
    MenuId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Price REAL NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    CONSTRAINT PK_Menu PRIMARY KEY (MenuId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE Dish
(
    DishId INTEGER NOT NULL,
    Name NVARCHAR(100) NOT NULL,
    Price REAL NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    CONSTRAINT PK_Dish PRIMARY KEY (DishId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE Customer
(
    CustomerId INTEGER NOT NULL,
    FirstName NVARCHAR(50) NOT NULL,
    LastName NVARCHAR(50) NOT NULL,
    Address NVARCHAR(100) NOT NULL,
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
    Status NVARCHAR(50) NOT NULL DEFAULT "Received",
    CONSTRAINT PK_Order PRIMARY KEY (OrderId),
    CONSTRAINT OrderStatus CHECK(Status = "Received" or Status = "Preparing" or Status = "Ready" or Status = "Delivered"),
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

CREATE TABLE FavoriteCustomerRestaurant
(
    FavoriteCustomerRestaurantId INTEGER NOT NULL,
    CustomerId INTEGER NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_FavoriteRes PRIMARY KEY (FavoriteCustomerRestaurantId),
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE FavoriteCustomerDish
(
    FavoriteCustomerDishId INTEGER NOT NULL,
    CustomerId INTEGER NOT NULL,
    DishId INTEGER NOT NULL,
    CONSTRAINT PK_FavoriteDish PRIMARY KEY (FavoriteCustomerDishId),
    FOREIGN KEY (CustomerId) REFERENCES Customer (CustomerId),
    FOREIGN KEY (DishId) REFERENCES Dish (DishId)
);

CREATE TABLE MenuDish
(
    MenuDishId INTEGER NOT NULL,
    MenuId INTEGER NOT NULL,
    DishId INTEGER NOT NULL,
    CONSTRAINT PK_MenuDish PRIMARY KEY (MenuDishId),
    FOREIGN KEY (MenuId) REFERENCES Customer (MenuId),
    FOREIGN KEY (DishId) REFERENCES Dish (DishId)
);

CREATE TABLE Category
(
    CategoryId INTEGER NOT NULL,
    Name NVARCHAR(100),
    CONSTRAINT PK_Category PRIMARY KEY (CategoryId)
);

CREATE TABLE CategoryRestaurant
(
    CategoryRestaurantId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    RestaurantId INTEGER NOT NULL,
    CONSTRAINT PK_CategoryRestaurant PRIMARY KEY (CategoryRestaurantId),
    FOREIGN KEY (CategoryId) REFERENCES Category (CategoryId),
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
);

CREATE TABLE CategoryMenu
(
    CategoryMenuId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    MenuId INTEGER NOT NULL,
    CONSTRAINT PK_CategoryMenu PRIMARY KEY (CategoryMenuId),
    FOREIGN KEY (CategoryId) REFERENCES Category (CategoryId),
    FOREIGN KEY (MenuId) REFERENCES Menu (MenuId)
);

CREATE TABLE CategoryDish
(
    CategoryDishId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    DishId INTEGER NOT NULL,
    CONSTRAINT PK_CategoryDish PRIMARY KEY (CategoryDishId),
    FOREIGN KEY (CategoryId) REFERENCES Category (CategoryId),
    FOREIGN KEY (DishId) REFERENCES Dish (DishId)
);

CREATE TRIGGER sameRestaurantMenuDish
    AFTER INSERT ON MenuDish FOR EACH ROW
    WHEN 
    (SELECT RestaurantId FROM Menu WHERE new.MenuId = Menu.MenuId) != (SELECT RestaurantId FROM Dish WHERE new.DishId = Dish.DishId)
    BEGIN
	DELETE FROM MenuDish WHERE new.MenuDishId = MenuDish.MenuDishId;
    END;

CREATE TRIGGER onRestaurantCreate
    AFTER INSERT ON Restaurant
    BEGIN
    INSERT INTO CategoryRestaurant ('CategoryId', 'RestaurantId') VALUES (new.CategoryId, new.RestaurantId);
    END;

CREATE TRIGGER onRestaurantUpdate
    AFTER UPDATE ON Restaurant
    BEGIN
    UPDATE CategoryRestaurant SET CategoryId = new.CategoryId WHERE CategoryRestaurant.RestaurantId = new.RestaurantId;
    END;

CREATE TRIGGER onRestaurantDelete
    AFTER DELETE ON Restaurant FOR EACH ROW
    BEGIN
    DELETE FROM OrderQueue WHERE old.RestaurantId = OrderQueue.RestaurantId;
    DELETE FROM Review WHERE old.RestaurantId = Review.RestaurantId;
    DELETE FROM CategoryRestaurant WHERE old.RestaurantId = CategoryRestaurant.RestaurantId;
    DELETE FROM Menu WHERE old.RestaurantId = Menu.RestaurantId;
    DELETE FROM Dish WHERE old.RestaurantId = Dish.RestaurantId;
    END;

CREATE TRIGGER onMenuCreate
    AFTER INSERT ON Menu
    BEGIN
    INSERT INTO CategoryMenu ('CategoryId', 'MenuId') VALUES (new.CategoryId, new.MenuId);
    END;

CREATE TRIGGER onMenuUpdate
    AFTER UPDATE ON Menu
    BEGIN
    UPDATE CategoryMenu SET CategoryId = new.CategoryId WHERE CategoryMenu.MenuId = new.MenuId;
    END;

CREATE TRIGGER onMenuDelete
    AFTER DELETE ON Menu FOR EACH ROW
    BEGIN
    DELETE FROM MenuDish WHERE old.MenuId = MenuDish.MenuId;
    DELETE FROM CategoryMenu WHERE old.MenuId = CategoryMenu.MenuId;
    END;

CREATE TRIGGER onDishCreate
    AFTER INSERT ON Dish
    BEGIN
    INSERT INTO CategoryDish ('CategoryId', 'DishId') VALUES (new.CategoryId, new.DishId);
    END;

CREATE TRIGGER onDishUpdate
    AFTER UPDATE ON Dish
    BEGIN
    UPDATE CategoryDish SET CategoryId = new.CategoryId WHERE CategoryDish.DishId = new.DishId;
    END;

CREATE TRIGGER onDishDelete
    AFTER DELETE ON Dish FOR EACH ROW
    BEGIN
    DELETE FROM FavoriteCustomerDish WHERE old.DishId = FavoriteCustomerDish.DishId;
    DELETE FROM MenuDish WHERE old.DishId = MenuDish.DishId;
    DELETE FROM CategoryDish WHERE old.DishId = CategoryDish.DishId;
    END;
