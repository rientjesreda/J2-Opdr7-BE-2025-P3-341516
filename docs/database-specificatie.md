# Database Specificatie

## Instructeur

| Veld | Type | Null | Sleutel | Omschrijving |
| --- | --- | --- | --- | --- |
| Id | INT UNSIGNED | Nee | PK | Unieke instructeur |
| Voornaam | VARCHAR(50) | Nee |  | Voornaam |
| Tussenvoegsel | VARCHAR(20) | Ja |  | Tussenvoegsel |
| Achternaam | VARCHAR(50) | Nee |  | Achternaam |
| Mobiel | VARCHAR(20) | Nee |  | Mobiel nummer |
| DatumInDienst | DATE | Nee |  | Startdatum dienstverband |
| AantalSterren | VARCHAR(5) | Nee |  | Sterwaardering als `*` |
| IsActief | BIT | Nee |  | Soft delete vlag |
| Opmerking | VARCHAR(250) | Ja |  | Vrije notitie |
| DatumAangemaakt | DATETIME(6) | Nee |  | Aanmaakmoment |
| DatumGewijzigd | DATETIME(6) | Nee |  | Wijzigmoment |

## TypeVoertuig

| Veld | Type | Null | Sleutel | Omschrijving |
| --- | --- | --- | --- | --- |
| Id | INT UNSIGNED | Nee | PK | Uniek type |
| TypeVoertuig | VARCHAR(50) | Nee |  | Omschrijving voertuigsoort |
| Rijbewijscategorie | VARCHAR(5) | Nee |  | Rijbewijs categorie |
| IsActief | BIT | Nee |  | Soft delete vlag |
| Opmerking | VARCHAR(250) | Ja |  | Vrije notitie |
| DatumAangemaakt | DATETIME(6) | Nee |  | Aanmaakmoment |
| DatumGewijzigd | DATETIME(6) | Nee |  | Wijzigmoment |

## Voertuig

| Veld | Type | Null | Sleutel | Omschrijving |
| --- | --- | --- | --- | --- |
| Id | INT UNSIGNED | Nee | PK | Uniek voertuig |
| Kenteken | VARCHAR(10) | Nee | UQ | Kenteken |
| Type | VARCHAR(50) | Nee |  | Model/type |
| Bouwjaar | DATE | Nee |  | Bouwjaar/registratiedatum |
| Brandstof | VARCHAR(20) | Nee |  | Brandstofsoort |
| TypeVoertuigId | INT UNSIGNED | Nee | FK | Verwijst naar `TypeVoertuig.Id` |
| IsActief | BIT | Nee |  | Soft delete vlag |
| Opmerking | VARCHAR(250) | Ja |  | Vrije notitie |
| DatumAangemaakt | DATETIME(6) | Nee |  | Aanmaakmoment |
| DatumGewijzigd | DATETIME(6) | Nee |  | Wijzigmoment |

## VoertuigInstructeur

| Veld | Type | Null | Sleutel | Omschrijving |
| --- | --- | --- | --- | --- |
| Id | INT UNSIGNED | Nee | PK | Unieke koppeling |
| VoertuigId | INT UNSIGNED | Nee | FK | Verwijst naar `Voertuig.Id` |
| InstructeurId | INT UNSIGNED | Nee | FK | Verwijst naar `Instructeur.Id` |
| DatumToekenning | DATE | Nee |  | Datum van toewijzing |
| IsActief | BIT | Nee | UQ | Actieve koppeling per voertuig |
| Opmerking | VARCHAR(250) | Ja |  | Vrije notitie |
| DatumAangemaakt | DATETIME(6) | Nee |  | Aanmaakmoment |
| DatumGewijzigd | DATETIME(6) | Nee |  | Wijzigmoment |
