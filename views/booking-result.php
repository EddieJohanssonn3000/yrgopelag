<?php

declare(strict_types=1); ?>

<h2>Din bokning</h2>

<ul>
    <li><strong>Check-in:</strong> <?= htmlspecialchars($checkIn) ?></li>
    <li><strong>Check-out:</strong> <?= htmlspecialchars($checkOut) ?></li>
    <li><strong>Rum:</strong> <?= htmlspecialchars($room) ?></li>
    <li><strong>Gäst-ID:</strong> <?= htmlspecialchars($guestId) ?></li>
    <li><strong>Totalpris:</strong> <?= htmlspecialchars((string)$totalPrice) ?></li>
</ul>

<?php if (!empty($features)): ?>
    <h3>Valda features</h3>
    <ul>
        <?php foreach ($features as $feature): ?>
            <li><?= htmlspecialchars($feature) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="/">Gör en ny bokning</a>