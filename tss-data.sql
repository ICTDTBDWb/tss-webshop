-- Dummy data voor medewerkers
INSERT INTO `tss`.`medewerkers` (`rol`, `email`, `password`, `voornaam`, `tussenvoegsel`, `achternaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`)
VALUES
    ('klantenservice', 'medewerker1@email.com', '$2y$10$DCY9NotoJlmBlXzT35GmUOufSMIm8kbOjUCpsAcJHdw2Yr/556T2i', 'John', 'van', 'Doe', 'Straatnaam 1', '123', '1234 AB', 'Stad', 'Nederland'),
    ('webredacteur', 'medewerker2@email.com', '$2y$10$DCY9NotoJlmBlXzT35GmUOufSMIm8kbOjUCpsAcJHdw2Yr/556T2i', 'Jane', NULL, 'Doe', 'Straatnaam 2', '456', '5678 CD', 'Stad', 'Nederland'),
    ('seospecialist', 'medewerker3@email.com', '$2y$10$DCY9NotoJlmBlXzT35GmUOufSMIm8kbOjUCpsAcJHdw2Yr/556T2i', 'Bob', 'de', 'Bouwer', 'Straatnaam 3', '789', '9012 EF', 'Stad', 'Nederland');

-- Dummy data voor klanten
INSERT INTO `tss`.`klanten` (`email`, `password`, `voornaam`, `tussenvoegsel`, `achternaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`)
VALUES
    ('klant1@email.com', '$2y$10$DCY9NotoJlmBlXzT35GmUOufSMIm8kbOjUCpsAcJHdw2Yr/556T2i', 'Alice', NULL, 'Klant', 'Klantenstraat 1', '101', '2345 GH', 'Dorp', 'Nederland'),
    ('klant2@email.com', '$2y$10$DCY9NotoJlmBlXzT35GmUOufSMIm8kbOjUCpsAcJHdw2Yr/556T2i', 'Bob', NULL, 'Klant', 'Klantenstraat 2', '202', '3456 IJ', 'Dorp', 'Nederland');

-- Dummy data voor producten
INSERT INTO `tss`.`producten` (`naam`, `prijs`, `aantal`)
VALUES
    ('Fender Stratocaster', 999.99, 20),
    ('Taylor 214ce Akoestische Gitaar', 1499.99, 15),
    ('Ibanez SR500 Basgitaar', 799.99, 10),
    ('Marshall JVM410H Gitaarversterker', 1999.99, 5),
    ('D\'Addario EXL120 Snarenset', 9.99, 50),
    ('Giftbox 25', 25.00, 100),
    ('Giftbox 50', 50.00, 100),
    ('Giftbox 75', 75.00, 100),
    ('Giftbox 100', 100.00, 100);


-- Dummy data voor categorieen
INSERT INTO `tss`.`categorieen` (`naam`, `beschrijving`)
VALUES
    ('Elektrische Gitaren', 'Elektrische gitaren en accessoires'),
    ('Akoestische Gitaren', 'Akoestische gitaren en accessoires'),
    ('Basgitaren', 'Basgitaren en accessoires'),
    ('Gitaarversterkers', 'Versterkers voor gitaren'),
    ('Gitaaraccessoires', 'Accessoires zoals snaren, plectrums, etc.');

-- Dummy data voor product_categorieen
INSERT INTO `tss`.`product_categorieen` (`product_id`, `categorie_id`)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5);

-- Dummy data voor verzendmethoden
INSERT INTO `tss`.`verzendmethoden` (`naam`, `verzendkosten`)
VALUES
    ('Standaard Verzending', 5.99),
    ('Express Verzending', 12.99),
    ('Ophalen in Winkel', 0.00);

-- Dummy data voor bestellingen
INSERT INTO `tss`.`bestellingen` (`klant_id`, `verzendmethode_id`, `besteldatum`, `totaal`)
VALUES
    (1, 1, '2023-12-17 14:18:21', 999.99),
    (2, 2, '2023-12-17 14:18:22', 2499.98),
    (1, 3, '2023-12-17 14:18:23', 399.97);

INSERT INTO `tss`.`bestellingen` (`klant_id`, `verzendmethode_id`, `besteldatum`, `totaal`, `voornaam`, `tussenvoegsel`, `achternaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`)
VALUES
    (2, 3, '2023-12-29 18:09:30', 7944.97, 'John', 'van', 'Doe', 'Straatnaam 1', '123', '1234 AB', 'Stad', 'Nederland');

-- Dummy data voor cadeaubonnen
INSERT INTO `tss`.`cadeaubonnen` (`code`, `pin`, `bedrag`)
VALUES
    ('GITAAR10', '123456', 8.00),
    ('GITAAR25', '789012', 25.00),
    ('GITAAR50', '345678', 50.00);

-- Dummy data voor bestelling_regels
INSERT INTO `tss`.`bestelling_regels` (`bestelling_id`, `product_id`, `cadeaubon_id`, `aantal`, `stukprijs`, `totaal`, `product_naam`)
VALUES
    (1, 1, NULL, 1, 999.99, 999.99, ''),
    (2, 2, NULL, 2, 1249.99, 2499.98, ''),
    (3, 3, NULL, 1, 399.97, 399.97, ''),
    (4, 2, NULL, 2, 1499.99, 2999.98, 'Taylor 214ce Akoestische Gitaar'),
    (4, 3, NULL, 1, 799.99, 799.99, 'Ibanez SR500 Basgitaar'),
    (4, 4, NULL, 2, 1999.99, 3999.98, 'Marshall JVM410H Gitaarversterker'),
    (4, 6, NULL, 2, 25.00, 50.00, 'Giftbox 25');


-- Dummy data voor facturen
INSERT INTO `tss`.`facturen` (`bestelling_id`, `datum`, `totaal`)
VALUES
    (1, NOW(), 999.99),
    (2, NOW(), 2499.98),
    (3, NOW(), 399.97);

-- Dummy data voor betalingen
INSERT INTO `tss`.`betalingen` (`bestelling_id`, `betalingsprovider`, `datum`, `totaal`)
VALUES
    (1, 'PayPal', NOW(), 999.99),
    (2, 'Credit Card', NOW(), 2499.98),
    (3, 'iDeal', NOW(), 399.97),
    (4, 'iDeal', NOW(), 7944.97);

-- Dummy data voor media
INSERT INTO `tss`.`media` (`id`, `product_id`, `naam`, `pad`, `extensie`)
VALUES
    (1, 1, 'foto1', '/assets/afbeeldingen/guitar1', 'jpg'),
    (2, 2, 'foto2', '/assets/afbeeldingen/guitar2', 'jpg'),
    (3, 3, 'foto3', '/assets/afbeeldingen/guitar3', 'jpg'),
    (4, 6, 'foto4', '/assets/afbeeldingen/cadeaubon', 'jpg'),
    (5, 7, 'foto5', '/assets/afbeeldingen/cadeaubon', 'jpg'),
    (6, 8, 'foto6', '/assets/afbeeldingen/cadeaubon', 'jpg'),
    (7, 9, 'foto7', '/assets/afbeeldingen/cadeaubon', 'jpg');

