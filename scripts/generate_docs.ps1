$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.IO.Compression.FileSystem

$projectRoot = 'C:\Users\redam\Downloads\Backend\opdracht 7'
$docsRoot = Join-Path $projectRoot 'docs'

$studentName = 'Reda Margai'
$studentNumber = '341516'
$dateText = '19-05-2026'
$projectTitle = 'BE-opdracht 7 - Wijzigen voertuiggegevens'
$developerName = 'Reda Margai'
$className = 'IO-SD-2408A/B'

function New-ParagraphXml {
    param(
        [string] $Text
    )

    $escaped = [System.Security.SecurityElement]::Escape($Text)
    return "<w:p><w:r><w:t xml:space=`"preserve`">$escaped</w:t></w:r></w:p>"
}

function New-TableXml {
    param(
        [string[]] $Headers,
        [object[][]] $Rows
    )

    $grid = ($Headers | ForEach-Object { '<w:gridCol w:w="1800"/>' }) -join ''
    $headerCells = ($Headers | ForEach-Object {
        $escaped = [System.Security.SecurityElement]::Escape($_)
        "<w:tc><w:tcPr><w:tcW w:w=`"1800`" w:type=`"dxa`"/></w:tcPr><w:p><w:r><w:rPr><w:b/></w:rPr><w:t>$escaped</w:t></w:r></w:p></w:tc>"
    }) -join ''

    $rowXml = foreach ($row in $Rows) {
        $cells = foreach ($cell in $row) {
            $escaped = [System.Security.SecurityElement]::Escape([string]$cell)
            "<w:tc><w:tcPr><w:tcW w:w=`"1800`" w:type=`"dxa`"/></w:tcPr><w:p><w:r><w:t xml:space=`"preserve`">$escaped</w:t></w:r></w:p></w:tc>"
        }
        "<w:tr>$($cells -join '')</w:tr>"
    }

    return "<w:tbl><w:tblPr><w:tblBorders><w:top w:val=`"single`" w:sz=`"8`"/><w:left w:val=`"single`" w:sz=`"8`"/><w:bottom w:val=`"single`" w:sz=`"8`"/><w:right w:val=`"single`" w:sz=`"8`"/><w:insideH w:val=`"single`" w:sz=`"8`"/><w:insideV w:val=`"single`" w:sz=`"8`"/></w:tblBorders></w:tblPr><w:tblGrid>$grid</w:tblGrid><w:tr>$headerCells</w:tr>$($rowXml -join '')</w:tbl>"
}

function New-DocumentXml {
    param(
        [string[]] $Paragraphs,
        [string[]] $Tables
    )

    $bodyItems = @()
    foreach ($paragraph in $Paragraphs) {
        $bodyItems += New-ParagraphXml -Text $paragraph
    }
    foreach ($table in $Tables) {
        $bodyItems += $table
        $bodyItems += New-ParagraphXml -Text ''
    }

    $section = '<w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440" w:header="708" w:footer="708" w:gutter="0"/></w:sectPr>'
    return "<?xml version=`"1.0`" encoding=`"UTF-8`" standalone=`"yes`"?><w:document xmlns:wpc=`"http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas`" xmlns:mc=`"http://schemas.openxmlformats.org/markup-compatibility/2006`" xmlns:o=`"urn:schemas-microsoft-com:office:office`" xmlns:r=`"http://schemas.openxmlformats.org/officeDocument/2006/relationships`" xmlns:m=`"http://schemas.openxmlformats.org/officeDocument/2006/math`" xmlns:v=`"urn:schemas-microsoft-com:vml`" xmlns:wp14=`"http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing`" xmlns:wp=`"http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing`" xmlns:w10=`"urn:schemas-microsoft-com:office:word`" xmlns:w=`"http://schemas.openxmlformats.org/wordprocessingml/2006/main`" xmlns:w14=`"http://schemas.microsoft.com/office/word/2010/wordml`" xmlns:wpg=`"http://schemas.microsoft.com/office/word/2010/wordprocessingGroup`" xmlns:wpi=`"http://schemas.microsoft.com/office/word/2010/wordprocessingInk`" xmlns:wne=`"http://schemas.microsoft.com/office/2006/wordml`" xmlns:wps=`"http://schemas.microsoft.com/office/word/2010/wordprocessingShape`" mc:Ignorable=`"w14 wp14`"><w:body>$($bodyItems -join '')$section</w:body></w:document>"
}

