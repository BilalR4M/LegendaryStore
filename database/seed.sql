-- Sample data for shop_db. Import database/schema.sql first.
-- Local demo admin: name `admin`, password `111`. Change it after import.

INSERT INTO users (id, name, email, password) VALUES
(1, 'Abe Malone', 'Ajames57@gmail.com', '$2b$10$P8hldwIF4QbX3Ln4Zg/sX.AeZ1.D0IMquNAXD.Nm.XD3nZR1zCnqS'),
(2, 'Marie Doe', 'Raze800@yahoo.com', '$2b$10$hQEMleGdkQ7kJHcwJa5xnecqZq4Z8W2vWAgpOjofhvUSd4Eg5qhiC'),
(3, 'Jonh Black', 'Sage678@outlook.com', '$2b$10$gFPlSkZF1RF9q4WmPkzfwOywmtSQcr6WODXwQECXFXtbZ61y0CtDK'),
(4, 'Alia Smith', 'Brim969@gmail.com', '$2b$10$t5A/8if0yQ8ejPCnPAv6wuGpH3TMIpzWhu444gfu6ShDsy./ezOW6'),
(5, 'Arashi Akino', 'Arashi700@gmail.com', '$2b$10$RDerLQMsf4t3vy29CCZzIeH.CqbwZq68Avf06ntbN7WXTDJQuGHuO');

INSERT INTO admins (id, name, password) VALUES
(1, 'admin', '$2b$10$WV4S4IxlT1JjZIkwrl71VuyjC3wQiOdmR5ZGdMD4tqFt5KJ7JFIZu'),
(2, 'Radhi', '$2b$10$fOAnzJrTgJ78WxeXumRKCOZzXV4Nd7yQnelK7hvk2WCcxvVwPJz0K'),
(3, 'Anton', '$2b$10$iAVksVW7V7ma9t08Z3NjL.a28oTg/r/7hGy81TwWxIl5vmWPCdUZq'),
(4, 'Lemon', '$2b$10$aR0O7uO7NH3SDu.nkl83PuXepZUhafJcRiApbb5FFtkQjtvRE153y'),
(5, 'Kakashi', '$2b$10$1zc404YMo3c4ELKw/pljCu6jLPq4c/YsrZ0hCbNFyyFMkWzU6gL5G'),
(6, 'Temari', '$2b$10$q.pwJpbhG4Jrc/UHIQFOMu9cl9lrJBHXzfAvQtfugfHiukHyLdZay');

