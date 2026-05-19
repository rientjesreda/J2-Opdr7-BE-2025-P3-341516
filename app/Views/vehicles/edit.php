<?php

declare(strict_types=1);

$instructorName = trim(sprintf('%s %s %s', $instructor['Voornaam'], $instructor['Tussenvoegsel'] ?? '', $instructor['Achternaam']));
?>
<section class="hero">
    <div>
        <p class="chip">Wijzigen voertuiggegevens</p>
        <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Werk de voertuiggegevens bij en pas eventueel de verantwoordelijke instructeur aan. Het veld bouwjaar is readonly zoals beschreven in scenario 04.</p>
    </div>
</section>

<section class="card">
    <?php if ($error !== ''): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="toolbar">
        <strong>Huidige context: <?= htmlspecialchars($instructorName, ENT_QUOTES, 'UTF-8') ?></strong>
        <?php if ($origin === 'available'): ?>
            <a class="btn btn-secondary" href="/vehicles/available?instructor_id=<?= (int) $instructor['Id'] ?>">Terug naar beschikbare voertuigen</a>
        <?php else: ?>
            <a class="btn btn-secondary" href="/vehicles?instructor_id=<?= (int) $instructor['Id'] ?>">Terug naar toegewezen voertuigen</a>
        <?php endif; ?>
    </div>

    <form method="post" action="/vehicles/update">
        <input type="hidden" name="vehicle_id" value="<?= (int) $vehicle['Id'] ?>">
        <input type="hidden" name="current_instructor_id" value="<?= (int) $instructor['Id'] ?>">
        <input type="hidden" name="origin" value="<?= htmlspecialchars($origin, ENT_QUOTES, 'UTF-8') ?>">

        <div class="grid">
            <label>
                Kenteken
                <input type="text" name="kenteken" value="<?= htmlspecialchars((string) $vehicle['Kenteken'], ENT_QUOTES, 'UTF-8') ?>" required>
            </label>

            <label>
                Type
                <input type="text" name="type" value="<?= htmlspecialchars((string) $vehicle['Type'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="50">
            </label>

            <label>
                Brandstof
                <select name="brandstof" required>
                    <?php foreach ($fuelTypes as $fuelType): ?>
                        <option value="<?= htmlspecialchars($fuelType, ENT_QUOTES, 'UTF-8') ?>" <?= $fuelType === $vehicle['Brandstof'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fuelType, ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                Instructeur
                <select name="instructeur_id" required>
                    <?php foreach ($allInstructors as $candidate): ?>
                        <?php $candidateName = trim(sprintf('%s %s %s', $candidate['Voornaam'], $candidate['Tussenvoegsel'] ?? '', $candidate['Achternaam'])); ?>
                        <option value="<?= (int) $candidate['Id'] ?>" <?= (int) $candidate['Id'] === (int) ($vehicle['InstructeurId'] ?: $instructor['Id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($candidateName, ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                Bouwjaar
                <input type="text" name="bouwjaar" value="<?= htmlspecialchars((string) $vehicle['Bouwjaar'], ENT_QUOTES, 'UTF-8') ?>" readonly>
            </label>

            <label>
                Type voertuig
                <input type="text" value="<?= htmlspecialchars((string) $vehicle['TypeVoertuig'], ENT_QUOTES, 'UTF-8') ?>" readonly>
            </label>

            <label>
                Rijbewijscategorie
                <input type="text" value="<?= htmlspecialchars((string) $vehicle['Rijbewijscategorie'], ENT_QUOTES, 'UTF-8') ?>" readonly>
            </label>

            <label>
                Opmerking
                <input type="text" name="opmerking" value="" maxlength="250" placeholder="Optionele wijzigingsnotitie">
            </label>
        </div>

        <div class="actions">
            <button type="submit">Wijzig</button>
        </div>
    </form>
</section>