function Write-DocxFromTemplate {
    param(
        [string] $SourcePath,
        [string] $TargetPath,
        [string] $DocumentXml
    )

    Copy-Item -LiteralPath $SourcePath -Destination $TargetPath -Force

    $zip = [System.IO.Compression.ZipFile]::Open($TargetPath, 'Update')
    try {
        $entry = $zip.GetEntry('word/document.xml')
        if ($null -ne $entry) {
            $entry.Delete()
        }
        $newEntry = $zip.CreateEntry('word/document.xml')
        $stream = $newEntry.Open()
        $writer = New-Object System.IO.StreamWriter($stream, [System.Text.Encoding]::UTF8)
        $writer.Write($DocumentXml)
        $writer.Dispose()
    }
    finally {
        $zip.Dispose()
    }
}

$databaseParagraphs = @(
    'Database specificatie tabel',
    "Project: $projectTitle",
    "Naam: $studentName",
    "Studentnummer: $studentNumber",
    "Datum: $dateText",
    'Onderstaande tabellen horen bij de gerealiseerde backend-opdracht.'
)

$databaseTables = @(
    (New-TableXml -Headers @('Tabel', 'Kolom naam', 'Datatype', 'Lengte', 'Nullable', 'Opmerking') -Rows @(
        @('Instructeur', 'Id', 'INT UNSIGNED', '', 'Nee', 'PK, AUTO_INCREMENT'),
        @('Instructeur', 'Voornaam', 'VARCHAR', '50', 'Nee', ''),
        @('Instructeur', 'Tussenvoegsel', 'VARCHAR', '20', 'Ja', ''),
        @('Instructeur', 'Achternaam', 'VARCHAR', '50', 'Nee', ''),
        @('Instructeur', 'Mobiel', 'VARCHAR', '20', 'Nee', ''),
        @('Instructeur', 'DatumInDienst', 'DATE', '', 'Nee', ''),
        @('Instructeur', 'AantalSterren', 'VARCHAR', '5', 'Nee', ''),
        @('Instructeur', 'IsActief', 'BIT', '1', 'Nee', 'Systeemveld'),
        @('Instructeur', 'Opmerking', 'VARCHAR', '250', 'Ja', 'Systeemveld'),
        @('Instructeur', 'DatumAangemaakt', 'DATETIME', '6', 'Nee', 'Systeemveld'),
        @('Instructeur', 'DatumGewijzigd', 'DATETIME', '6', 'Nee', 'Systeemveld')
    )),
    (New-TableXml -Headers @('Tabel', 'Kolom naam', 'Datatype', 'Lengte', 'Nullable', 'Opmerking') -Rows @(
        @('TypeVoertuig', 'Id', 'INT UNSIGNED', '', 'Nee', 'PK, AUTO_INCREMENT'),
        @('TypeVoertuig', 'TypeVoertuig', 'VARCHAR', '50', 'Nee', ''),
        @('TypeVoertuig', 'Rijbewijscategorie', 'VARCHAR', '5', 'Nee', ''),
        @('TypeVoertuig', 'IsActief', 'BIT', '1', 'Nee', 'Systeemveld'),
        @('TypeVoertuig', 'Opmerking', 'VARCHAR', '250', 'Ja', 'Systeemveld'),
        @('TypeVoertuig', 'DatumAangemaakt', 'DATETIME', '6', 'Nee', 'Systeemveld'),
        @('TypeVoertuig', 'DatumGewijzigd', 'DATETIME', '6', 'Nee', 'Systeemveld')
    )),
    (New-TableXml -Headers @('Tabel', 'Kolom naam', 'Datatype', 'Lengte', 'Nullable', 'Opmerking') -Rows @(
        @('Voertuig', 'Id', 'INT UNSIGNED', '', 'Nee', 'PK, AUTO_INCREMENT'),
        @('Voertuig', 'Kenteken', 'VARCHAR', '10', 'Nee', 'UNIQUE'),
        @('Voertuig', 'Type', 'VARCHAR', '50', 'Nee', ''),
        @('Voertuig', 'Bouwjaar', 'DATE', '', 'Nee', 'Readonly in scenario 04'),
        @('Voertuig', 'Brandstof', 'VARCHAR', '20', 'Nee', 'Diesel, Benzine of Elektrisch'),
        @('Voertuig', 'TypeVoertuigId', 'INT UNSIGNED', '', 'Nee', 'FK naar TypeVoertuig.Id'),
        @('Voertuig', 'IsActief', 'BIT', '1', 'Nee', 'Systeemveld'),
        @('Voertuig', 'Opmerking', 'VARCHAR', '250', 'Ja', 'Systeemveld'),
        @('Voertuig', 'DatumAangemaakt', 'DATETIME', '6', 'Nee', 'Systeemveld'),
        @('Voertuig', 'DatumGewijzigd', 'DATETIME', '6', 'Nee', 'Systeemveld')
    )),
    (New-TableXml -Headers @('Tabel', 'Kolom naam', 'Datatype', 'Lengte', 'Nullable', 'Opmerking') -Rows @(
        @('VoertuigInstructeur', 'Id', 'INT UNSIGNED', '', 'Nee', 'PK, AUTO_INCREMENT'),
        @('VoertuigInstructeur', 'VoertuigId', 'INT UNSIGNED', '', 'Nee', 'FK naar Voertuig.Id'),
        @('VoertuigInstructeur', 'InstructeurId', 'INT UNSIGNED', '', 'Nee', 'FK naar Instructeur.Id'),
        @('VoertuigInstructeur', 'DatumToekenning', 'DATE', '', 'Nee', ''),
        @('VoertuigInstructeur', 'IsActief', 'BIT', '1', 'Nee', 'Systeemveld, actieve koppeling'),
        @('VoertuigInstructeur', 'Opmerking', 'VARCHAR', '250', 'Ja', 'Systeemveld'),
        @('VoertuigInstructeur', 'DatumAangemaakt', 'DATETIME', '6', 'Nee', 'Systeemveld'),
        @('VoertuigInstructeur', 'DatumGewijzigd', 'DATETIME', '6', 'Nee', 'Systeemveld')
    ))
)

