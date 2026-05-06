USE online_car_sale;

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM cars;
DELETE FROM sellers;

ALTER TABLE cars AUTO_INCREMENT = 1;
ALTER TABLE sellers AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;


INSERT INTO sellers 
(seller_id, full_name, address, phone, email, username, password)
VALUES
(1, 'Li Wei', 'Tianhe District, Guangzhou, Guangdong', '13800138001', 'liwei.seller@example.com', 'liwei_seller', '123456'),
(2, 'Chen Ming', 'Jiyang District, Sanya, Hainan', '13800138002', 'chen.auto@example.com', 'chen_auto', '123456'),
(3, 'Wang Jun', 'Heping District, Shenyang, Liaoning', '13800138003', 'wang.motors@example.com', 'wang_motors', '123456'),
(4, 'Zhao Yuchen', 'Pudong New Area, Shanghai', '13800138004', 'zhao.premium@example.com', 'zhao_premium', '123456');

INSERT INTO cars
(car_id, seller_id, brand, model, year, mileage, fuel_type, transmission, colour, location, price, image_path, description)
VALUES
(1, 1, 'Toyota', 'Camry', 2019, '52,000 km', 'Petrol', 'Automatic', 'Metallic Black', 'Guangzhou', 18500.00,
'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=1000',
'This 2019 Toyota Camry Luxury Edition is in excellent condition with only 52,000 km. The car has a full service history, has never been in an accident, and has been well maintained by its previous owner. Features include leather seats, sunroof, navigation system, backup camera, and advanced safety features.'),

(2, 2, 'Honda', 'Accord', 2020, '35,000 km', 'Petrol', 'Automatic', 'Radiant Red Metallic', 'Sanya', 20300.00,
'https://cdn.jdpower.com/ArticleImages/JDPA_2020%20Honda%20Accord%20Touring%20Red%20Front%20View.jpg',
'This 2020 Honda Accord with a 1.5T Turbo engine is in excellent condition with only 35,000 km. It offers a good balance of power, comfort, and fuel efficiency. The interior is spacious, the transmission is smooth, and the vehicle has been regularly serviced.'),

(3, 3, 'BMW', '3 Series', 2020, '28,000 km', 'Petrol', 'Automatic', 'Mineral White', 'Shenyang', 32800.00,
'https://images.unsplash.com/photo-1646987001348-a10f81886354?w=1000',
'This 2020 BMW 3 Series 320Li combines elegant design with dynamic performance. With only 28,000 km, it offers an extended wheelbase for improved rear-seat comfort. The car includes leather interior, panoramic sunroof, modern infotainment system, and a smooth automatic transmission.'),

(4, 4, 'Audi', 'R8', 2021, '11,000 km', 'Petrol', 'Automatic', 'Daytona Gray Matte', 'Haikou', 145000.00,
'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?w=1000',
'This 2021 Audi R8 V10 Performance is a premium sports car in pristine condition. With only 11,000 km, it features a naturally aspirated V10 engine, aggressive styling, premium interior materials, and a driver-focused cockpit. It is suitable for buyers looking for a high-performance luxury vehicle.'),

(5, 1, 'Volkswagen', 'Tiguan L', 2019, '45,000 km', 'Petrol', 'Automatic', 'Platinum Grey', 'Beijing', 20800.00,
'https://hips.hearstapps.com/hmg-prod/images/2019-volkswagen-tiguan-sel-premium-r-line-awd-110-hdr-1566309829.jpg',
'This 2019 Volkswagen Tiguan L Comfortline is a practical and spacious SUV with 45,000 km. It has been well maintained and is suitable for families. The car offers comfortable seating, a large cargo area, touchscreen infotainment, climate control, and reliable daily driving performance.'),

(6, 4, 'Tesla', 'Model 3', 2022, '12,000 km', 'Electric', 'Automatic', 'Pearl White Multi-Coat', 'Shanghai', 42500.00,
'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=1000',
'This 2022 Tesla Model 3 Long Range is in near-new condition with only 12,000 km. It includes Autopilot, premium sound system, glass roof, wireless charging, and strong electric performance. The vehicle offers excellent driving range and low running costs.'),

(7, 3, 'Mercedes-Benz', 'C-Class', 2021, '18,000 km', 'Petrol', 'Automatic', 'Obsidian Black', 'Lingshui', 38500.00,
'https://images.unsplash.com/photo-1652549423957-d9c4445ee9bf?w=1000',
'This 2021 Mercedes-Benz C-Class C 260 L is a premium sedan with only 18,000 km. It provides a refined driving experience, comfortable rear seats, digital dashboard, premium sound system, ambient lighting, and excellent interior quality.'),

(8, 2, 'Ford', 'Explorer', 2020, '40,000 km', 'Petrol', 'Automatic', 'Oxford White', 'Sanya', 28900.00,
'https://images.unsplash.com/photo-1606611013016-969c19ba27bb?w=1000',
'This 2020 Ford Explorer is a spacious 7-seater SUV with a 2.3L EcoBoost engine and 40,000 km. It is suitable for family use and long-distance travel. The car includes advanced safety features, a practical interior layout, reliable performance, and flexible cargo space.');
