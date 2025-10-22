# Werkafspraken tussen AI-Agent en Ontwikkelaar
*VillaKlant Project - Klantbeheersysteem*

## Projectanalyse en Doel

**VillaKlant** is een web-gebaseerd klantbeheersysteem (CRM) ontwikkeld in PHP met MySQL database. Het systeem is ontworpen voor het efficiënt beheren van klant- en bedrijfsinformatie door Villa ProCtrl en Leo Music & Audio.

### Kernfunctionaliteiten:
- **Klantenbeheer**: CRUD operaties voor klanten (voornaam, achternaam, telefoonnummers, email, functie, bedrijf, notities)
- **Bedrijvenbeheer**: CRUD operaties voor bedrijven (naam, adres, facturemail)
- **Zoekfunctionaliteit**: Geavanceerd zoeken in klanten en bedrijven
- **Geografische weergave**: "Wie Wat Waar" functie met Google Maps integratie
- **Telefoonummer formatting**: Automatische opmaak van Nederlandse telefoonnummers
- **Relatiebeheer**: Koppeling tussen klanten, bedrijven en functies via foreign keys
- **Relatie Zoekinterface**: Google-stijl zoekpagina met geavanceerde resultaatweergave

### Technische Stack:
- **Frontend**: HTML5, Bootstrap 4.5.2, JavaScript, Google Maps API
- **Backend**: PHP (procedureel), MySQL/MariaDB
- **Database**: 3 hoofdtabellen (klanten, bedrijven, functies) met referentiële integriteit
- **Beveiliging**: SECURE constante voor direct access protection, prepared statements

## Werkafspraken AI-Agent

### 1. Code Stijl en Standaarden
- **Taal**: Nederlandse comments en variabele namen (consistent met bestaande code)
- **PHP Stijl**: Procedureel PHP (geen OOP tenzij expliciet gevraagd)
- **Beveiliging**: Altijd prepared statements gebruiken, XSS preventie met htmlspecialchars
- **Error Handling**: Consistent error reporting zoals in bestaande code
- **Database**: UTF-8MB4 charset, foreign key constraints respecteren

### 2. Architectuur Principes
- **MVC Pattern**: Simpele scheiding: config/, includes/, en module mappen
- **DRY Principe**: Herbruikbare componenten in includes/ en config/
- **Consistency**: Volg bestaande naming conventions en file structuur
- **Security First**: SECURE define check in alle hoofdbestanden
- **Responsive Design**: Bootstrap gebruiken voor consistente UI

### 3. Database Richtlijnen
- **Referentiële Integriteit**: Foreign keys altijd respecteren
- **Placeholder Records**: ID 1 voor "onbekend" records behouden
- **Data Validatie**: Server-side validatie voor alle inputs
- **Backup Awareness**: Geen destructieve operaties zonder bevestiging

### 4. User Experience Prioriteiten
- **Gebruiksvriendelijkheid**: Intuïtieve formulieren met duidelijke labels
- **Feedback**: Success/error meldingen voor alle acties
- **Navigation**: Consistente navigatie via header.php
- **Data Entry**: Prikbord functionaliteit behouden voor tijdelijke data
- **Mobile Ready**: Bootstrap responsive design

### 5. Specifieke Functionaliteiten
- **Telefoonnummer Formatting**: PhoneNumberFormatter class gebruiken
- **Google Maps**: Wie Wat Waar functionaliteit uitbreiden waar mogelijk
- **Search Functionality**: Multi-field search capabilities
- **CRUD Operations**: Complete Create, Read, Update, Delete voor alle entities
- **Data Relations**: Maintain relationships tussen klanten, bedrijven, functies

### 6. Development Workflow
- **Testing**: Altijd testen in XAMPP omgeving
- **Documentation**: Nederlandse documentatie en comments
- **Version Control**: Git-vriendelijke changes, geen grote refactors
- **Backwards Compatibility**: Bestaande data structuur respecteren
- **Performance**: Efficient database queries, minimize API calls

### 7. Communicatie Afspraken
- **Vragen**: Altijd verduidelijking vragen bij onduidelijke requirements
- **Alternatieven**: Suggesties doen voor verbeteringen waar relevant
- **Status Updates**: Duidelijke communicatie over voortgang en problemen
- **Code Review**: Uitleg geven bij complexere wijzigingen
- **Best Practices**: Adviseren over security en performance waar nodig

### 8. Speciale Aandachtspunten
- **Google Maps API**: Key management en error handling
- **Database Credentials**: Development vs production settings
- **File Permissions**: XAMPP specifieke configuratie
- **Cross-browser**: IE/Edge compatibility waar mogelijk
- **Data Migration**: Voorzichtigheid bij schema wijzigingen

### 9. Verboden Acties
- **Geen**: Destructieve database operaties zonder expliciete toestemming
- **Geen**: Wijzigingen aan core security implementaties zonder overleg
- **Geen**: Grote architecturale wijzigingen zonder discussie
- **Geen**: Verwijderen van bestaande functionaliteit zonder vervanging
- **Geen**: Hardcoded credentials in production code

### 10. Prioriteiten Volgorde
1. **Functionaliteit**: Feature completeness
2. **Beveiliging**: Data protection en input validation
3. **Gebruiksvriendelijkheid**: Intuitive interface
4. **Performance**: Efficient database operations
5. **Maintainability**: Clean, documented code
6. **Extensibility**: Future-proof architecture

### 11. Werkstroom Afspraak ✅ **NIEUW** (21 oktober 2025)
- **Eén probleem tegelijk**: We werken aan maximaal 1 specifiek probleem per sessie
- **Focus**: Volledige afronding voordat we naar het volgende probleem gaan
- **Kwaliteit**: Grondig testen en valideren van elke oplossing
- **Communicatie**: Duidelijke probleemstelling voordat we beginnen

