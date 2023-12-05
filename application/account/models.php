<?php
class Klant {
    public $voornaam;
    public $achternaam;
    public $straat;
    public $huisnummer;
    public $postcode;
    public $woonplaats;
    public $email;
    public $id;

    public function __construct($voornaam, $achternaam,$straat,$huisnummer,$postcode,$woonplaats,$email,$id) {
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->email = $email;
        $this->id = $id;
    }
}

class Laatstebestelling {
    public $bestelling_id;
    public $product_naam;
    public $product_foto_pad;
    public $product_foto_naam;
    public $besteldatum;
    public $klant_id;

    public function __construct($bestelling_id, $product_naam, $product_foto_pad, $product_foto_naam, $besteldatum, $klant_id) {
        $this->bestelling_id = $bestelling_id;
        $this->product_naam = $product_naam;
        $this->product_foto_pad = $product_foto_pad;
        $this->product_foto_naam = $product_foto_naam;
        $this->besteldatum = $besteldatum;
        $this->klant_id = $klant_id;
    }
}


