<?php

declare(strict_types=1);

$pageCount = (int) ceil($total / $perPage);

$nameFor = static function (array $instructor): string {
    return trim(sprintf(
        '%s %s %s',
        $instructor['Voornaam'],
        $instructor['Tussenvoegsel'] ?? '',
        $instructor['Achternaam']
    ));
};
?>
<section class="hero">
    <div>
        <p class="chip">Homepage link naar instructeurs in dienst</p>
        <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Alle actieve instructeurs, gesorteerd op aantal sterren aflopend. De voertuigkolom opent het overzicht van de aan een instructeur toegewezen voertuigen.</p>
    </div>
</section>

<section class="card">
    <?php if ($flash !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="toolbar">
        <strong>Totaal actieve instructeurs: <?= (int) $total ?></strong>
        <span class="meta">Pagination staat op maximaal 4 records per pagina.</span>
    </div>

    <table>
        <thead>
        <tr>
            <th>Naam</th>
            <th>Mobiel</th>
            <th>Datum in dienst</th>
            <th>Aantal sterren</th>
            <th>Voertuigen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($instructors as $instructor): ?>
            <tr>
                <td data-label="Naam"><?= htmlspecialchars($nameFor($instructor), ENT_QUOTES, 'UTF-8') ?></td>
                <td data-label="Mobiel"><?= htmlspecialchars((string) $instructor['Mobiel'], ENT_QUOTES, 'UTF-8') ?></td>
                <td data-label="Datum in dienst"><?= htmlspecialchars((string) $instructor['DatumInDienst'], ENT_QUOTES, 'UTF-8') ?></td>
                <td data-label="Aantal sterren"><?= htmlspecialchars((string) $instructor['AantalSterren'], ENT_QUOTES, 'UTF-8') ?></td>
                <td data-label="Voertuigen">
                    <a class="btn" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>">Bekijk voertuigen</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($pageCount > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a class="btn btn-secondary" href="/instructors?page=<?= $page - 1 ?>">Vorige</a>
            <?php endif; ?>
            <span class="meta">Pagina <?= $page ?> van <?= $pageCount ?></span>
            <?php if ($page < $pageCount): ?>
                <a class="btn btn-secondary" href="/instructors?page=<?= $page + 1 ?>">Volgende</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>
