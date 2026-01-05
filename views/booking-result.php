<?php

declare(strict_types=1);

?>

<section class="booking-result">
    <div class="result-card">
        <h2>Booking Confirmed!</h2>
        <p class="success-message">Thank you for your reservation. We look forward to haunting you!</p>

        <div class="booking-details">
            <h3>Booking Details</h3>
            <ul>
                <li><strong>Guest:</strong> <?= htmlspecialchars($guestId) ?></li>
                <li><strong>Room:</strong> <?= htmlspecialchars(ucfirst($room)) ?></li>
                <li><strong>Check-in:</strong> <?= htmlspecialchars($checkIn) ?></li>
                <li><strong>Check-out:</strong> <?= htmlspecialchars($checkOut) ?></li>
                <li><strong>Total:</strong> $<?= htmlspecialchars((string)$totalPrice) ?></li>
            </ul>
        </div>

        <?php if (!empty($features)): ?>
            <div class="booking-features">
                <h3>Selected Features </h3>
                <ul>
                    <?php foreach ($features as $feature): ?>
                        <li><?= htmlspecialchars($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn-new-booking">Make another booking</a>
    </div>
</section>