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
<h1>Instructeurs in dienst</h1>

<?php if ($flash !== ''): ?>
    <div class="flash"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div class="meta-block">
    <div>Aantal instructeurs : [<?= (int) $total ?>]</div>
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
            <td><?= htmlspecialchars($nameFor($instructor), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $instructor['Mobiel'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $instructor['DatumInDienst'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $instructor['AantalSterren'], ENT_QUOTES, 'UTF-8') ?></td>
            <td class="icon-cell">
                <a class="icon-link" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>" title="Voertuigen" aria-label="Voertuigen">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 14.5l1.8-4.3c.3-.8 1.1-1.2 1.9-1.2h8.5c.9 0 1.6.5 1.9 1.3l1.4 4.2"></path>
                        <path d="M3.8 14.5h16.4v2.7c0 .6-.5 1.1-1.1 1.1h-1.6v-1.7H6.5v1.7H4.9c-.6 0-1.1-.5-1.1-1.1z"></path>
                        <path d="M7.3 9l.9-2.3h7.2l.9 2.3"></path>
                        <circle cx="7.2" cy="14.8" r="1.2"></circle>
                        <circle cx="16.8" cy="14.8" r="1.2"></circle>
                        <path d="M8.6 12.3h6.8"></path>
                    </svg>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if ($pageCount > 1): ?>
    <nav class="pagination">
        <?php if ($page > 1): ?>
            <a class="btn" href="/instructors?page=<?= $page - 1 ?>">Vorige</a>
        <?php endif; ?>
        <span>Pagina <?= $page ?> van <?= $pageCount ?></span>
        <?php if ($page < $pageCount): ?>
            <a class="btn" href="/instructors?page=<?= $page + 1 ?>">Volgende</a>
        <?php endif; ?>
    </nav>
<?php endif; ?>