$testplanParagraphs = @(
    'Testplan',
    "Naam project: $projectTitle",
    "Naam tester: $studentName",
    "Naam ontwikkelaar: $developerName",
    "Studentnummer: $studentNumber",
    "Datum: $dateText",
    'Versie: 0.1.1',
    'Inleiding: dit testplan beschrijft de acceptatietests voor de user story Wijzigen voertuiggegevens.',
    'Voor testomgeving: lokale PHP-server, MySQL database be_opdracht_7, browser en de gerealiseerde MVC-applicatie.',
    'Beschrijving rol tester: de tester controleert of de scenario’s uit de opdracht correct werken, inclusief validatie en readonly gedrag.'
)

$testplanTables = @(
    (New-TableXml -Headers @('Versie', 'Datum', 'Beschrijving', 'Door') -Rows @(
        @('0.1.1', $dateText, 'Initiele invulling testplan voor backend opdracht 7', $studentName)
    )),
    (New-TableXml -Headers @('Activiteit', 'Document', 'Verantwoording', 'Individueel/Groep', 'Einddatum') -Rows @(
        @('Maken testcases', 'Testplan', 'Tester', 'Individueel', $dateText),
        @('Uitvoeren test', 'Testformulieren en testrapport', 'Tester', 'Individueel', $dateText),
        @('Conclusie trekken', 'Testrapport', 'Tester', 'Individueel', $dateText)
    )),
    (New-TableXml -Headers @('User Story', 'Scenario', 'Gegeven', 'Wanneer', 'Dan') -Rows @(
        @('Wijzigen voertuiggegevens', 'Scenario 01', 'Ingelogd en op scherm Instructeurs in dienst', 'Wijzig Vespa naar Vespa Piaggio, Elektrisch, DRS-52-E', 'Gewijzigde voertuiggegevens zichtbaar bij Mohammed El Yassidi'),
        @('Wijzigen voertuiggegevens', 'Scenario 02', 'Voertuig Vespa Piaggio staat bij Mohammed El Yassidi', 'Wijzig instructeur naar Bert Van Sali', 'Voertuig verdwijnt uit lijst van Mohammed El Yassidi'),
        @('Wijzigen voertuiggegevens', 'Scenario 03', 'Op scherm Alle beschikbare voertuigen', 'Wijzig Kymco brandstof naar Elektrisch en wijs toe aan Mohammed', 'Kymco verschijnt in voertuigenlijst van Mohammed'),
        @('Wijzigen voertuiggegevens', 'Scenario 04', 'Voertuig DAF openen in wijzigscherm', 'Probeer Bouwjaar te wijzigen en klik Wijzig', 'Bouwjaar blijft ongewijzigd')
    )),
    (New-TableXml -Headers @('TestId', 'Ik doe', 'Ik zie', 'Ik verwacht') -Rows @(
        @('1', 'Ik open Mohammed El Yassidi en klik Wijzigen bij Vespa', 'Wijzigformulier met bestaande waarden', 'Formulier opent met ingevulde velden'),
        @('2', 'Ik wijzig Type, Brandstof en Kenteken en klik Wijzig', 'Overzicht voertuigen van Mohammed', 'Vespa Piaggio, Elektrisch en DRS-52-E zijn zichtbaar'),
        @('3', 'Ik wijzig de instructeur van Vespa Piaggio naar Bert Van Sali', 'Overzicht voertuigen van Mohammed', 'Vespa Piaggio staat niet meer bij Mohammed'),
        @('4', 'Ik open beschikbare voertuigen en wijzig Kymco', 'Overzicht voertuigen van Mohammed', 'Kymco is toegevoegd en brandstof is Elektrisch'),
        @('5', 'Ik open DAF en probeer Bouwjaar te wijzigen', 'Bouwjaar veld blijft readonly', 'Bouwjaar kan niet aangepast worden'),
        @('6', 'Ik blader door een overzicht met meer dan 4 regels', 'Pagination onder de tabel', 'Maximaal 4 records per pagina en rustig wisselen van pagina')
    ))
)

