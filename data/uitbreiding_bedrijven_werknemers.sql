-- VillaKlant Database Uitbreiding
-- 30 nieuwe bedrijven met werknemers en 15 nieuwe functies
-- Aangemaakt: 19 oktober 2025

-- Eerst nieuwe functies toevoegen
INSERT INTO `functies` (`functienaam`) VALUES
('Marketing Manager'),
('Sales Representative'),
('IT Specialist'),
('HR Adviseur'),
('Financieel Controller'),
('Project Manager'),
('Operations Manager'),
('Customer Service Manager'),
('Inkoop Manager'),
('Quality Assurance Manager'),
('Business Analyst'),
('Account Manager'),
('Logistiek Coördinator'),
('Training Specialist'),
('Facility Manager');

-- Nieuwe bedrijven toevoegen
INSERT INTO `bedrijven` (`bedrijfsnaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `land`, `email_facturen`) VALUES
('TechFlow Solutions', 'Innovatielaan', '15', '1234 AB', 'Amsterdam', 'Nederland', 'finance@techflow.nl'),
('Green Energy Partners', 'Windmolenweg', '42', '9876 CD', 'Groningen', 'Nederland', 'billing@greenenergy.nl'),
('DataSync Analytics', 'Computerstraat', '8', '5678 EF', 'Eindhoven', 'Nederland', 'accounts@datasync.nl'),
('Royal Hospitality Group', 'Hotelplein', '1', '2345 GH', 'Utrecht', 'Nederland', 'invoices@royalhospitality.nl'),
('Maritime Logistics BV', 'Havenweg', '88', '3456 IJ', 'Rotterdam', 'Nederland', 'finance@maritime.nl'),
('Creative Design Studio', 'Kunstlaan', '22', '4567 KL', 'Den Haag', 'Nederland', 'billing@creative.nl'),
('MedTech Innovations', 'Gezondheidsweg', '5', '6789 MN', 'Maastricht', 'Nederland', 'accounts@medtech.nl'),
('Sustainable Foods Co', 'Biologischelaan', '33', '7890 OP', 'Wageningen', 'Nederland', 'invoices@sustainable.nl'),
('Smart Building Systems', 'Techniekstraat', '67', '8901 QR', 'Delft', 'Nederland', 'finance@smartbuilding.nl'),
('Financial Consulting Pro', 'Bankiersweg', '14', '9012 ST', 'Amsterdam', 'Nederland', 'billing@finconsult.nl'),
('Industrial Automation GmbH', 'Industriestraße', '45', '12345', 'München', 'Duitsland', 'rechnung@automation.de'),
('Nordic Timber AB', 'Skogsvägen', '78', '11122', 'Stockholm', 'Zweden', 'faktura@nordictimber.se'),
('Belgian Chocolate Masters', 'Chocoladestraat', '12', '1000', 'Brussel', 'België', 'factuur@chocolate.be'),
('French Wine Distributors', 'Rue du Vin', '56', '75001', 'Parijs', 'Frankrijk', 'facture@wine.fr'),
('Alpine Sports Equipment', 'Bergstraße', '23', '6020', 'Innsbruck', 'Oostenrijk', 'rechnung@alpine.at'),
('London Tech Ventures', 'Innovation Street', '89', 'SW1A 1AA', 'Londen', 'Verenigd Koninkrijk', 'invoice@londontech.uk'),
('Spanish Solar Solutions', 'Calle del Sol', '34', '28001', 'Madrid', 'Spanje', 'factura@solar.es'),
('Italian Fashion House', 'Via della Moda', '17', '20121', 'Milaan', 'Italië', 'fattura@fashion.it'),
('Swiss Precision Tools', 'Präzisionsweg', '91', '8001', 'Zürich', 'Zwitserland', 'rechnung@precision.ch'),
('Danish Design Studio', 'Designvej', '25', '1050', 'Kopenhagen', 'Denemarken', 'faktura@design.dk'),
('Polish Manufacturing Ltd', 'Przemysłowa', '63', '00-001', 'Warschau', 'Polen', 'faktura@manufacturing.pl'),
('Czech Glass Works', 'Sklenářská', '19', '110 00', 'Praag', 'Tsjechië', 'faktura@glass.cz'),
('Hungarian Engineering', 'Mérnök utca', '41', '1011', 'Boedapest', 'Hongarije', 'szamla@engineering.hu'),
('Romanian Software Dev', 'Strada IT', '27', '010001', 'Boekarest', 'Roemenië', 'factura@software.ro'),
('Bulgarian Logistics Hub', 'Логистична', '52', '1000', 'Sofia', 'Bulgarije', 'invoice@logistics.bg'),
('Croatian Tourism Agency', 'Turistička', '38', '10000', 'Zagreb', 'Kroatië', 'račun@tourism.hr'),
('Estonian Digital Labs', 'Digitaalne', '14', '10111', 'Tallinn', 'Estland', 'arve@digital.ee'),
('Latvian Wood Products', 'Koka iela', '71', '1050', 'Riga', 'Letland', 'rēķins@wood.lv'),
('Lithuanian Bio Research', 'Biologijos', '29', '01001', 'Vilnius', 'Litouwen', 'sąskaita@bioresearch.lt'),
('Finnish Paper Mills', 'Paperitie', '85', '00100', 'Helsinki', 'Finland', 'lasku@paper.fi');

-- Werknemers toevoegen per bedrijf (tussen 2-5 per bedrijf)
-- TechFlow Solutions (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Marieke', 'van der Berg', '0612345678', '020-1234567', 'marieke@techflow.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'TechFlow Solutions'), ''),
('Pieter', 'Jansen', '0623456789', '', 'pieter@techflow.nl', 6, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'TechFlow Solutions'), ''),
('Lisa', 'de Vries', '0634567890', '020-1234568', 'lisa@techflow.nl', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'TechFlow Solutions'), '');

-- Green Energy Partners (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Jan', 'Hendriks', '0645678901', '050-7654321', 'jan@greenenergy.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Green Energy Partners'), ''),
('Emma', 'Bakker', '0656789012', '', 'emma@greenenergy.nl', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Green Energy Partners'), ''),
('Tim', 'Smit', '0667890123', '050-7654322', 'tim@greenenergy.nl', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Green Energy Partners'), ''),
('Sarah', 'de Jong', '0678901234', '', 'sarah@greenenergy.nl', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Green Energy Partners'), '');

-- DataSync Analytics (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Michael', 'van Dijk', '0689012345', '040-9876543', 'michael@datasync.nl', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'DataSync Analytics'), ''),
('Nina', 'Peters', '0690123456', '', 'nina@datasync.nl', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'DataSync Analytics'), '');

-- Royal Hospitality Group (5 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('David', 'Koning', '0601234567', '030-1122334', 'david@royalhospitality.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Royal Hospitality Group'), ''),
('Jessica', 'van Leeuwen', '0612345678', '', 'jessica@royalhospitality.nl', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Royal Hospitality Group'), ''),
('Mark', 'Visser', '0623456789', '030-1122335', 'mark@royalhospitality.nl', 9, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Royal Hospitality Group'), ''),
('Anna', 'de Wit', '0634567890', '', 'anna@royalhospitality.nl', 13, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Royal Hospitality Group'), ''),
('Robert', 'Mulder', '0645678901', '030-1122336', 'robert@royalhospitality.nl', 17, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Royal Hospitality Group'), '');

-- Maritime Logistics BV (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Frank', 'van der Meer', '0656789012', '010-5566778', 'frank@maritime.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Maritime Logistics BV'), ''),
('Ilse', 'Brouwer', '0667890123', '', 'ilse@maritime.nl', 18, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Maritime Logistics BV'), ''),
('Chris', 'van den Heuvel', '0678901234', '010-5566779', 'chris@maritime.nl', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Maritime Logistics BV'), '');

-- Creative Design Studio (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Sophie', 'Arts', '0689012345', '070-9988776', 'sophie@creative.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Creative Design Studio'), ''),
('Tom', 'van der Linden', '0690123456', '', 'tom@creative.nl', 6, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Creative Design Studio'), ''),
('Eva', 'Scholten', '0601234567', '070-9988777', 'eva@creative.nl', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Creative Design Studio'), ''),
('Max', 'de Boer', '0612345678', '', 'max@creative.nl', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Creative Design Studio'), '');

-- MedTech Innovations (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Dr. Elena', 'Richter', '0623456789', '043-3344556', 'elena@medtech.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'MedTech Innovations'), 'Head of Research'),
('Paul', 'van Houten', '0634567890', '', 'paul@medtech.nl', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'MedTech Innovations'), ''),
('Marie', 'Janssen', '0645678901', '043-3344557', 'marie@medtech.nl', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'MedTech Innovations'), '');

-- Sustainable Foods Co (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Johan', 'Groen', '0656789012', '0317-112233', 'johan@sustainable.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Sustainable Foods Co'), ''),
('Linda', 'van der Hof', '0667890123', '', 'linda@sustainable.nl', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Sustainable Foods Co'), '');

-- Smart Building Systems (5 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Engineering', 'Bouwmeester', '0678901234', '015-7788990', 'eng@smartbuilding.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Smart Building Systems'), ''),
('Techniek', 'Installateur', '0689012345', '', 'tech@smartbuilding.nl', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Smart Building Systems'), ''),
('Project', 'Coördinator', '0690123456', '015-7788991', 'project@smartbuilding.nl', 11, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Smart Building Systems'), ''),
('Quality', 'Controleur', '0601234567', '', 'quality@smartbuilding.nl', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Smart Building Systems'), ''),
('Sales', 'Adviseur', '0612345678', '015-7788992', 'sales@smartbuilding.nl', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Smart Building Systems'), '');

-- Financial Consulting Pro (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Richard', 'van der Bank', '0623456789', '020-4455667', 'richard@finconsult.nl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Financial Consulting Pro'), 'Senior Partner'),
('Monique', 'Financier', '0634567890', '', 'monique@finconsult.nl', 10, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Financial Consulting Pro'), ''),
('Alex', 'Controller', '0645678901', '020-4455668', 'alex@finconsult.nl', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Financial Consulting Pro'), '');

-- Industrial Automation GmbH (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Klaus', 'Müller', '+49-176-12345678', '+49-89-12345678', 'klaus@automation.de', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Industrial Automation GmbH'), ''),
('Ingrid', 'Schmidt', '+49-176-23456789', '', 'ingrid@automation.de', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Industrial Automation GmbH'), ''),
('Hans', 'Weber', '+49-176-34567890', '+49-89-12345679', 'hans@automation.de', 11, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Industrial Automation GmbH'), ''),
('Petra', 'Fischer', '+49-176-45678901', '', 'petra@automation.de', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Industrial Automation GmbH'), '');

-- Nordic Timber AB (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Lars', 'Andersson', '+46-70-1234567', '+46-8-1234567', 'lars@nordictimber.se', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Nordic Timber AB'), ''),
('Astrid', 'Johansson', '+46-70-2345678', '', 'astrid@nordictimber.se', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Nordic Timber AB'), '');

-- Belgian Chocolate Masters (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Pierre', 'Dubois', '+32-472-123456', '+32-2-1234567', 'pierre@chocolate.be', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Belgian Chocolate Masters'), ''),
('Marie', 'Leroy', '+32-472-234567', '', 'marie@chocolate.be', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Belgian Chocolate Masters'), ''),
('Luc', 'Martin', '+32-472-345678', '+32-2-1234568', 'luc@chocolate.be', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Belgian Chocolate Masters'), '');

-- French Wine Distributors (5 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Jean', 'Moreau', '+33-6-12345678', '+33-1-12345678', 'jean@wine.fr', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'French Wine Distributors'), ''),
('Sylvie', 'Girard', '+33-6-23456789', '', 'sylvie@wine.fr', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'French Wine Distributors'), ''),
('Michel', 'Roux', '+33-6-34567890', '+33-1-12345679', 'michel@wine.fr', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'French Wine Distributors'), ''),
('Isabelle', 'Bernard', '+33-6-45678901', '', 'isabelle@wine.fr', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'French Wine Distributors'), ''),
('Philippe', 'Durand', '+33-6-56789012', '+33-1-12345680', 'philippe@wine.fr', 18, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'French Wine Distributors'), '');

-- Alpine Sports Equipment (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Wolfgang', 'Steiner', '+43-664-1234567', '+43-512-123456', 'wolfgang@alpine.at', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Alpine Sports Equipment'), ''),
('Brigitte', 'Huber', '+43-664-2345678', '', 'brigitte@alpine.at', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Alpine Sports Equipment'), ''),
('Franz', 'Mayer', '+43-664-3456789', '+43-512-123457', 'franz@alpine.at', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Alpine Sports Equipment'), ''),
('Andrea', 'Bauer', '+43-664-4567890', '', 'andrea@alpine.at', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Alpine Sports Equipment'), '');

-- London Tech Ventures (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('James', 'Smith', '+44-7700-123456', '+44-20-12345678', 'james@londontech.uk', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'London Tech Ventures'), ''),
('Emma', 'Johnson', '+44-7700-234567', '', 'emma@londontech.uk', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'London Tech Ventures'), ''),
('Oliver', 'Brown', '+44-7700-345678', '+44-20-12345679', 'oliver@londontech.uk', 11, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'London Tech Ventures'), '');

-- Spanish Solar Solutions (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Carlos', 'García', '+34-600-123456', '+34-91-1234567', 'carlos@solar.es', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Spanish Solar Solutions'), ''),
('María', 'López', '+34-600-234567', '', 'maria@solar.es', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Spanish Solar Solutions'), '');

-- Italian Fashion House (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Marco', 'Rossi', '+39-333-1234567', '+39-02-12345678', 'marco@fashion.it', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Italian Fashion House'), ''),
('Giulia', 'Bianchi', '+39-333-2345678', '', 'giulia@fashion.it', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Italian Fashion House'), ''),
('Francesco', 'Romano', '+39-333-3456789', '+39-02-12345679', 'francesco@fashion.it', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Italian Fashion House'), ''),
('Chiara', 'Ferrari', '+39-333-4567890', '', 'chiara@fashion.it', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Italian Fashion House'), '');

-- Swiss Precision Tools (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Beat', 'Meier', '+41-79-123-4567', '+41-44-123-4567', 'beat@precision.ch', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Swiss Precision Tools'), ''),
('Ursula', 'Keller', '+41-79-234-5678', '', 'ursula@precision.ch', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Swiss Precision Tools'), ''),
('Thomas', 'Graf', '+41-79-345-6789', '+41-44-123-4568', 'thomas@precision.ch', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Swiss Precision Tools'), '');

-- Danish Design Studio (5 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Erik', 'Hansen', '+45-20-123456', '+45-33-123456', 'erik@design.dk', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Danish Design Studio'), ''),
('Anna', 'Nielsen', '+45-20-234567', '', 'anna@design.dk', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Danish Design Studio'), ''),
('Lars', 'Pedersen', '+45-20-345678', '+45-33-123457', 'lars@design.dk', 6, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Danish Design Studio'), ''),
('Mette', 'Andersen', '+45-20-456789', '', 'mette@design.dk', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Danish Design Studio'), ''),
('Niels', 'Christensen', '+45-20-567890', '+45-33-123458', 'niels@design.dk', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Danish Design Studio'), '');

-- Polish Manufacturing Ltd (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Piotr', 'Kowalski', '+48-600-123456', '+48-22-1234567', 'piotr@manufacturing.pl', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Polish Manufacturing Ltd'), ''),
('Anna', 'Nowak', '+48-600-234567', '', 'anna@manufacturing.pl', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Polish Manufacturing Ltd'), '');

-- Czech Glass Works (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Pavel', 'Novák', '+420-606-123456', '+420-2-12345678', 'pavel@glass.cz', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Czech Glass Works'), ''),
('Eva', 'Svoboda', '+420-606-234567', '', 'eva@glass.cz', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Czech Glass Works'), ''),
('Jan', 'Dvořák', '+420-606-345678', '+420-2-12345679', 'jan@glass.cz', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Czech Glass Works'), '');

-- Hungarian Engineering (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('László', 'Nagy', '+36-30-1234567', '+36-1-1234567', 'laszlo@engineering.hu', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Hungarian Engineering'), ''),
('Zsuzsanna', 'Kiss', '+36-30-2345678', '', 'zsuzsanna@engineering.hu', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Hungarian Engineering'), ''),
('Péter', 'Kovács', '+36-30-3456789', '+36-1-1234568', 'peter@engineering.hu', 11, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Hungarian Engineering'), ''),
('Éva', 'Szabó', '+36-30-4567890', '', 'eva@engineering.hu', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Hungarian Engineering'), '');

-- Romanian Software Dev (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Andrei', 'Popescu', '+40-722-123456', '+40-21-1234567', 'andrei@software.ro', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Romanian Software Dev'), ''),
('Maria', 'Ionescu', '+40-722-234567', '', 'maria@software.ro', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Romanian Software Dev'), ''),
('Alexandru', 'Dumitrescu', '+40-722-345678', '+40-21-1234568', 'alexandru@software.ro', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Romanian Software Dev'), '');

-- Bulgarian Logistics Hub (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Dimitar', 'Petrov', '+359-88-1234567', '+359-2-1234567', 'dimitar@logistics.bg', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Bulgarian Logistics Hub'), ''),
('Elena', 'Ivanova', '+359-88-2345678', '', 'elena@logistics.bg', 18, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Bulgarian Logistics Hub'), '');

-- Croatian Tourism Agency (5 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Marko', 'Horvat', '+385-91-1234567', '+385-1-1234567', 'marko@tourism.hr', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Croatian Tourism Agency'), ''),
('Ana', 'Kovač', '+385-91-2345678', '', 'ana@tourism.hr', 4, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Croatian Tourism Agency'), ''),
('Petar', 'Babić', '+385-91-3456789', '+385-1-1234568', 'petar@tourism.hr', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Croatian Tourism Agency'), ''),
('Maja', 'Novak', '+385-91-4567890', '', 'maja@tourism.hr', 13, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Croatian Tourism Agency'), ''),
('Tomislav', 'Knežević', '+385-91-5678901', '+385-1-1234569', 'tomislav@tourism.hr', 17, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Croatian Tourism Agency'), '');

-- Estonian Digital Labs (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Mart', 'Tamm', '+372-5123-4567', '+372-6123-456', 'mart@digital.ee', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Estonian Digital Labs'), ''),
('Kadri', 'Kask', '+372-5234-5678', '', 'kadri@digital.ee', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Estonian Digital Labs'), ''),
('Toomas', 'Sepp', '+372-5345-6789', '+372-6123-457', 'toomas@digital.ee', 16, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Estonian Digital Labs'), '');

-- Latvian Wood Products (4 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Jānis', 'Bērziņš', '+371-2123-4567', '+371-6712-3456', 'janis@wood.lv', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Latvian Wood Products'), ''),
('Līga', 'Ozoliņa', '+371-2234-5678', '', 'liga@wood.lv', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Latvian Wood Products'), ''),
('Andris', 'Kalniņš', '+371-2345-6789', '+371-6712-3457', 'andris@wood.lv', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Latvian Wood Products'), ''),
('Inese', 'Liepiņa', '+371-2456-7890', '', 'inese@wood.lv', 12, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Latvian Wood Products'), '');

-- Lithuanian Bio Research (2 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Vytautas', 'Kazlauskas', '+370-612-34567', '+370-5-234-5678', 'vytautas@bioresearch.lt', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Lithuanian Bio Research'), ''),
('Rūta', 'Petrauskienė', '+370-623-45678', '', 'ruta@bioresearch.lt', 8, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Lithuanian Bio Research'), '');

-- Finnish Paper Mills (3 werknemers)
INSERT INTO `klanten` (`voornaam`, `achternaam`, `telefoonnummer_mobiel`, `telefoonnummer_vast`, `email`, `functie_id`, `bedrijf_id`, `notities`) VALUES
('Matti', 'Virtanen', '+358-40-1234567', '+358-9-1234567', 'matti@paper.fi', 2, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Finnish Paper Mills'), ''),
('Sanna', 'Korhonen', '+358-40-2345678', '', 'sanna@paper.fi', 7, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Finnish Paper Mills'), ''),
('Jukka', 'Mäkinen', '+358-40-3456789', '+358-9-1234568', 'jukka@paper.fi', 15, (SELECT id FROM bedrijven WHERE bedrijfsnaam = 'Finnish Paper Mills'), '');

-- Einde van het bestand
-- Totaal: 30 bedrijven, 15 nieuwe functies, 98 nieuwe werknemers