<?php

declare(strict_types=1);

$pageCount = (int) ceil($total / $perPage);
$instructorName = trim(sprintf('%s %s %s', $instructor['Voornaam'], $instructor['Tussenvoegsel'] ?? '', $instructor['Achternaam']));
?>
<h1>Door Instructeur gebruikte voertuigen</h1>

<?php if ($flash !== ''): ?>
    <div class="flash"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div class="meta-block">
    <div>Naam: [<?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?>]</div>
    <div>Datum in dienst : [<?= htmlspecialchars((string) $instructor['DatumInDienst'], ENT_QUOTES, 'UTF-8') ?>]</div>
    <div>Aantal sterren : [<?= htmlspecialchars((string) $instructor['AantalSterren'], ENT_QUOTES, 'UTF-8') ?>]</div>
</div>

<div class="toolbar">
    <a class="btn" href="/vehicles/available?instructor_id=<?= (int) $instructor['Id'] ?>">Toevoegen Voertuig</a>
</div>

<?php if ($vehicles === []): ?>
    <div class="empty">Geen voertuigen gevonden.</div>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Type Voertuig</th>
            <th>Type</th>
            <th>Kenteken</th>
            <th>Bouwjaar</th>
            <th>Brandstof</th>
            <th>Rijbewijscategorie</th>
            <th>Wijzigen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?= htmlspecialchars((string) $vehicle['TypeVoertuig'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $vehicle['Type'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $vehicle['Kenteken'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $vehicle['Bouwjaar'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $vehicle['Brandstof'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $vehicle['Rijbewijscategorie'], ENT_QUOTES, 'UTF-8') ?></td>
                <td class="icon-cell">
                    <a class="icon-link" href="/vehicles/edit?id=<?= (int) $vehicle['Id'] ?>&instructor_id=<?= (int) $instructor['Id'] ?>&origin=assigned" title="Wijzigen" aria-label="Wijzigen">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M5 18.8l3.3-.8 8.4-8.5-2.6-2.6-8.5 8.5z"></path>
                            <path d="M13.9 6.8l2.6 2.6"></path>
                            <path d="M4.6 19.3h4"></path>
                            <path d="M17.2 5.8l1.1 1.1"></path>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ($pageCount > 1): ?>
    <nav class="pagination">
        <?php if ($page > 1): ?>
            <a class="btn" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page - 1 ?>">Vorige</a>
        <?php endif; ?>
        <span>Pagina <?= $page ?> van <?= $pageCount ?></span>
        <?php if ($page < $pageCount): ?>
            <a class="btn" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page + 1 ?>">Volgende</a>
        <?php endif; ?>
    </nav>
<?php endif; ?>
