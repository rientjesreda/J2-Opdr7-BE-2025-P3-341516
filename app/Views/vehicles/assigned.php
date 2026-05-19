<?php

declare(strict_types=1);

$pageCount = (int) ceil($total / $perPage);
$instructorName = trim(sprintf('%s %s %s', $instructor['Voornaam'], $instructor['Tussenvoegsel'] ?? '', $instructor['Achternaam']));
?>
<section class="hero">
    <div>
        <p class="chip">Scenario 01, 02 en 04</p>
        <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Voertuigen van <?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?>, gesorteerd op rijbewijscategorie. Hier kun je bestaande toewijzingen wijzigen.</p>
    </div>
</section>

<section class="card">
    <?php if ($flash !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="toolbar">
        <div>
            <strong><?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?></strong>
            <div class="meta"><?= htmlspecialchars((string) $instructor['AantalSterren'], ENT_QUOTES, 'UTF-8') ?> sterren</div>
        </div>
        <div class="actions">
            <a class="btn btn-secondary" href="/instructors">Terug naar instructeurs</a>
            <a class="btn" href="/vehicles/available?instructor_id=<?= (int) $instructor['Id'] ?>">Toevoegen voertuig</a>
        </div>
    </div>

    <?php if ($vehicles === []): ?>
        <div class="empty">Deze instructeur heeft momenteel geen toegewezen voertuigen.</div>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Kenteken</th>
                <th>Type</th>
                <th>Brandstof</th>
                <th>Rijbewijscategorie</th>
                <th>Bouwjaar</th>
                <th>Actie</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td data-label="Kenteken"><?= htmlspecialchars((string) $vehicle['Kenteken'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td data-label="Type"><?= htmlspecialchars((string) $vehicle['Type'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td data-label="Brandstof"><?= htmlspecialchars((string) $vehicle['Brandstof'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td data-label="Rijbewijscategorie"><?= htmlspecialchars((string) $vehicle['Rijbewijscategorie'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td data-label="Bouwjaar"><?= htmlspecialchars((string) $vehicle['Bouwjaar'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td data-label="Actie">
                        <a class="btn" href="/vehicles/edit?id=<?= (int) $vehicle['Id'] ?>&instructor_id=<?= (int) $instructor['Id'] ?>&origin=assigned">Wijzigen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($pageCount > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a class="btn btn-secondary" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page - 1 ?>">Vorige</a>
            <?php endif; ?>
            <span class="meta">Pagina <?= $page ?> van <?= $pageCount ?></span>
            <?php if ($page < $pageCount): ?>
                <a class="btn btn-secondary" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page + 1 ?>">Volgende</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>
