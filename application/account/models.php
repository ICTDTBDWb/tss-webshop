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



