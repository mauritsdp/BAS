
CREATE DATABASE basshop;


USE basshop;


CREATE TABLE ARTIKELEN (
  artId INT PRIMARY KEY AUTO_INCREMENT,
  artOmschrijving VARCHAR(12) NOT NULL,
  artInkoop DECIMAL(3, 2),
  artVerkoop DECIMAL(3, 2),
  artVoorraad INT NOT NULL,
  artMinVoorraad INT NOT NULL,
  artMaxVoorraad INT NOT NULL,
  artLocatie INT,
  levId INT NOT NULL
);


CREATE TABLE LEVERANCIERS (
  levId INT PRIMARY KEY AUTO_INCREMENT,
  levnaam VARCHAR(15) NOT NULL,
  levcontact VARCHAR(20),
  levEmail VARCHAR(30) NOT NULL,
  levAdres VARCHAR(30),
  levPostcode VARCHAR(6),
  levWoonplaats VARCHAR(25)
);


CREATE TABLE INKOOPORDERS (
  inkOrdId INT PRIMARY KEY AUTO_INCREMENT,
  levId INT,
  artId INT,
  inkOrdDatum DATE,
  inkOrdBestAantal INT,
  inkOrdStatus BOOLEAN
);


CREATE TABLE VERKOOPORDERS (
  verkOrdId INT PRIMARY KEY AUTO_INCREMENT,
  klantId INT,
  artId INT,
  verkOrdDatum DATE,
  verkOrdBestAantal INT,
  verkOrdStatus INT NOT NULL DEFAULT 1
);


CREATE TABLE KLANTEN (
  klantid INT PRIMARY KEY AUTO_INCREMENT,
  klantnaam VARCHAR(20),
  klantEmail VARCHAR(30) NOT NULL,
  klantAdres VARCHAR(30) NOT NULL,
  klantPostcode VARCHAR(6),
  klantWoonplaats VARCHAR(25)
);
