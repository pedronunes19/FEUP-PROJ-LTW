INSERT INTO Restaurant (RestaurantId, Name) 
VALUES 
    (1, "Restaurante 1"),
    (2, "Restaurante 2"),
    (3, "Restaurante 3");

INSERT INTO Menu (MenuId, Name, RestaurantId) 
VALUES 
    (1, "Menu 1", 1),
    (2, "Menu 2", 1),
    (3, "Menu 3", 1),
    (4, "Menu 4", 2),
    (5, "Menu 5", 2),
    (6, "Menu 6", 2),
    (7, "Menu 7", 3),
    (8, "Menu 8", 3),
    (9, "Menu 9", 3);

INSERT INTO Dish (DishId, Name, MenuId) 
VALUES 
    (1, "Prato 1", 1),
    (2, "Prato 2", 1),
    (3, "Prato 3", 1);

INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Password) 
VALUES 
    (1, "Cliente", "1", "Email 1", "Password 1"),
    (2, "Cliente", "2", "Email 2", "Password 2"),
    (3, "Cliente", "3", "Email 3", "Password 3");

INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId) 
VALUES 
    (1, 1, 1),
    (2, 1, 1),
    (3, 1, 1);
    
INSERT INTO Review (ReviewId, ReviewContent, CustomerId, RestaurantId) 
VALUES 
    (1, "Review 1", 1, 1),
    (2, "Review 2", 2, 1),
    (3, "Review 3", 3, 1);