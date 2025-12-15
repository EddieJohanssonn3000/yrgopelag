<?php

declare(strict_types=1);

require __DIR__ . '/app/config/database.php';
require __DIR__ . '/app/functions/booking.php';

require __DIR__ . '/views/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = saveBooking($db, $_POST);

    if ($result['success']) {
        $bookingId = $result['booking_id'];
        require __DIR__ . '/views/booking-result.php';
    } else {
        $errors = $result['errors'];
        require __DIR__ . '/views/booking-form.php';
    }
} else {
    require __DIR__ . '/views/booking-form.php';
}

require __DIR__ . '/views/footer.php';
