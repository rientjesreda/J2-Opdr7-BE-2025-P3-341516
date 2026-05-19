<?php

declare(strict_types=1);
?>
<h1>Wijzigen voertuiggegevens</h1>

<?php if ($error !== ''): ?>
    <div class="flash"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="post" action="/vehicles/update">
    <input type="hidden" name="vehicle_id" value="<?= (int) $vehicle['Id'] ?>">
    <input type="hidden" name="current_instructor_id" value="<?= (int) $instructor['Id'] ?>">
    <input type="hidden" name="origin" value="<?= htmlspecialchars($origin, ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="opmerking" value="">

    <div class="form-row">
        <label for="instructeur_id">Instructeur :</label>
        <select id="instructeur_id" name="instructeur_id" required>
            <?php foreach ($allInstructors as $candidate): ?>
                <?php $candidateName = trim(sprintf('%s %s %s', $candidate['Voornaam'], $candidate['Tussenvoegsel'] ?? '', $candidate['Achternaam'])); ?>
                <option value="<?= (int) $candidate['Id'] ?>" <?= (int) $candidate['Id'] === (int) ($vehicle['InstructeurId'] ?: $instructor['Id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($candidateName, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row">
        <label for="type_voertuig">Type Voertuig :</label>
        <select id="type_voertuig" disabled>
            <option selected><?= htmlspecialchars((string) $vehicle['TypeVoertuig'], ENT_QUOTES, 'UTF-8') ?></option>
        </select>
    </div>

    <div class="form-row">
        <label for="type">Type :</label>
        <input id="type" class="inline-input" type="text" name="type" value="<?= htmlspecialchars((string) $vehicle['Type'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="50">
    </div>

    <div class="form-row">
        <label for="bouwjaar">Bouwjaar :</label>
        <input id="bouwjaar" class="inline-input" type="text" name="bouwjaar" value="<?= htmlspecialchars((string) $vehicle['Bouwjaar'], ENT_QUOTES, 'UTF-8') ?>" readonly>
    </div>

    <div class="form-row">
        <label>Brandstof :</label>
        <div class="radio-group">
            <?php foreach ($fuelTypes as $fuelType): ?>
                <label>
                    <input type="radio" name="brandstof" value="<?= htmlspecialchars($fuelType, ENT_QUOTES, 'UTF-8') ?>" <?= $fuelType === $vehicle['Brandstof'] ? 'checked' : '' ?>>
                    <?= htmlspecialchars($fuelType, ENT_QUOTES, 'UTF-8') ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-row">
        <label for="kenteken">Kenteken :</label>
        <input id="kenteken" class="inline-input" type="text" name="kenteken" value="<?= htmlspecialchars((string) $vehicle['Kenteken'], ENT_QUOTES, 'UTF-8') ?>" required>
    </div>

    <div class="submit-row">
        <button type="submit">Wijzig</button>
    </div>
</form>
