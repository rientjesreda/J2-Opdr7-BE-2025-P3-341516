# BE Opdracht 7

PHP MVC-app voor de user story **Wijzigen voertuiggegevens** uit backend opdracht 7.

## Techniek

- PHP 8.3
- MVC-structuur
- OOP
- PDO
- MySQL stored procedure
- PHPUnit

## Installatie

1. Kopieer `.env.example` naar `.env` als je met environment variables werkt.
2. Maak de database aan met `database/create_database.sql`.
3. Maak daarna de stored procedure aan met `database/stored_procedure.sql`.
4. Installeer dependencies met `composer install`.
5. Start de app lokaal, bijvoorbeeld:

```powershell
php -S localhost:8000 -t public
```

6. Open daarna `http://localhost:8000/instructors`.

## Scenarios

- Scenario 01: bestaand voertuig wijzigen
- Scenario 02: bestaand voertuig aan andere instructeur koppelen
- Scenario 03: beschikbaar voertuig wijzigen en toewijzen
- Scenario 04: bouwjaar blijft readonly en kan niet gewijzigd worden

## Tests

```powershell
composer test
```
