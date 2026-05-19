# Testplan

| Test ID | Scenario | Stap | Verwacht resultaat |
| --- | --- | --- | --- |
| TP-01 | Scenario 01 | Open Mohammed El Yassidi en wijzig `Vespa` naar `Vespa Piaggio`, brandstof `Elektrisch`, kenteken `DRS-52-E` | Overzicht toont gewijzigde waarden |
| TP-02 | Scenario 02 | Wijzig instructeur van `Vespa Piaggio` naar `Bert van Sali` | Voertuig verdwijnt uit Mohammed-overzicht |
| TP-03 | Scenario 03 | Open beschikbare voertuigen, wijzig `Kymco` brandstof naar `Elektrisch` en wijs toe aan Mohammed | Kymco verschijnt in Mohammed-overzicht met nieuwe brandstof |
| TP-04 | Scenario 04 | Open `DAF`, probeer bouwjaar te wijzigen en sla op | Bouwjaar blijft ongewijzigd |
| TP-05 | Validatie | Dien leeg of ongeldig kenteken in | Foutmelding zichtbaar, geen update opgeslagen |
| TP-06 | Pagination | Maak meer dan 4 resultaten zichtbaar | Overzicht toont rustig pagineren per 4 records |
