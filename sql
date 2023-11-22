-- Tabel voor Personen
CREATE TABLE Persoon (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(255),
    Achternaam VARCHAR(255),
    Tussenvoegsel VARCHAR(50),
    Email VARCHAR(255) UNIQUE,
    Wachtwoord VARCHAR(255)
);

-- Tabel voor Klanten
CREATE TABLE Klant (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Klantcode VARCHAR(5),
    Straatnaam VARCHAR(255),
    Huisnummer VARCHAR(10),
    Postcode VARCHAR(6),
    Woonplaats VARCHAR(100),
    Land VARCHAR(100),
    PersoonID INT,
    FOREIGN KEY (PersoonID) REFERENCES Persoon(ID)
);

-- Tabel voor Medewerkers
CREATE TABLE Medewerker (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Rol VARCHAR(100),
    PersoonID INT,
    FOREIGN KEY (PersoonID) REFERENCES Persoon(ID)
);

-- Tabel voor Productcategorieën
CREATE TABLE Productcategorie (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100),
    Code VARCHAR(50),
    Beschrijving TEXT
);

-- Tabel voor Producten
CREATE TABLE Product (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(255),
    Prijs DECIMAL(19, 4),
    Aantal INT,
    CategorieID INT,
    FOREIGN KEY (CategorieID) REFERENCES Productcategorie(ID)
);

-- Tabel voor Media
CREATE TABLE Media (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(255),
    Extensie VARCHAR(10),
    Pad VARCHAR(255)
);

-- Tussentabel voor de relatie tussen Producten en Media
CREATE TABLE ProductMedia (
    ProductID INT,
    MediaID INT,
    PRIMARY KEY (ProductID, MediaID),
    FOREIGN KEY (ProductID) REFERENCES Product(ID),
    FOREIGN KEY (MediaID) REFERENCES Media(ID)
);

-- Tabel voor Bestellingen
CREATE TABLE Bestelling (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    KlantID INT,
    DatumBestelling DATE,
    DatumBetaling DATE,
    DatumVerzending DATE,
    Totaalprijs DECIMAL(19, 4),
    Status VARCHAR(100),
    FOREIGN KEY (KlantID) REFERENCES Klant(ID)
);

-- Tabel voor Bestelregels
CREATE TABLE Bestelregel (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    BestellingID INT,
    ProductID INT,
    Aantal INT,
    Stukprijs DECIMAL(19, 4),
    Totaal DECIMAL(19, 4),
    FOREIGN KEY (BestellingID) REFERENCES Bestelling(ID),
    FOREIGN KEY (ProductID) REFERENCES Product(ID)
);

-- Tabel voor Cadeaukaarten
CREATE TABLE Cadeaukaart (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    CadeaukaartCode VARCHAR(255),
    BestellingID INT,
    Bedrag DECIMAL(10, 2),
    Pin VARCHAR(255),
    Restwaarde DECIMAL(10, 2),
    FOREIGN KEY (BestellingID) REFERENCES Bestelling(ID)
);

-- Tabel voor Verzendingen
CREATE TABLE Verzending (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Verzendmethode VARCHAR(100),
    Verzendkosten DECIMAL(19, 4),
    BestellingID INT,
    FOREIGN KEY (BestellingID) REFERENCES Bestelling(ID)
);

-- Tabel voor Betalingen
CREATE TABLE Betaling (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Betaalmethode VARCHAR(100),
    BestellingID INT,
    FOREIGN KEY (BestellingID) REFERENCES Bestelling(ID)
);

-- Tabel voor Facturen (aangenomen dat er een relatie is tussen Bestelling en Factuur)
CREATE TABLE Factuur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    BestellingID INT,
    Datum DATE,
    Totaalprijs DECIMAL(19, 4),
    Status VARCHAR(100),
    FOREIGN KEY (BestellingID) REFERENCES Bestelling(ID)
);
