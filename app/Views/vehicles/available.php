<?php

declare(strict_types=1);

$pageCount = (int) ceil($total / $perPage);
$instructorName = trim(sprintf('%s %s %s', $instructor['Voornaam'], $instructor['Tussenvoegsel'] ?? '', $instructor['Achternaam']));
?>
<section class="hero">
    <div>
        <p class="chip">Scenario 03</p>
        <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Beschikbare voertuigen die nog niet zijn gekoppeld aan een instructeur. Vanuit hier kun je een voertuig wijzigen en tegelijk toewijzen aan <?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?>.</p>
    </div>
</section>

<section class="card">
    <div class="toolbar">
        <strong>Doelinstructeur: <?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?></strong>
        <a class="btn btn-secondary" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>">Terug naar toegewezen voertuigen</a>
    </div>

    <?php if ($vehicles === []): ?>
        <div class="empty">Er zijn op dit moment geen vrije voertuigen beschikbaar.</div>
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
                        <a class="btn" href="/vehicles/edit?id=<?= (int) $vehicle['Id'] ?>&instructor_id=<?= (int) $instructor['Id'] ?>&origin=available">Wijzigen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($pageCount > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a class="btn btn-secondary" href="/vehicles/available?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page - 1 ?>">Vorige</a>
            <?php endif; ?>
            <span class="meta">Pagina <?= $page ?> van <?= $pageCount ?></span>
            <?php if ($page < $pageCount): ?>
                <a class="btn btn-secondary" href="/vehicles/available?instructor_id=<?= (int) $instructor['Id'] ?>&page=<?= $page + 1 ?>">Volgende</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>
