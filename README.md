# VillaKlant Project

## Overzicht
VillaKlant is een klantbeheerapplicatie die is ontworpen om het proces van het bijhouden van klantinformatie voor bedrijven te vereenvoudigen. Deze applicatie stelt gebruikers in staat om klantgegevens efficiënt te creëren, lezen, bijwerken en verwijderen.

## Projectstructuur
Het project bestaat uit de volgende bestanden en directories:

```
villaklant
├── config
│   └── db_connect.php        # Maakt verbinding met de MySQL-database
├── includes
│   ├── header.php            # Bevat de HTML-header en navigatie
│   └── footer.php            # Bevat de HTML-footer en scripts
├── klanten
│   ├── create_klant.php      # Behandelt het aanmaken van een nieuwe klant
│   ├── read_klant.php        # Haalt klantinformatie op en toont deze
│   ├── update_klant.php      # Stelt in staat om bestaande klantinformatie bij te werken
│   └── delete_klant.php      # Behandelt het verwijderen van een klantrecord
├── bedrijf
│   ├── create_bedrijf.php    # Behandelt het aanmaken van een nieuw bedrijf
│   ├── read_bedrijf.php      # Haalt bedrijfsinformatie op en toont deze
│   ├── update_bedrijf.php    # Stelt in staat om bestaande bedrijfsinformatie bij te werken
│   └── delete_bedrijf.php    # Behandelt het verwijderen van een bedrijfsrecord
├── data
│   └── voorbeeld_database.sql # Voorbeelddatabase voor het project
└── README.md                 # Documentatie voor het project
```

## Databaseverbinding
De ontwikkelapplicatie maakt verbinding met een MySQL-database genaamd `villaklant` met de volgende inloggegevens:
- **Gebruiker:** albert
- **Wachtwoord:** ab
Dit moet natuurlijk bij de live versie worden aangepast.

Zorg ervoor dat de database correct is ingesteld met de benodigde tabellen (`bedrijven` en `klanten`) voordat je de applicatie uitvoert.

## Gebruik
1. **Klant aanmaken:** Gebruik `create_klant.php` om nieuwe klantrecords toe te voegen.
2. **Klantinformatie lezen:** Gebruik `read_klant.php` om bestaande klantgegevens te bekijken.
3. **Klantinformatie bijwerken:** Gebruik `update_klant.php` om klantrecords te wijzigen.
4. **Klant verwijderen:** Gebruik `delete_klant.php` om klantrecords uit de database te verwijderen.
5. **Bedrijf aanmaken:** Gebruik `create_bedrijf.php` om nieuwe bedrijfsrecords toe te voegen.
6. **Bedrijfsinformatie lezen:** Gebruik `read_bedrijf.php` om bestaande bedrijfsgegevens te bekijken.
7. **Bedrijfsinformatie bijwerken:** Gebruik `update_bedrijf.php` om bedrijfsrecords te wijzigen.
8. **Bedrijf verwijderen:** Gebruik `delete_bedrijf.php` om bedrijfsrecords uit de database te verwijderen.

## Installatie-instructies
1. Clone de repository naar je lokale machine.
2. Stel de MySQL-database in en maak de vereiste tabellen aan zoals gespecificeerd in het project.
3. Werk het `config/db_connect.php` bestand bij met je database-inloggegevens als deze afwijken van de standaardwaarden.
4. Importeer de voorbeelddatabase uit de `data/voorbeeld_database.sql` om snel aan de slag te gaan.
5. Toegang tot de applicatie via een webserver die PHP ondersteunt.

## Bijdragen
Bijdragen aan het VillaKlant-project zijn welkom. Dien een pull request in of open een issue voor eventuele verbeteringen of bugfixes.

## Licentie
Dit project is open-source en beschikbaar onder de MIT-licentie.