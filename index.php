<?php

declare(strict_types=1);

require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/functions/booking.php';
require_once __DIR__ . '/app/functions/features.php';


require __DIR__ . '/views/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'guest_id'      => $_POST['guest_id'] ?? null,
        'transfer_code' => $_POST['transfer_code'] ?? null,
        'room'          => $_POST['room'] ?? null,
        'check_in'      => $_POST['check_in'] ?? null,
        'check_out'     => $_POST['check_out'] ?? null,
        'features'      => $_POST['features'] ?? [],
    ];

    $totalPrice = calculateTotalPrice(
        $data['room'],
        $data['check_in'],
        $data['check_out'],
        $data['features']
    );

    $result = saveBooking($db, $data);

    if ($result['success']) {


        $bookingId   = $result['booking_id'];
        $checkIn     = $data['check_in'];
        $checkOut    = $data['check_out'];
        $room        = $data['room'];
        $guestId     = $data['guest_id'];
        $transferCode = $data['transfer_code'];
        $features    = $data['features'];

        require __DIR__ . '/views/booking-result.php';
    } else {
        $errors = $result['errors'];
        require __DIR__ . '/views/booking-form.php';
    }
} else {

    require __DIR__ . '/views/booking-form.php';
}

require __DIR__ . '/views/footer.php';
