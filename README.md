# VillaKlant Project 🏢

## Overzicht
**VillaKlant** is een geavanceerd web-gebaseerd klantbeheersysteem (CRM) ontwikkeld voor Villa ProCtrl en Leo Music & Audio. Het systeem biedt een moderne, Google-achtige interface voor het efficiënt beheren van klant- en bedrijfsinformatie met geavanceerde zoek- en relatiefunctionaliteiten, inclusief Google Maps integratie, intelligente formulieren en favicon ondersteuning.

## 🎯 Kernfunctionaliteiten

### **🔍 Moderne Relatie Zoekinterface**
- **Google-stijl hoofdpagina** met professionele zoekfunctionaliteit
- **3-block template layout** voor consistente weergave:
  - 🏢 **Bedrijf-blok** (4/5): Bedrijfsinformatie met website favicons
  - 👥 **Collega-blok** (1/5): Werknemers lijst
  - 📋 **Relatie-blok** (4/5): Persoon details in 2-kolom layout
- **4 Intelligente zoeksituaties**:
  - Unieke persoon zoeken → Template met bedrijfscontext
  - Uniek bedrijf zoeken → Bedrijfsfocus met alle werknemers
  - Meerdere resultaten → Google-stijl lijst met favicons
  - Geen resultaten → Aanmaakopties voor nieuwe entiteiten

### **📊 Volledig CRUD Systeem**
- **Klantenbeheer**: Complete lifecycle met intelligente formulieren
- **Bedrijvenbeheer**: Uitgebreide administratie (website, telefoon, notities)
- **Relatiebeheer**: Koppeling tussen klanten, bedrijven en functies
- **Zoekfunctionaliteit**: Multi-field search met type-ahead suggesties
- **FormHelpers Systeem**: Gestandaardiseerde formulieren met verplichte veld indicaties

### **🌍 Geografische Functionaliteiten**
- **"Wie Wat Waar"** met Google Maps API integratie
- **Automatische geocoding** van bedrijfsadressen
- **Interactieve markers** met bedrijfsinformatie en directe navigatie
- **Google API key configuratie** voor volledige functionaliteit

### **🎨 Intelligente User Interface**
- **Type-ahead zoeken** voor bedrijfsselectie in formulieren
- **Favicon ondersteuning** voor website links (Google Favicon API)
- **Alfabetische sortering** in alle dropdown lijsten
- **Responsive 2-kolom layout** voor optimale ruimtebenutting
- **Verplichte veld indicaties** met visuele feedback (rode asterisk)

### **📱 Modern Design**
- **Responsive Bootstrap 4.5.2** interface
- **Cross-device compatibility**
- **Professional UI/UX** met intuïtieve navigatie
- **Nederlandse lokalisatie**

## 📁 Projectstructuur

```
villaklant/
├── 🏠 index.php                 # Moderne Google-stijl hoofdpagina
├── ⚙️ config/
│   ├── db_connect.php          # Database verbinding
│   ├── phone_number_formatter.php # Nederlandse telefoonnummer formatting
│   └── form_helpers.php        # FormHelpers klasse (nieuw systeem) ✨
├── 📦 includes/
│   ├── header.php              # Navigatie header
│   └── footer.php              # Footer met scripts
├── 👥 klanten/
│   ├── create_klant.php        # Klant aanmaken (type-ahead bedrijf zoeken) ✨
│   ├── read_klant.php          # Klanten overzicht
│   ├── update_klant.php        # Klant bewerken (FormHelpers systeem) ✨
│   ├── delete_klant.php        # Klant verwijderen
│   ├── search_klant.php        # Klant zoeken
│   └── task.php                # Taak beheer
├── 🏢 bedrijf/
│   ├── create_bedrijf.php      # Bedrijf aanmaken (FormHelpers + verplichte velden)
│   ├── read_bedrijf.php        # Bedrijven overzicht (alfabetisch gesorteerd)
│   ├── update_bedrijf.php      # Bedrijf bewerken (uitgebreide velden)
│   ├── delete_bedrijf.php      # Bedrijf verwijderen
│   ├── search_bedrijf.php      # Bedrijf zoeken
│   └── wie_wat_waar.php        # Google Maps integratie ✨ NIEUW
├── 🔗 relatie/                  ✨ NIEUWE GEAVANCEERDE INTERFACE
│   ├── index.php               # Google-stijl zoekpagina
│   └── search_results.php      # 3-block template resultaten
├── 🎨 CSS/
│   └── style.css               # Custom styling
└── 💾 data/
    ├── villaklant.sql          # Database schema (basis)
    ├── uitbreiding_bedrijven_extra_velden.sql # Schema uitbreidingen ✨
    └── villaproct_klanten.sql  # Sample data
```

