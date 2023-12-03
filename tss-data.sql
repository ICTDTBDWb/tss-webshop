-- Dummy data voor medewerkers
INSERT INTO `tss`.`medewerkers` (`rol`, `email`, `password`, `voornaam`, `tussenvoegsel`, `achternaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`)
VALUES
  ('klantenservice', 'medewerker1@email.com', 'wachtwoord1', 'John', 'van', 'Doe', 'Straatnaam 1', '123', '1234 AB', 'Stad', 'Nederland'),
  ('webredacteur', 'medewerker2@email.com', 'wachtwoord2', 'Jane', NULL, 'Doe', 'Straatnaam 2', '456', '5678 CD', 'Stad', 'Nederland'),
  ('seospecialist', 'medewerker3@email.com', 'wachtwoord3', 'Bob', 'de', 'Bouwer', 'Straatnaam 3', '789', '9012 EF', 'Stad', 'Nederland');

-- Dummy data voor klanten
INSERT INTO `tss`.`klanten` (`email`, `password`, `voornaam`, `tussenvoegsel`, `achternaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`)
VALUES
  ('klant1@email.com', 'wachtwoordklant1', 'Alice', NULL, 'Klant', 'Klantenstraat 1', '101', '2345 GH', 'Dorp', 'Nederland'),
  ('klant2@email.com', 'wachtwoordklant2', 'Bob', NULL, 'Klant', 'Klantenstraat 2', '202', '3456 IJ', 'Dorp', 'Nederland');

-- Dummy data voor producten
INSERT INTO `tss`.`producten` (`naam`, `prijs`, `aantal`)
VALUES
  ('Fender Stratocaster', 999.99, 20),
  ('Taylor 214ce Akoestische Gitaar', 1499.99, 15),
  ('Ibanez SR500 Basgitaar', 799.99, 10),
  ('Marshall JVM410H Gitaarversterker', 1999.99, 5),
  ('D\'Addario EXL120 Snarenset', 9.99, 50);

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
  (1, 1, NOW(), 999.99),
  (2, 2, NOW(), 2499.98),
  (1, 3, NOW(), 399.97);

-- Dummy data voor cadeaubonnen
INSERT INTO `tss`.`cadeaubonnen` (`code`, `pin`, `bedrag`)
VALUES
  ('GITAAR10', '123456', 10.00),
  ('GITAAR25', '789012', 25.00),
  ('GITAAR50', '345678', 50.00);

-- Dummy data voor bestelling_regels
INSERT INTO `tss`.`bestelling_regels` (`bestelling_id`, `product_id`, `cadeaubon_id`, `aantal`, `stukprijs`, `totaal`)
VALUES
  (1, 1, NULL, 1, 999.99, 999.99),
  (2, 2, NULL, 2, 1249.99, 2499.98),
  (3, 3, 1, 1, 399.97, 399.97);

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
  (3, 'iDeal', NOW(), 399.97);

-- Dummy data voor media
INSERT INTO `tss`.`media` (`naam`, `pad`, `extensie`)
VALUES
  ('Gitaar Afbeelding 1', '/afbeeldingen/gitaar1.jpg', 'jpg'),
  ('Gitaar Afbeelding 2', '/afbeeldingen/gitaar2.jpg', 'jpg'),
  ('Gitaar Afbeelding 3', '/afbeeldingen/gitaar3.jpg', 'jpg');

-- Dummy data voor product_media
INSERT INTO `tss`.`product_media` (`product_id`, `media_id`)
VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 1),
  (5, 2);
