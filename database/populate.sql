INSERT INTO RestaurantOwner (OwnerId, FirstName, LastName, Email, Password) 
VALUES 
    (1, "João", "Patrão Genérico", "joaogenerico@gmail.com", "$2y$10$SXdWFvjbGAbe/N8vgInw2uf0jgYC8FtUGElEAAHRa0IM.OqHNPE0q");

INSERT INTO Restaurant (RestaurantId, Name, Address, OwnerId) 
VALUES 
    (1, "Restaurante 1", "Add 1", 1),
    (2, "Restaurante 2", "Add 2", 1),
    (3, "Restaurante 3", "Add 3", 1),
    (4, "Restaurante 4", "Add 4", 1),
    (5, "Restaurante 5", "Add 5", 1),
    (6, "Restaurante 6", "Add 6", 1),
    (7, "Restaurante 7", "Add 7", 1),
    (8, "Restaurante 8", "Add 8", 1),
    (9, "Restaurante 9", "Add 9", 1),
    (10, "Restaurante 10", "Add 10", 2),
    (11, "Restaurante 11", "Add 11", 2),
    (12, "Restaurante 12", "Add 12", 2),
    (13, "Restaurante 13", "Add 13", 2),
    (14, "Restaurante 14", "Add 14", 2);

INSERT INTO Menu (MenuId, Name, Price, RestaurantId) 
VALUES 
    (1, "Menu 1", 1.00, 1),
    (2, "Menu 2", 2.00, 1),
    (3, "Menu 3", 3.00, 1),
    (4, "Menu 4", 4.00, 2),
    (5, "Menu 5", 5.00, 2),
    (6, "Menu 6", 6.00, 2),
    (7, "Menu 7", 7.00, 1),
    (8, "Menu 8", 8.00, 3),
    (9, "Menu 9", 9.00, 3);

INSERT INTO Dish (DishId, Name, Price, RestaurantId) 
VALUES 
    (1, "Prato 1", 1.00, 1),
    (2, "Prato 2", 2.00, 1),
    (3, "Prato 3", 3.00, 1),
    (4, "Prato 4", 4.00, 2),
    (5, "Prato 5", 5.00, 3);

INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Address, Password) 
VALUES 
    (1, "João", "Genérico", "joaogenerico@gmail.com", "Rua dos Genéricos, 20", "$2y$10$SXdWFvjbGAbe/N8vgInw2uf0jgYC8FtUGElEAAHRa0IM.OqHNPE0q");

INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId, Status) 
VALUES 
    (1, 1, 1, "Received"),
    (2, 1, 1, "Received"),
    (3, 1, 1, "Received"),
    (4, 1, 5, "Received"),
    (5, 1, 5, "Received"),
    (6, 1, 5, "Received"),
    (7, 1, 5, "Received"),
    (8, 1, 5, "Received"),
    (9, 1, 5, "Received"),
    (10, 1, 1, "Received"),
    (11, 1, 2, "Received"),
    (12, 1, 3, "Received"),
    (13, 1, 4, "Received"),
    (14, 1, 5, "Received");


INSERT INTO Review (ReviewId, ReviewScore, ReviewContent, CustomerId, RestaurantId) 
VALUES 
    (1, 3, "Review 1", 1, 1),
    (2, 5, "Review 2", 1, 1),
    (3, 2, "Review 3", 1, 1),
    (4, 5, "Review text", 1, 1),
    (5, 4, "Review text", 1, 4),
    (6, 1, "Review text", 1, 2),
    (7, 3, "Review text", 1, 6);

INSERT INTO FavoriteCustomerRestaurant (FavoriteCustomerRestaurantId, CustomerId, RestaurantId)
VALUES 
    (1, 1, 1),
    (2, 1, 4),
    (3, 1, 10);

INSERT INTO MenuDish (MenuId, DishId)
VALUES
    (1, 1),
    (1, 2),
    (2, 1),
    (2, 3),
    (3, 2),
    (3, 3),
    (4, 4),
    (5, 4),
    (6, 4),
    (7, 1),
    (7, 2),
    (7, 3),
    (8, 5),
    (9, 5);
    
INSERT INTO Category (Name)
VALUES 
('Vegetarian'), ('Vegan'), ('Gluten Free'), ('Asian'), ('Fast Food'),
('Burger'), ('Pizza'), ('Italian'), ('Sushi'), ('Healthy'), ('BBQ'), ('Portuguese'),
('Sandwich'), ('Desserts'), ('Poke'), ('Brazilian'), ('Kebab'), ('Chinese'),
('Comfort Food'), ('Mexican'), ('Juice and Smoothies'), ('Indian'), ('Chicken'),
('Bakery'), ('Pasta'), ('Deli'), ('Soup'), ('Hot Dog'), ('Wings'), ('Thai'),
('Salads'), ('Seafood'), ('Pastry'), ('Burritos'), ('American'), ('European'),
('Fish and Chips'), ('Ice Cream'), ('Coffee and Tea'), ('Middle Eastern'),
('Halal'), ('Japanese'), ('Turkish'), ('Pub'), ('Spanish'), ('Hawaiian'),
('South American'), ('Greek'), ('Mediterranean'), ('Falafel');

INSERT INTO CategoryRestaurant (CategoryId, RestaurantId)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10),
    (11, 11),
    (12, 12),
    (13, 13),
    (14, 14);

INSERT INTO CategoryMenu (CategoryId, MenuId)  
VALUES
    (1, 1),
    (5, 2),
    (14, 3),
    (4, 4),
    (8, 5),
    (17, 6),
    (3, 7),
    (5, 8),
    (8, 9);

INSERT INTO CategoryDish (CategoryId, DishId)  
VALUES
    (1, 1),
    (5, 2),
    (14, 3),
    (6, 4),
    (10, 5);