## 🛠️ Technische Stack

### **Backend**
- **PHP** (Procedureel) met prepared statements
- **MySQL/MariaDB** database met uitgebreide schema
- **UTF-8MB4** charset support
- **Foreign key constraints** voor data integriteit
- **FormHelpers klasse** voor gestandaardiseerde formulieren
- **PhoneNumberFormatter** voor Nederlandse nummers

### **Frontend**
- **HTML5** met moderne semantiek
- **Bootstrap 4.5.2** responsive framework
- **JavaScript** voor interactiviteit en type-ahead zoeken
- **Google Maps API** voor locatie services
- **Google Favicon API** voor website iconen
- **CSS Grid/Flexbox** voor moderne layouts

### **Beveiliging**
- **Prepared statements** tegen SQL injection
- **XSS preventie** met htmlspecialchars
- **SECURE constante** voor direct access protection
- **Input validatie** op server-side

## 🚀 Installatie-instructies

### **1. Vereisten**
- **XAMPP/WAMP** of vergelijkbare lokale server
- **PHP 7.4+** 
- **MySQL 5.7+** of MariaDB
- **Moderne webbrowser**

### **2. Database Setup**
```sql
-- Importeer database schema
mysql -u root -p < data/villaklant.sql

-- Importeer schema uitbreidingen (nieuw vanaf 26 oktober)
mysql -u root -p villaklant < data/uitbreiding_bedrijven_extra_velden.sql

-- Importeer sample data (optioneel)
mysql -u root -p villaklant < data/villaproct_klanten.sql
```

### **3. Configuratie**
```php
// config/db_connect.php aanpassen indien nodig
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villaklant";
```

### **4. Google API Setup (voor volledige functionaliteit)**
```php
// bedrijf/wie_wat_waar.php - Google Maps API key al geconfigureerd
// Voor productie: vervang door eigen API key met Maps JavaScript API en Geocoding API
$googleMapsApiKey = "AIzaSyAxySiOV-nRnFVhYnV0lpurdCRq3DsNxgw";
```

### **5. Toegang**
- **Hoofdpagina**: `http://localhost/VillaKlant/`
- **Relatie Interface**: `http://localhost/VillaKlant/relatie/`
- **Google Maps**: `http://localhost/VillaKlant/bedrijf/wie_wat_waar.php`
- **CRUD Modules**: Via navigatie menu
- **Bestaande functionaliteiten**: Volledig toegankelijk

## 📋 Database Schema

### **Hoofdtabellen**
- **`klanten`**: Persoonlijke informatie, contactgegevens, functies, notities
- **`bedrijven`**: Bedrijfsinformatie, adressen, website, telefoonnummer, notities ✨
- **`functies`**: Functieomschrijvingen en rollen (alfabetisch gesorteerd) ✨

### **Nieuwe Velden (vanaf 26 oktober 2025)**
- **`bedrijven.website`**: URL veld met favicon ondersteuning
- **`bedrijven.telefoonnummer`**: Nederlandse telefoonnummer formatting
- **`bedrijven.notities`**: Tekstveld voor bedrijfsspecifieke opmerkingen

### **Sample Data**
- **98 werknemers** verspreid over verschillende bedrijven
- **30+ bedrijven** uit verschillende sectoren
- **Realistische data** voor testing en demonstratie

## 🎯 Gebruiksscenario's

### **1. Zoeken naar een persoon**
```
Hoofdpagina → Zoek "Linda" → Template met bedrijf + favicon + notities (2-kolom)
```

### **2. Functie-gebaseerd zoeken**
```
Hoofdpagina → Zoek "Inkoop" → Multiple results met favicons → Klik persoon → Template
```

### **3. Bedrijf exploratie**
```
Hoofdpagina → Zoek "Sustainable Foods" → Bedrijf template + website + alle werknemers
```

### **4. Google Maps functionaliteit**
```
Menu → Wie Wat Waar → Interactieve kaart met alle bedrijven
```

### **5. Nieuwe formulier ervaring**
```
Klant toevoegen → Type-ahead bedrijf zoeken + verplichte veld indicaties
```

### **4. Geen resultaten**
```
Hoofdpagina → Zoek "xyz123" → Aanmaakopties voor bedrijf/werknemer
```

## 🔄 Recent Voltooide Updates (Oktober 2025)

### **✅ Relatie Interface** (20 oktober)
- Google-stijl zoekpagina geïmplementeerd
- 3-block template layout ontwikkeld
- 4 intelligente zoeksituaties geïmplementeerd

