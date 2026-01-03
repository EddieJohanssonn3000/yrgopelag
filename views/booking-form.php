<?php

declare(strict_types=1);

?>

<section class="welcome">
    <h2>Welcome to Spooky Island</h2>
    <p>Experience the most haunted hotel in the archipelago. Our rooms come with guaranteed ghost sightings, creaky floors, and mysterious sounds at night.</p>
</section>

<?php if (!empty($errors)): ?>
    <div role="alert" aria-live="polite" class="error-messages">
        <h3>Errors:</h3>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="booking-container">
    <!-- Vänster: Formulär -->
    <div class="booking-left">
        <h2>Book a room</h2>

        <form method="post" action="index.php">
            <!-- Guest_id -->
            <div>
                <label for="guest_id">Name (guest ID)</label>
                <input
                    type="text"
                    id="guest_id"
                    name="guest_id"
                    value="<?= htmlspecialchars($_POST['guest_id'] ?? '') ?>"
                    required>
            </div>

            <!-- Transfer_code -->
            <div>
                <label for="transfer_code">Transfer Code</label>
                <small>Get your transfer code from the <a href="https://www.yrgopelago.se/centralbank" target="_blank" rel="noopener">Central Bank</a></small>
                <input
                    type="text"
                    id="transfer_code"
                    name="transfer_code">
            </div>

            <!-- Check-in -->
            <div>
                <label for="check_in">Check-in</label>
                <input
                    type="date"
                    id="check_in"
                    name="check_in"
                    min="2026-01-01"
                    max="2026-01-31"
                    value="<?= htmlspecialchars($_POST['check_in'] ?? '') ?>"
                    required>
            </div>

            <!-- Check-out -->
            <div>
                <label for="check_out">Check-out</label>
                <input
                    type="date"
                    id="check_out"
                    name="check_out"
                    min="2026-01-02"
                    max="2026-02-01"
                    value="<?= htmlspecialchars($_POST['check_out'] ?? '') ?>"
                    required>
            </div>

            <!-- Room selection -->
            <fieldset>
                <legend>Select room</legend>
                <label>
                    <input type="radio" name="room" value="budget" <?= (($_POST['room'] ?? '') === 'budget') ? 'checked' : '' ?> required>
                    Budget $1/night
                </label>
                <label>
                    <input type="radio" name="room" value="standard" <?= (($_POST['room'] ?? '') === 'standard') ? 'checked' : '' ?>>
                    Standard $2/night
                </label>
                <label>
                    <input type="radio" name="room" value="luxury" <?= (($_POST['room'] ?? '') === 'luxury') ? 'checked' : '' ?>>
                    Luxury $4/night
                </label>
            </fieldset>

            <!-- Features -->
            <fieldset>
                <legend>Select features</legend>

                <h4>Water</h4>
                <label>
                    <input type="checkbox" name="features[]" value="water:economy"
                        <?= in_array('water:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Pool (Economy $2)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="water:basic"
                        <?= in_array('water:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Scuba diving (Basic $5)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="water:premium"
                        <?= in_array('water:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Olympic pool (Premium $10)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="water:superior"
                        <?= in_array('water:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Waterpark with fire & minibar (Superior $17)
                </label>

                <h4>Games</h4>
                <label>
                    <input type="checkbox" name="features[]" value="games:economy"
                        <?= in_array('games:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Yahtzee (Economy $2)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="games:basic"
                        <?= in_array('games:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Ping pong table (Basic $5)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="games:premium"
                        <?= in_array('games:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    PS5 (Premium $10)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="games:superior"
                        <?= in_array('games:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Casino (Superior $17)
                </label>

                <h4>Wheels</h4>
                <label>
                    <input type="checkbox" name="features[]" value="wheels:economy"
                        <?= in_array('wheels:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Unicycle (Economy $2)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="wheels:basic"
                        <?= in_array('wheels:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Bicycle (Basic $5)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="wheels:premium"
                        <?= in_array('wheels:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Trike (Premium $10)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="wheels:superior"
                        <?= in_array('wheels:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Four-wheeled motorized beast (Superior $17)
                </label>

                <h4>Spooky</h4>
                <label>
                    <input type="checkbox" name="features[]" value="hotel:economy"
                        <?= in_array('hotel:economy', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Haunted house access (Economy $2)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="hotel:basic"
                        <?= in_array('hotel:basic', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Ghost tour (Basic $5)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="hotel:premium"
                        <?= in_array('hotel:premium', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Séance with medium (Premium $10)
                </label>
                <label>
                    <input type="checkbox" name="features[]" value="hotel:superior"
                        <?= in_array('hotel:superior', $_POST['features'] ?? []) ? 'checked' : '' ?>>
                    Cursed master suite (Superior $17)
                </label>
            </fieldset>

            <!-- Packages -->
            <fieldset>
                <legend>Available Packages</legend>
                <p><strong>Spooky Weekend Package:</strong> Luxury + Haunted house + Ghost tour = 8$ (save 3$)</p>
                <p><strong>Adventure Package:</strong> Standard + Pool + Bicycle = 7$ (save 2$)</p>
            </fieldset>

            <?php if (isset($totalPrice)): ?>
                <div class="price-preview">
                    <h3>Total price</h3>
                    <?php if (isset($activePackage) && $activePackage): ?>
                        <p class="discount"><?= htmlspecialchars($activePackage['name']) ?>! Save <?= $activePackage['savings'] ?>$!</p>
                    <?php endif; ?>
                    <?php if (isset($discountPercent) && $discountPercent > 0): ?>
                        <p class="discount">Returning guest! <?= $discountPercent ?>% discount applied!</p>
                    <?php endif; ?>
                    <?php if ((isset($activePackage) && $activePackage) || (isset($discountPercent) && $discountPercent > 0)): ?>
                        <p><s><?= $totalPrice + ($packageDiscount ?? 0) + ($discount ?? 0) ?> $</s></p>
                    <?php endif; ?>
                    <p class="total"><strong><?= $totalPrice ?> $</strong></p>
                </div>
            <?php endif; ?>

            <div class="buttons">
                <button type="submit" name="action" value="preview">Calculate price</button>
                <button type="submit" name="action" value="book">Make a reservation</button>
            </div>
        </form>
    </div>

    <!-- Höger: Rumsbilder -->
    <div class="booking-right">
        <h2>Our Rooms</h2>

        <div class="room-card">
            <img src="./assets/images/budgetrooms.jpg" alt="Budget room with simple furnishing">
            <div class="room-info">
                <h3>Budget</h3>
                <span class="price">$1/night</span>
            </div>
            <p>Cozy and haunted. Perfect for the brave budget traveler.</p>
        </div>

        <div class="room-card">
            <img src="./assets/images/standardrooms.jpg" alt="Standard room with comfortable bed">
            <div class="room-info">
                <h3>Standard</h3>
                <span class="price">$2/night</span>
            </div>
            <p>A comfortable stay with occasional ghost visits.</p>
        </div>

        <div class="room-card">
            <img src="./assets/images/luxuryrooms.jpg" alt="Luxury room with premium furnishing">
            <div class="room-info">
                <h3>Luxury</h3>
                <span class="price">$4/night</span>
            </div>
            <p>Premium haunting experience with cursed minibar.</p>
        </div>
    </div>
</div>