<?php

declare(strict_types=1);

?>

<h2>Boka rum</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="index.php">

    <!-- Guest_id -->
    <div>
        <label for="guest_id">Guest ID</label><br>
        <input
            type="text"
            id="guest_id"
            name="guest_id"
            required>
    </div>

    <br>

    <!-- Transfer_code -->
    <div>
        <label for="transfer_code">Transfer Code</label><br>
        <input
            type="text"
            id="transfer_code"
            name="transfer_code"
            required>
    </div>

    <br>

    <!-- Check-in -->
    <div>
        <label for="check_in">Check-in</label><br>
        <input
            type="date"
            id="check_in"
            name="check_in"
            min="2026-01-01"
            max="2026-01-31"
            required>
    </div>

    <br>

    <!-- Check-out -->
    <div>
        <label for="check_out">Check-out</label><br>
        <input
            type="date"
            id="check_out"
            name="check_out"
            min="2026-01-02"
            max="2026-02-01"
            required>
    </div>

    <br>

    <!-- Room selection -->
    <fieldset>
        <legend>Välj rum</legend>

        <label>
            <input type="radio" name="room" value="budget" required>
            Budget
        </label><br>

        <label>
            <input type="radio" name="room" value="standard">
            Standard
        </label><br>

        <label>
            <input type="radio" name="room" value="luxury">
            Luxury
        </label>
    </fieldset>

    <br>

    <button type="submit">Sök tillgänglighet</button>

</form>