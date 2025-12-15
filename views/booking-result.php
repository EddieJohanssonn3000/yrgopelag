<?php

declare(strict_types=1);
?>

<h2>Din bokning</h2>

<ul>
    <li><strong>Check-in:</strong> <?= htmlspecialchars($checkIn) ?></li>
    <li><strong>Check-out:</strong> <?= htmlspecialchars($checkOut) ?></li>
    <li><strong>Rum:</strong> <?= htmlspecialchars($room) ?></li>
</ul>

<a href="/">Gör en ny bokning</a>