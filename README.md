# VillaKlant Project 🏢

## Overzicht
**VillaKlant** is een geavanceerd web-gebaseerd klantbeheersysteem (CRM) ontwikkeld voor Villa ProCtrl en Leo Music & Audio. Het systeem biedt een moderne, Google-achtige interface voor het efficiënt beheren van klant- en bedrijfsinformatie met geavanceerde zoek- en relatiefunctionaliteiten.

## 🎯 Kernfunctionaliteiten

### **🔍 Moderne Relatie Zoekinterface**
- **Google-stijl hoofdpagina** met professionele zoekfunctionaliteit
- **3-block template layout** voor consistente weergave:
  - 🏢 **Bedrijf-blok** (4/5): Bedrijfsinformatie
  - 👥 **Collega-blok** (1/5): Werknemers lijst
  - 📋 **Relatie-blok** (4/5): Persoon details
- **4 Intelligente zoeksituaties**:
  - Unieke persoon zoeken
  - Uniek bedrijf zoeken  
  - Meerdere resultaten
  - Geen resultaten (met aanmaakopties)

### **📊 Volledig CRUD Systeem**
- **Klantenbeheer**: Volledige lifecycle management
- **Bedrijvenbeheer**: Complete administratie
- **Relatiebeheer**: Koppeling tussen klanten, bedrijven en functies
- **Zoekfunctionaliteit**: Multi-field search in alle entiteiten

### **🌍 Geografische Functionaliteiten**
- **"Wie Wat Waar"** met Google Maps integratie
- **Locatie-gebaseerde bedrijfsweergave**
- **Interactieve kaart functionaliteit**

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
│   └── phone_number_formatter.php # Telefoonnummer formatting
├── 📦 includes/
│   ├── header.php              # Navigatie header
│   └── footer.php              # Footer met scripts
├── 👥 klanten/
│   ├── create_klant.php        # Klant aanmaken
│   ├── read_klant.php          # Klanten overzicht
│   ├── update_klant.php        # Klant bewerken
│   ├── delete_klant.php        # Klant verwijderen
│   ├── search_klant.php        # Klant zoeken
│   └── task.php                # Taak beheer
├── 🏢 bedrijf/
│   ├── create_bedrijf.php      # Bedrijf aanmaken
│   ├── read_bedrijf.php        # Bedrijven overzicht
│   ├── update_bedrijf.php      # Bedrijf bewerken
│   ├── delete_bedrijf.php      # Bedrijf verwijderen
│   ├── search_bedrijf.php      # Bedrijf zoeken
│   └── wie_wat_waar.php        # Google Maps integratie
├── 🔗 relatie/                  ✨ NIEUWE GEAVANCEERDE INTERFACE
│   ├── index.php               # Google-stijl zoekpagina
│   └── search_results.php      # 3-block template resultaten
├── 🎨 CSS/
│   └── style.css               # Custom styling
└── 💾 data/
    ├── villaklant.sql          # Database schema
    └── villaproct_klanten.sql  # Sample data
```

## 🛠️ Technische Stack

### **Backend**
- **PHP** (Procedureel) met prepared statements
- **MySQL/MariaDB** database
- **UTF-8MB4** charset support
- **Foreign key constraints** voor data integriteit

### **Frontend**
- **HTML5** met moderne semantiek
- **Bootstrap 4.5.2** responsive framework
- **JavaScript** voor interactiviteit
- **Google Maps API** voor locatie services

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

### **4. Toegang**
- **Hoofdpagina**: `http://localhost/VillaKlant/`
- **Relatie Interface**: `http://localhost/VillaKlant/relatie/`
- **Bestaande modules**: Via navigatie menu

## 📋 Database Schema

### **Hoofdtabellen**
- **`klanten`**: Persoonlijke informatie, contactgegevens, functies
- **`bedrijven`**: Bedrijfsinformatie, adressen, facturatie
- **`functies`**: Functieomschrijvingen en rollen

### **Sample Data**
- **98 werknemers** verspreid over verschillende bedrijven
- **30+ bedrijven** uit verschillende sectoren
- **Realistische data** voor testing en demonstratie

## 🎯 Gebruiksscenario's

### **1. Zoeken naar een persoon**
```
Hoofdpagina → Zoek "Linda" → Template met bedrijf + collega's + details
```

### **2. Functie-gebaseerd zoeken**
```
Hoofdpagina → Zoek "Inkoop" → Multiple results → Klik persoon → Template
```

### **3. Bedrijf exploratie**
```
Hoofdpagina → Zoek "Sustainable Foods" → Bedrijf template met alle werknemers
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
- **Efficient database queries** met prepared statements
- **Minimale API calls** voor Google Maps
- **Optimized rendering** met Bootstrap grid
- **Fast search results** door slimme indexering

## 🔐 Beveiliging

### **Data Protection**
- **SQL Injection preventie** via prepared statements
- **XSS bescherming** met htmlspecialchars escaping
- **Input validatie** op alle formulieren
- **Secure file access** via SECURE constante

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

**VillaKlant** is nu een **productie-klare** applicatie met:
- ✅ **Complete CRUD functionaliteit**
- ✅ **Moderne relatie zoekinterface** 
- ✅ **Consistente 3-block templates**
- ✅ **Professional hoofdpagina**
- ✅ **Robuuste beveiliging**
- ✅ **Responsive design**

Het systeem is gereed voor gebruik door Villa ProCtrl en Leo Music & Audio! 🎯

## 📝 Licentie
Dit project is ontwikkeld voor Villa ProCtrl en Leo Music & Audio. Alle rechten voorbehouden.

---
*Laatst bijgewerkt: 22 oktober 2025*  
*Status: Productie-klaar* ✅