### **✅ Template Consistency** (22 oktober)  
- Template display issues opgelost
- Bedrijf selectie logica geoptimaliseerd
- Consistente weergave voor alle scenario's

### **✅ Moderne Hoofdpagina** (22 oktober)
- Professional landing page geïmplementeerd
- Seamless integratie met relatie functionaliteiten
- Enhanced user experience

## 🎨 Design Principes

### **User Experience**
- **Google-inspired** interface design
- **Intuïtieve navigatie** met duidelijke feedback
- **Responsive design** voor alle apparaten
- **Nederlandse lokalisatie** voor gebruiksvriendelijkheid

### **Performance**
- **Efficient database queries** met prepared statements en alfabetische indexering
- **Type-ahead zoeken** met client-side filtering voor snelle response
- **Favicon caching** via Google API voor betere laadtijden
- **Optimized 2-kolom layout** voor maximale schermbenutting
- **Fast search results** door verbeterde database queries

## 🔐 Beveiliging

### **Data Protection**
- **SQL Injection preventie** via prepared statements (alle CRUD operaties)
- **XSS bescherming** met htmlspecialchars escaping (FormHelpers automatisch)
- **Input validatie** op alle formulieren met visuele feedback
- **Secure file access** via SECURE constante
- **Google API security** met domain restrictions (productie aanbeveling)

### **Development vs Production**
- **Development credentials** in code (te wijzigen voor productie)
- **Error reporting** aangepast per omgeving
- **Database backup** procedures geïmplementeerd

## 🤝 Bijdragen

### **Development Workflow**
- **Een probleem tegelijk** benadering
- **Grondig testen** voor elke feature
- **Nederlandse documentatie** onderhouden
- **Backwards compatibility** respecteren

### **Code Standards**
- **Procedureel PHP** (consistent met bestaande code)
- **Bootstrap responsive** design patterns
- **Nederlandse comments** en variabele namen
- **Security-first** development praktijken

## 📊 Project Status: VOLLEDIG FUNCTIONEEL ✅

**VillaKlant** is nu een **volledig uitgeruste** en **productie-klare** applicatie met:
- ✅ **Complete CRUD functionaliteit** met FormHelpers systeem
- ✅ **Moderne relatie zoekinterface** met favicon ondersteuning
- ✅ **Consistente 3-block templates** met 2-kolom layout optimalisatie
- ✅ **Professional hoofdpagina** Google-stijl design
- ✅ **Google Maps integratie** voor geografische functies
- ✅ **Type-ahead zoeken** voor verbeterde gebruikerservaring
- ✅ **Verplichte veld indicaties** met visuele feedback
- ✅ **Alfabetische sortering** in alle lijsten en formulieren
- ✅ **Robuuste beveiliging** met prepared statements
- ✅ **Responsive design** voor alle apparaten

Het systeem biedt nu premium CRM functionaliteiten en is volledig gereed voor professioneel gebruik door Villa ProCtrl en Leo Music & Audio! 🎯

## 🚀 **Nieuwste Features (26-27 oktober 2025)**

### **📋 Gestandaardiseerde Formulieren**
- **FormHelpers klasse** voor consistente formulier elementen
- **Verplichte veld indicaties** met rode asterisk (*) 
- **Automatische XSS beveiliging** in alle input/output
- **Bootstrap responsive styling** geïntegreerd

### **🏢 Uitgebreide Bedrijfsinformatie**
- **Website veld** met automatische favicon weergave
- **Telefoonnummer** met Nederlandse formatting
- **Notities veld** voor bedrijfsspecifieke opmerkingen
- **Geoptimaliseerde 2-kolom layout** voor betere ruimtebenutting

### **🔍 Intelligente Zoekfuncties**
- **Type-ahead bedrijf zoeken** in klant formulieren
- **Live filtering** met dropdown resultaten
- **Alfabetische sortering** in alle selectielijsten
- **Favicon ondersteuning** in zoekresultaten

### **🗺️ Google Maps Integratie**
- **"Wie Wat Waar"** functionaliteit geïmplementeerd
- **Automatische geocoding** van bedrijfsadressen
- **Interactieve markers** met bedrijfsinformatie
- **Google API configuratie** voor volledige functionaliteit

## 📝 Licentie
Dit project is ontwikkeld voor Villa ProCtrl en Leo Music & Audio. Alle rechten voorbehouden.

---
*Laatst bijgewerkt: 27 oktober 2025*  
*Status: Volledig uitgerust met premium CRM functionaliteiten* ✅  
*Status: Productie-klaar* ✅