---

## Huidige Status ✅ OKTOBER 2025
- **Database**: Volledig geïmplementeerd met sample data + 30 extra bedrijven en 98 werknemers
- **Core CRUD**: Volledig functioneel voor klanten en bedrijven
- **Search**: Geïmplementeerd voor beide entiteiten
- **Maps Integration**: Basis functionaliteit aanwezig
- **UI/UX**: Bootstrap responsive design
- **Security**: Prepared statements en XSS preventie
- **Relatie Interface**: ✅ VOLTOOID - Google-stijl zoekpagina met 3-block template layout
- **Template Consistency**: ✅ VOLTOOID - Alle 4 situaties werken correct
- **Hoofdpagina**: ✅ VOLTOOID - Moderne landing page met directe zoekfunctionaliteit

## Volgende Stappen Suggesties
1. Export/import mogelijkheden
2. Backup en restore functionaliteit
3. User management systeem
4. Rapportage modules
5. API endpoints voor externe systemen

## Recent Voltooide Projecten

### 1. Relatie Gebruikersinterface ✅ VOLTOOID (20 oktober 2025)
**Locatie**: `/relatie/` map
**Bestanden**:
- `index.php` - Google-stijl zoekpagina
- `search_results.php` - Geavanceerde resultaatweergave

**Functionaliteiten**:
- **Google-achtig design**: Minimalistisch beginscherm met alleen zoekbalk
- **3-block template layout**: Consistente weergave voor alle situaties
  - **🏢 Bedrijf-blok** (4/5 breedte): Bedrijfsinformatie
  - **👥 Collega-blok** (1/5 breedte): Werknemers lijst  
  - **📋 Relatie-blok** (4/5 breedte): Persoon details
- **4 Situaties**: Alle correct geïmplementeerd en getest
- **Smart filtering**: Gevonden werknemers logica per situatie
- **Multi-search**: Zoekt in bedrijven EN werknemers
- **Responsive design**: Werkt op alle apparaten
- **Interactieve details**: Click-to-show werknemer informatie

### 2. Template Display Issues Fix ✅ VOLTOOID (22 oktober 2025)
**Probleem**: Template werd niet getoond voor naam zoeken en bedrijf klikken
**Oplossing**: 
- **$selected_bedrijf logica**: Verplaatst buiten conditionele blokken
- **Situatie detectie**: Verbeterde fallback logica
- **Scope problemen**: Bedrijf selectie nu altijd uitgevoerd

**Resultaat**: Consistente 3-block template voor alle navigatie scenario's

### 3. Moderne Hoofdpagina ✅ VOLTOOID (22 oktober 2025)
**Locatie**: Root `/index.php`
**Verbetering**: Oude simpele lijst vervangen door moderne interface

**Functionaliteiten**:
- **Google-inspired design**: Professional landing page
- **Directe zoekfunctionaliteit**: Linkt naar relatie search_results.php
- **Quick actions**: Snelle toegang tot hoofdfuncties
- **Responsive interface**: Werkt op alle apparaten
- **Suggestie systeem**: Interactieve search suggestions

**Technische implementatie**:
- Prepared statements voor veilige database queries
- JavaScript voor dynamische interacties
- Bootstrap grid systeem voor layout
- Telefoonummer formatting per land
- XSS preventie met htmlspecialchars

## Uitbouwen fuctionaliteit na testen ✅ VOLTOOID (22 oktober 2025)
**✅ ALLE PROBLEMEN OPGELOST**: Template consistency en moderne interface

### **✅ Template Consistency - GETEST EN WERKEND**
**Situatie 1** - Naam zoeken (unique_person):
- **3-block layout**: Bedrijf-blok + Collega-blok + Relatie-blok
- **Automatische weergave**: Gevonden persoon details direct getoond
- **URL navigatie**: Direct naar klant via `?klant_id=X`

**Situatie 2** - Bedrijf zoeken (unique_company):
- **3-block layout**: Bedrijf-blok + Collega-blok + Relatie-blok
- **Werknemer selectie**: Click-to-show interface voor collega details
- **URL navigatie**: Direct naar bedrijf via `?bedrijf_id=X`

**Situatie 3** - Multiple results:
- **Google-stijl lijst**: Overzichtelijke presentatie van alle resultaten
- **Klikbare resultaten**: Navigeren naar situatie 1 of 2 templates
- **Categorieën**: Gescheiden weergave bedrijven vs werknemers

**Situatie 4** - No results:
- **Aanmaakopties**: Directe links naar create formulieren
- **Gebruiksvriendelijk**: Duidelijke call-to-action bij geen resultaten

### **✅ Hoofdpagina Modernisering - GETEST EN WERKEND**
- **Professional interface**: Google-achtige landing page
- **Seamless integration**: Directe verbinding met relatie zoekfunctionaliteit
- **Enhanced UX**: Moderne uitstraling met behoud van alle functionaliteit

---

## Status: PROJECT VOLLEDIG FUNCTIONEEL ✅
**VillaKlant** heeft nu een complete, moderne relatie zoek interface met:
- **Consistente 3-block template** voor alle scenario's
- **Professional hoofdpagina** met directe zoekfunctionaliteit  
- **Robuuste situatie detectie** voor alle 4 use cases
- **Seamless navigatie** tussen verschillende zoek flows

Het systeem is **productie-klaar** met een professionele uitstraling! 🎯

---

## Nieuwe Taken
*Wacht op input gebruiker voor volgende projecten*
We gaan aan 1 probleem gelijktijdig werken.

---
*Document aangemaakt: 19 oktober 2025*  
*Laatst bijgewerkt door: AI Agent - 22 oktober 2025 (Template consistency en moderne hoofdpagina voltooid)*