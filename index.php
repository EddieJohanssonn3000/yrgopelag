<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $checkIn  = $_POST['check_in'] ?? null;
    $checkOut = $_POST['check_out'] ?? null;
    $room     = $_POST['room'] ?? null;

    $errors = [];

    if (!$checkIn || !$checkOut || !$room) {
        $errors[] = 'Alla fält måste fyllas i.';
    }

    if ($checkIn && $checkOut && $checkOut <= $checkIn) {
        $errors[] = 'Utcheckningsdatum måste vara efter incheckningsdatum.';
    }

    if (!empty($errors)) {
        require __DIR__ . '/views/booking-form.php';
    } else {
        require __DIR__ . '/views/booking-result.php';
    }
} else {
    require __DIR__ . '/views/booking-form.php';
}

require __DIR__ . '/views/footer.php';
