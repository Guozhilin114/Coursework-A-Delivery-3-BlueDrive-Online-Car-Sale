USE online_car_sale;

INSERT INTO sellers 
(full_name, address, phone, email, username, password)
VALUES
('Test Seller', 'Lingshui Hainan', '13800138000', 'seller@test.com', 'testseller', '123456');

INSERT INTO cars
(seller_id, brand, model, year, mileage, fuel_type, transmission, colour, location, price, image_path, description)
VALUES
(1, 'Toyota', 'Camry', 2019, '52,000 km', 'Petrol', 'Automatic', 'Metallic Black', 'Guangzhou', 18500,
'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
'This 2019 Toyota Camry Luxury Edition is in excellent condition with only 52,000 km.'),

(1, 'Honda', 'Accord', 2020, '35,000 km', 'Petrol', 'Automatic', 'Radiant Red Metallic', 'Sanya', 20300,
'https://cdn.jdpower.com/ArticleImages/JDPA_2020%20Honda%20Accord%20Touring%20Red%20Front%20View.jpg',
'This 2020 Honda Accord with a 1.5T Turbo engine is in excellent condition with only 35,000 km.'),

(1, 'BMW', '3 Series', 2020, '28,000 km', 'Petrol', 'Automatic', 'Mineral White', 'Shenyang', 32800,
'https://images.unsplash.com/photo-1646987001348-a10f81886354?q=80&w=1740&auto=format&fit=crop',
'This 2020 BMW 3 Series 320Li is a modern sports sedan combining elegant design with performance.');
