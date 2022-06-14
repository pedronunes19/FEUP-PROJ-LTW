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
    (10, "Restaurante 10", "Add 10", 1),
    (11, "Restaurante 11", "Add 11", 1),
    (12, "Restaurante 12", "Add 12", 1),
    (13, "Restaurante 13", "Add 13", 1),
    (14, "Restaurante 14", "Add 14", 1);

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

INSERT INTO Dish (Name, Price, RestaurantId) 
VALUES 
    ("Prato 1", 1.00, 1),
    ("Prato 2", 2.00, 1),
    ("Prato 3", 3.00, 1),
    ("Prato 4", 4.00, 2),
    ("Prato 5", 5.00, 3),
    ("Prato 6", 1.00, 3),
    ("Prato 7", 2.00, 3),
    ("Prato 8", 3.00, 4),
    ("Prato 9", 4.00, 4),
    ("Prato 10", 5.00, 5),
    ("Prato 11", 1.00, 5),
    ("Prato 12", 2.00, 5),
    ("Prato 13", 3.00, 6),
    ("Prato 14", 4.00, 7),
    ("Prato 15", 5.00, 7),
    ("Prato 16", 4.00, 8),
    ("Prato 17", 2.00, 8),
    ("Prato 18", 3.00, 9),
    ("Prato 19", 4.00, 9),
    ("Prato 20", 5.00, 10),
    ("Prato 21", 1.00, 11),
    ("Prato 22", 2.00, 12),
    ("Prato 23", 3.00, 12),
    ("Prato 24", 4.00, 12),
    ("Prato 25", 5.00, 13);


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
    (4, 5, "Review 4", 1, 1),
    (5, 4, "Review 5", 1, 4),
    (6, 1, "Review 6", 1, 2),
    (7, 3, "Review 7", 1, 6);

INSERT INTO Review (ReviewId, ReviewScore, ReviewContent, ReviewResponse, CustomerId, RestaurantId) 
VALUES 
    (8, 3, "This is a review of this restaurant.", "This is a response to this review.", 1, 1);

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
('South American'), ('Greek'), ('Mediterranean'), ('Falafel'), ('Variety');

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