$testrapportParagraphs = @(
    'Testrapport',
    "Titel casus: $projectTitle",
    "Naam tester: $studentName",
    "Naam ontwikkelaar: $developerName",
    "Studentnummer: $studentNumber",
    "Datum: $dateText",
    "Klas: $className",
    'Inleiding: dit testrapport beschrijft de resultaten van de acceptatietests op de gerealiseerde user story.',
    'Conclusie: de backend-opdracht ondersteunt de vier scenario’s voor het wijzigen en toewijzen van voertuigen conform de opdracht.'
)

$testrapportTables = @(
    (New-TableXml -Headers @('Versie', 'Opmerkingen', 'Datum', 'Door') -Rows @(
        @('0.1', 'Eerste ingevulde versie van het testrapport', $dateText, $studentName)
    )),
    (New-TableXml -Headers @('Onderdeel', 'Bevinding') -Rows @(
        @('User Story 1', 'Scenario 01 geslaagd: voertuiggegevens van Vespa kunnen gewijzigd worden'),
        @('User Story 1', 'Scenario 02 geslaagd: voertuig kan aan andere instructeur worden toegewezen'),
        @('User Story 1', 'Scenario 03 geslaagd: vrij voertuig kan worden gewijzigd en toegewezen'),
        @('User Story 1', 'Scenario 04 geslaagd: Bouwjaar blijft readonly en ongewijzigd')
    )),
    (New-TableXml -Headers @('Bugs', 'Status') -Rows @(
        @('Geen functionele bugs gevonden tijdens de uitgewerkte scenario-tests', 'Geen open bugs')
    )),
    (New-TableXml -Headers @('Ontbrekend scenario', 'Uitwerking') -Rows @(
        @('Geen extra ontbrekende scenario’s geconstateerd binnen de opdrachtomschrijving', 'N.v.t.')
    )),
    (New-TableXml -Headers @('Nieuwe user story', 'Motivatie') -Rows @(
        @('Als rijschoolhouder wil ik een historie van voertuigtoewijzingen kunnen bekijken zodat ik eerdere wijzigingen kan verantwoorden.', 'Logische vervolgstap op de bestaande stored procedure en toewijzingshistorie')
    ))
)

$databaseXml = New-DocumentXml -Paragraphs $databaseParagraphs -Tables $databaseTables
$testplanXml = New-DocumentXml -Paragraphs $testplanParagraphs -Tables $testplanTables
$testrapportXml = New-DocumentXml -Paragraphs $testrapportParagraphs -Tables $testrapportTables

Write-DocxFromTemplate -SourcePath 'C:\Users\redam\Downloads\Database specificatie tabel-1 (1).docx' -TargetPath (Join-Path $docsRoot 'Database specificatie tabel ingevuld Reda Margai.docx') -DocumentXml $databaseXml
Write-DocxFromTemplate -SourcePath 'C:\Users\redam\Downloads\Testplan-1 (1).docx' -TargetPath (Join-Path $docsRoot 'Testplan ingevuld Reda Margai.docx') -DocumentXml $testplanXml
Write-DocxFromTemplate -SourcePath 'C:\Users\redam\Downloads\Testrapport-1 (1).docx' -TargetPath (Join-Path $docsRoot 'Testrapport ingevuld Reda Margai.docx') -DocumentXml $testrapportXml

Write-Host 'Documenten gegenereerd in docs.'
