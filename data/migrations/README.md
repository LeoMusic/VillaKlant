# Database Migrations

Deze folder bevat database migratie-scripts voor VillaKlant CRM.

## Volgorde van uitvoering

Voer migraties altijd uit in numerieke volgorde:

1. `001_add_status_columns.sql` - Voegt status kolommen toe aan bedrijven en klanten

## Hoe een migratie uitvoeren

### Lokaal (XAMPP):

```bash
# 1. Maak eerst een backup
cd c:\xampp\mysql\bin
.\mysqldump.exe -u root villaproct_klanten > c:\xampp\htdocs\VillaKlant\data\backup_before_migration.sql

# 2. Voer migratie uit
.\mysql.exe -u root villaproct_klanten < c:\xampp\htdocs\VillaKlant\data\migrations\001_add_status_columns.sql
```

### Live server:

```bash
# 1. Maak eerst een backup
mysqldump -u [username] -p villaproct_klanten > backup_before_migration.sql

# 2. Voer migratie uit
mysql -u [username] -p villaproct_klanten < 001_add_status_columns.sql
```

## Verificatie

Na elke migratie, controleer:

```sql
-- Controleer kolommen
SHOW COLUMNS FROM bedrijven LIKE 'status';
SHOW COLUMNS FROM klanten LIKE 'status';

-- Controleer data
SELECT status, COUNT(*) as count FROM bedrijven GROUP BY status;
SELECT status, COUNT(*) as count FROM klanten GROUP BY status;
```

## Rollback

Elke migratie bevat rollback instructies onderaan het bestand. Gebruik deze alleen als backup beschikbaar is!

## Best Practices

1. **Altijd een backup maken** voor je een migratie uitvoert
2. **Test eerst lokaal** voordat je live gaat
3. **Verifieer de resultaten** na elke migratie
4. **Bewaar backups** voor minimaal 30 dagen
5. **Documenteer problemen** in PROJECT_STATUS.md
