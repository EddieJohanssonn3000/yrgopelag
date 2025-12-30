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
        <label for="guest_id">Name (guest ID)</label><br>
        <input
            type="text"
            id="guest_id"
            name="guest_id"
            value="<?= htmlspecialchars($_POST['guest_id'] ?? '') ?>"
            required>
    </div>

    <br>

    <!-- Transfer_code -->
    <div>
        <label for="transfer_code">Transfer Code</label><br>
        <input
            type="text"
            id="transfer_code"
            name="transfer_code">
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
            value="<?= htmlspecialchars($_POST['check_in'] ?? '') ?>"
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
            value="<?= htmlspecialchars($_POST['check_out'] ?? '') ?>"
            required>
    </div>

    <br>

    <!-- Room selection -->
    <fieldset>
        <legend>Välj rum</legend>

        <label>
            <input type="radio" name="room" value="budget" <?= (($_POST['room'] ?? '') === 'budget') ? 'checked' : '' ?>
                required>
            Budget 1$
        </label><br>

        <label>
            <input type="radio" name="room" value="standard" <?= (($_POST['room'] ?? '') === 'standard') ? 'checked' : '' ?>>
            Standard 2$
        </label><br>

        <label>
            <input type="radio" name="room" value="luxury" <?= (($_POST['room'] ?? '') === 'luxury') ? 'checked' : '' ?>>
            Luxury 4$
        </label>
    </fieldset>

    <br>

    <!-- Features -->
    <fieldset>
        <legend>Välj tillval / Features</legend>

        <!-- Water -->
        <h4>Water</h4>
        <label>
            <input type="checkbox" name="features[]" value="water:economy"
                <?= in_array('water:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Pool (Economy $2)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="water:basic"
                <?= in_array('water:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Scuba diving (Basic $5)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="water:premium"
                <?= in_array('water:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Olympic pool (Premium $10)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="water:superior"
                <?= in_array('water:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Waterpark with fire & minibar (Superior $17)
        </label>

        <!-- Games -->
        <h4>Games</h4>
        <label>
            <input type="checkbox" name="features[]" value="games:economy"
                <?= in_array('games:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Yahtzee (Economy $2)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="games:basic"
                <?= in_array('games:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Ping pong table (Basic $5)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="games:premium"
                <?= in_array('games:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            PS5 (Premium $10)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="games:superior"
                <?= in_array('games:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Casino (Superior $17)
        </label>

        <!-- Wheels -->
        <h4>Wheels</h4>
        <label>
            <input type="checkbox" name="features[]" value="wheels:economy"
                <?= in_array('wheels:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Unicycle (Economy $2)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="wheels:basic"
                <?= in_array('wheels:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Bicycle (Basic $5)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="wheels:premium"
                <?= in_array('wheels:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Trike (Premium $10)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="wheels:superior"
                <?= in_array('wheels:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Four-wheeled motorized beast (Superior $17)
        </label>

        <!-- Hotel-specific (Spooky) -->
        <h4>Spooky</h4>
        <label>
            <input type="checkbox" name="features[]" value="hotel:economy"
                <?= in_array('hotel:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Haunted house access (Economy $2)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="hotel:basic"
                <?= in_array('hotel:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Ghost tour (Basic $5)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="hotel:premium"
                <?= in_array('hotel:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Séance with medium (Premium $10)
        </label><br>

        <label>
            <input type="checkbox" name="features[]" value="hotel:superior"
                <?= in_array('hotel:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
            Cursed master suite (Superior $17)
        </label>
    </fieldset>

    <br>

    <?php if (isset($totalPrice)): ?>
        <div class="price-preview">
            <h3>Total price</h3>
            <?php if (isset($discountPercent) && $discountPercent > 0): ?>
                <p>Returning guest! <?= $discountPercent ?>% discount applied!</p>
                <p><s><?= $totalPrice + $discount ?> $</s></p>
            <?php endif; ?>
            <p><strong><?= $totalPrice ?> $</strong></p>
        </div>
    <?php endif; ?>

    <button type="submit" name="action" value="preview">Calculate price</button>

    <button type="submit" name="action" value="book">Make a reservation</button>


</form>