INSERT INTO products (id, name, details, price, category, image_01, image_02, image_03) VALUES
(1, 'Batman Arkham Knight game', 'Batman: Arkham Knight is a 2015 action-adventure game developed by Rocksteady Studios and published by Warner Bros. Interactive Entertainment.', 50, 'game', 'batman1.jpg', 'batman2.jpg', 'batman3.jpg'),
(2, 'John Wick Chapter 4 movie', 'With the price on his head ever increasing, legendary hit man John Wick takes his fight against the High Table global as he seeks out the most powerful players in the underworld, from New York to Paris to Japan to Berlin.', 20, 'movie', 'john1.jpg', 'john2.jpg', 'john3.jfif'),
(3, 'Midnights Album music', 'Midnights is the tenth studio album by American singer-songwriter Taylor Swift, released on October 21, 2022, via Republic Records. It was announced at the 2022 MTV Video Music Awards, marking Swift''s first new body of work since her 2020 indie folk albums, Folklore and Evermore.', 15, 'music', 'midnights1.png', 'midnights2.jpg', 'midnights3.png'),
(4, 'Assetto corsa game', 'Assetto Corsa is a sim racing video game developed by the Italian video game developer Kunos Simulazioni. It is designed with an emphasis on a realistic racing experience with support for extensive customization and moddability.', 40, 'game', 'Assetto1.png', 'Assetto2.jpg', 'Assetto3.jpg'),
(5, 'Interstellar movie', 'When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.', 30, 'movie', 'interstellar1.jpg', 'interstellar2.jpg', 'interstellar3.jfif'),
(6, 'Divide Album music', 'Divide is the third studio album by English singer-songwriter Ed Sheeran. It was released on 3 March 2017 through Asylum Records and Atlantic Records. Castle on the Hill and Shape of You were released as the album''s lead singles on 6 January 2017.', 9, 'music', 'devide1.jpg', 'devide2.jpg', 'devide3.jpg'),
(7, 'NieR:Automata game', 'Nier: Automata is a 2017 action role-playing game developed by PlatinumGames and published by Square Enix. It is a sequel to Nier, itself a spin-off of and sequel to the Drakengard series.', 49, 'game', 'nier1.jfif', 'nier2.jpg', 'nier3.jpg'),
(8, 'Love Actually movie', 'Eight London couples try to deal with their relationships in different ways. Their tryst with love makes them discover how complicated relationships can be.', 24, 'movie', 'love1.jpg', 'love2.jfif', 'love3.jpg'),
(9, 'Back in Black Album music', 'Back in Black is the seventh studio album by Australian rock band AC/DC, released by Albert Productions and Atlantic Records on 25 July 1980. It was the band''s first album to feature Brian Johnson as lead singer, following the death of Bon Scott, their previous vocalist.', 33, 'music', 'acdc1.png', 'acdc2.jpg', 'acdc3.jpg'),
(10, '$100 giftcard', 'A gift card for any occasion. The recipient chooses from the catalog.', 100, 'giftcard', 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg'),
(11, '$50 giftcard', 'A gift card for any occasion. The recipient chooses from the catalog.', 50, 'giftcard', 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg'),
(12, '$25 giftcard', 'A gift card for any occasion. The recipient chooses from the catalog.', 25, 'giftcard', 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg');

INSERT INTO orders (id, user_id, name, number, email, method, address, total_price, placed_on, payment_status) VALUES
(1, 4, 'Alia Smith', '02223344', 'Brim969@gmail.com', 'credit card', 'Colombo', 140, '2023-06-10', 'completed'),
(2, 4, 'Alia Smith', '114478985', 'Brim969@gmail.com', 'credit card', 'Colombo', 70, '2023-06-11', 'pending'),
(3, 4, 'Alia Smith', '114589655', 'Brim969@gmail.com', 'paytm', 'Colombo', 74, '2023-06-11', 'completed'),
(4, 2, 'Marie Doe', '114587895', 'Raze800@yahoo.com', 'paytm', 'Kandy', 63, '2023-06-11', 'pending'),
(5, 2, 'Marie Doe', '114258785', 'Raze800@yahoo.com', 'paypal', 'Kandy', 129, '2023-06-11', 'completed');

INSERT INTO order_items (order_id, product_id, name, quantity, unit_price) VALUES
(1, 1, 'Batman Arkham Knight game', 2, 50),
(1, 2, 'John Wick Chapter 4 movie', 2, 20),
(2, 1, 'Batman Arkham Knight game', 1, 50),
(2, 2, 'John Wick Chapter 4 movie', 1, 20),
(3, 1, 'Batman Arkham Knight game', 1, 50),
(3, 8, 'Love Actually movie', 1, 24),
(4, 6, 'Divide Album music', 1, 9),
(4, 5, 'Interstellar movie', 1, 30),
(4, 8, 'Love Actually movie', 1, 24),
(5, 11, '$50 giftcard', 1, 50),
(5, 5, 'Interstellar movie', 1, 30),
(5, 7, 'NieR:Automata game', 1, 49);

INSERT INTO messages (id, user_id, name, email, number, message) VALUES
(1, 4, 'Alia Smith', 'Brim969@gmail.com', '0114257869', 'I need a refund defect in game'),
(2, 2, 'Marie Doe', 'Raze800@yahoo.com', '0114578246', 'The music album I boaght is missing a track.Please update the album');

ALTER TABLE users AUTO_INCREMENT = 6;
ALTER TABLE admins AUTO_INCREMENT = 7;
ALTER TABLE products AUTO_INCREMENT = 13;
ALTER TABLE orders AUTO_INCREMENT = 6;
ALTER TABLE messages AUTO_INCREMENT = 3;
