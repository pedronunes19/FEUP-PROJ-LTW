INSERT INTO RestaurantOwner (OwnerId, FirstName, LastName, Email, Password) 
VALUES 
    (1, "Owner"," 1", "email@email.com", "Password 1" ),
    (2, "Owner",  "2", "owner@owner.com", "Password 2" ),
    (3, "Owner", "3", "votae@votae.com", "Password 3" ),
    (4, "João", "Patrão Genérico", "joaogenerico@gmail.com", "$2y$10$SXdWFvjbGAbe/N8vgInw2uf0jgYC8FtUGElEAAHRa0IM.OqHNPE0q");

INSERT INTO Restaurant (RestaurantId, Name, Address, OwnerId) 
VALUES 
    (1, "Restaurante 1", "Add 1", 4),
    (2, "Restaurante 2", "Add 2", 4),
    (3, "Restaurante 3", "Add 3", 4),
    (4, "Restaurante 4", "Add 4", 4),
    (5, "Restaurante 5", "Add 5", 4),
    (6, "Restaurante 6", "Add 6", 4),
    (7, "Restaurante 7", "Add 7", 4),
    (8, "Restaurante 8", "Add 8", 4),
    (9, "Restaurante 9", "Add 9", 4),
    (10, "Restaurante 10", "Add 10", 4),
    (11, "Restaurante 11", "Add 11", 4),
    (12, "Restaurante 12", "Add 12", 4),
    (13, "Restaurante 13", "Add 13", 4),
    (14, "Restaurante 14", "Add 14", 4);

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
    (3, "Prato 3", 3.00, 1);

INSERT INTO Customer (CustomerId, FirstName, LastName, Email, Address, Password) 
VALUES 
    (1, "Cliente", "1", "Email 1", "Address 1", "Password 1"),
    (2, "Cliente", "2", "Email 2", "Address 1", "Password 2"),
    (3, "Cliente", "3", "Email 3", "Address 2", "Password 3"),
    (4, "Cliente", "4", "email@email.com", "Address 3", "01b307acba4f54f55aafc33bb06bbbf6ca803e9a"),
    (5, "João", "Genérico", "joaogenerico@gmail.com", "Rua dos Genéricos, 20", "$2y$10$SXdWFvjbGAbe/N8vgInw2uf0jgYC8FtUGElEAAHRa0IM.OqHNPE0q");

INSERT INTO OrderQueue (OrderId, CustomerId, RestaurantId, Status) 
VALUES 
    (1, 1, 1, "Received"),
    (2, 1, 1, "Received"),
    (3, 1, 1, "Received"),
    (4, 1, 5, "Received"),
    (5, 2, 5, "Received"),
    (6, 1, 5, "Received"),
    (7, 1, 5, "Received"),
    (8, 3, 5, "Received"),
    (9, 3, 5, "Received"),
    (10, 5, 1, "Received"),
    (11, 5, 2, "Received"),
    (12, 5, 3, "Received"),
    (13, 5, 4, "Received"),
    (14, 5, 5, "Received");


INSERT INTO Review (ReviewId, ReviewScore, ReviewContent, CustomerId, RestaurantId) 
VALUES 
    (1, 3, "Review 1", 1, 1),
    (2, 5, "Review 2", 1, 1),
    (3, 2, "Review 3", 1, 1),
    (4, 5, "Review text", 5, 1),
    (5, 4, "Review text", 5, 4),
    (6, 1, "Review text", 5, 2),
    (7, 3, "Review text", 5, 6);

INSERT INTO FavoriteCustomerRestaurant (FavoriteCustomerRestaurantId, CustomerId, RestaurantId)
VALUES 
    (1, 5, 1),
    (2, 5, 4),
    (3, 5, 10);
    
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
    (5, 2),
    (14, 3),
    (4, 4),
    (8, 5),
    (17, 6),
    (3, 7),
    (5, 8),
    (8, 9),
    (12, 10),
    (9, 11),
    (2, 12),
    (10, 13),
    (11, 14);

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
    (14, 3);